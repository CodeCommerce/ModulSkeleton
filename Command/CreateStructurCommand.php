<?php

namespace CodeCommerce\ModulSkeleton\Command;

use CodeCommerce\ModulSkeleton\Controller\ModuleGeneratorController;
use CodeCommerce\ModulSkeleton\Model\ComposerVendorFile;
use CodeCommerce\ModulSkeleton\Model\SkeletonConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CreateStructurCommand
 * @package CodeCommerce\ModulSkeleton\Command
 */
class CreateStructurCommand extends Command
{
    /**
     * @var string
     */
    protected $sYmlConfigurationPath = __DIR__ . "/../Config/module_skeleton_configuration.yml";
    /**
     * @var array
     */
    protected $aConfiguration = [];
    /**
     * @var array
     */
    protected $aUserInput = [];

    /**
     * @var SkeletonConfiguration
     */
    protected $oSkeletonConfiguration;

    /**
     * @var ComposerVendorFile
     */
    protected $oComposerVendorFile;

    /**
     * configration of command
     */
    protected function configure()
    {
        $this->setConfiguration();

        $this
            // the name of the command (the part after "bin/console")
            ->setName('oxid:module:create')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a modul skeleton.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a modul skeleton...')
            ->addArgument('modulname', InputArgument::OPTIONAL, 'Name of the Modul');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            // outputs multiple lines to the console (adding "\n" at the end of each line)
            $output->writeln([
                '==============',
                'Modul Skeleton',
                '==============',
                '',
            ]);
            $output->writeln('Arguments');

            $this->checkConfigurationExists($output);

            $this->setUserInputModuleSettings($input, $output);
            $this->setUserInputComposerJson($input, $output);

            $this->outputUserInputSettings($output);
            $this->getUserInputModuleGenerationConfirmation($input, $output);
            $this->setUserInputToComposerVendorFile();
            $this->checkIfModuleExistsAndGenerateModule($input, $output);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            exit();
        }
        $output->writeln([
            '<info>',
            '===========================',
            '===========================',
            'Modul generated successfull',
            '</info>',
        ]);
    }

    protected function checkIfModuleExistsAndGenerateModule(InputInterface $input, OutputInterface $output)
    {
        $oModuleGenerator = new ModuleGeneratorController($this->oSkeletonConfiguration, $this->oComposerVendorFile);

        if ($oModuleGenerator->checkIfModuleExists()) {
            $output->writeln('<error>Modulename exists - please set new</error>');
            $this->oComposerVendorFile->setModulName($this->setUserInputModuleName($input, $output));
            $this->checkIfModuleExistsAndGenerateModule($input, $output);
        } else {
            $this->startModuleGeneration($oModuleGenerator);
        }
    }

    /**
     * read configuration from yaml and set it
     */
    protected function setConfiguration()
    {
        if (file_exists($this->sYmlConfigurationPath)) {
            $this->aConfiguration = Yaml::parse(file_get_contents($this->sYmlConfigurationPath));
            $this->setSkeletonConfiguration();
        }
    }

    /**
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function checkConfigurationExists(OutputInterface $output)
    {
        if (empty($this->aConfiguration)) {
            throw new \Exception('<error>Configurationfile under ' . $this->sYmlConfigurationPath . ' missing!</error>');
        }
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     * @throws \Exception
     */
    protected function setUserInputModuleName(InputInterface $input, OutputInterface $output): string
    {
        if ($sModuleName = $input->getArgument('modulname')) {
            $output->writeln('Modulname: ' . $input->getArgument('modulname'));
        } else {
            $helper = $this->getHelper('question');
            $question = new Question('Please enter the name of the modul: ');
            $question->setValidator(function ($answer) {
                if (!is_string($answer)) {
                    throw new \RuntimeException(
                        'Please fill in your modulname'
                    );
                }

                return $answer;
            });
            $question->setMaxAttempts(5);
            if (!$sModuleName = $helper->ask($input, $output, $question)) {
                throw new \Exception('<error>Modulename missing. Stopping generation.</error>');
            }
        }

        return $sModuleName;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    protected function getUserInputVendorSettingsName(InputInterface $input, OutputInterface $output): string
    {
        if ($this->hasMultipleVendorsSettings()) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please choose your vendor settings: ',
                array_keys($this->aConfiguration['vendor'])
            );
            $question->setErrorMessage('Vendor %s is not valid');

            return $helper->ask($input, $output, $question);
        } else {
            return key($this->aConfiguration['vendor']);
        }
    }

    protected function hasMultipleVendorsSettings()
    {
        if (count($this->aConfiguration['vendor']) > 1) {
            return true;
        }

        return false;
    }

    protected function hasMultipleAuthorSettings()
    {
        if (count($this->aConfiguration['authors']) > 1) {
            return true;
        }

        return false;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    protected function getUserInputAuthorSettingsName(InputInterface $input, OutputInterface $output): string
    {
        if ($this->hasMultipleAuthorSettings()) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please choose your author settings: ',
                array_keys($this->aConfiguration['authors'])
            );
            $question->setErrorMessage('Author %s is not valid');

            return $helper->ask($input, $output, $question);
        } else {
            return key($this->aConfiguration['authors']);
        }
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return bool
     * @throws \Exception
     */
    protected function getUserInputModuleGenerationConfirmation(InputInterface $input, OutputInterface $output): bool
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            '<question>Continue with this modulegeneration? (Y/N)</question>',
            true,
            '/^(y|j)/i'
        );
        $question->setMaxAttempts(3);
        if (!$helper->ask($input, $output, $question)) {
            throw new \Exception('<error>Stopping generation</error>');
        }

        return true;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function getUserInputComposerSettings(InputInterface $input, OutputInterface $output)
    {
        $this->aUserInput['composer_json']['version'] = $this->getComposerJsonVersion($input, $output);
        $this->aUserInput['composer_json']['description'] = $this->getComposerJsonDescription($input, $output);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    protected function getComposerJsonVersion(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the version: ');
        $question->setValidator(function ($answer) {
            if (!is_string($answer)) {
                throw new \RuntimeException(
                    'Please enter the version: '
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);
        if (!$sVersion = $helper->ask($input, $output, $question)) {
            throw new \Exception('<error>Version missing. Stopping generation.</error>');
        }

        return $sVersion;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    protected function getComposerJsonDescription(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the description: ');
        $question->setValidator(function ($answer) {
            if (!is_string($answer)) {
                throw new \RuntimeException(
                    'Please enter the description: '
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);
        if (!$sVersion = $helper->ask($input, $output, $question)) {
            throw new \Exception('<error>Version missing. Stopping generation.</error>');
        }

        return $sVersion;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function setUserInputComposerJson(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '======================',
            'Composer.json settings',
            '======================',
        ]);

        $this->getUserInputComposerSettings($input, $output);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function setUserInputModuleSettings(InputInterface $input, OutputInterface $output)
    {
        /**
         * @todo check if modulename is set before - question if overwrite
         */
        $this->aUserInput['vendor_name'] = $this->getUserInputVendorSettingsName($input, $output);
        $this->aUserInput['author_name'] = $this->getUserInputAuthorSettingsName($input, $output);
        $this->aUserInput['module_name'] = $this->setUserInputModuleName($input, $output);
    }

    /**
     * @param OutputInterface $output
     */
    protected function outputUserInputSettings(OutputInterface $output)
    {
        $output->writeln([
            '<info>==============</info>',
            '<info>Your settings</info>',
            '<info>==============</info>',
            'Modulename: ' . $this->aUserInput['module_name'],
            'Vendor: ' . $this->aUserInput['vendor_name'],
            'Author: ' . $this->aUserInput['author_name'],
            '<info>==============</info>',
            '<info>Composer</info>',
            'Version: ' . $this->aUserInput['composer_json']['version'],
            'Description: ' . $this->aUserInput['composer_json']['description'],
        ]);
    }

    /**
     *
     */
    protected function setUserInputToComposerVendorFile()
    {
        $this->oComposerVendorFile = new ComposerVendorFile();
        $this->oComposerVendorFile
            ->setModulName($this->aUserInput['module_name'])
            ->setVendorNamespace($this->aConfiguration['vendor'][$this->aUserInput['vendor_name']]['namespace'])
            ->setVendorHomepage($this->aConfiguration['vendor'][$this->aUserInput['vendor_name']]['homepage'])
            ->setVendorEmail($this->aConfiguration['vendor'][$this->aUserInput['vendor_name']]['email'])
            ->setAuthorName($this->aConfiguration['authors'][$this->aUserInput['author_name']]['name'])
            ->setAuthorEmail($this->aConfiguration['authors'][$this->aUserInput['author_name']]['email'])
            ->setAuthorHomepage($this->aConfiguration['authors'][$this->aUserInput['author_name']]['homepage'])
            ->setComposerVersion($this->aUserInput['composer_json']['version'])
            ->setComposerDescription($this->aUserInput['composer_json']['description']);
    }

    /**
     *
     */
    protected function setSkeletonConfiguration()
    {
        $this->oSkeletonConfiguration = new SkeletonConfiguration();

        if ($aSkeletonConfiguration = Yaml::parse(file_get_contents($this->sYmlConfigurationPath))) {
            $this->oSkeletonConfiguration
                ->setBasePath($aSkeletonConfiguration['parameters']['basepath'])
                ->setModulBasePath($aSkeletonConfiguration['parameters']['modulebasepath'])
                ->setGenerateFileStructur($aSkeletonConfiguration['filestructur']['generate_directories'])
                ->setFileStructurDirectories($aSkeletonConfiguration['filestructur']['directories'])
                ->setGenerateFiles($aSkeletonConfiguration['filestructur']['generate_files'])
                ->setFileToGenerate($aSkeletonConfiguration['filestructur']['files'])
                ->setComposerUpdate($aSkeletonConfiguration['parameters']['composer_update'])
                ->setMetadata($aSkeletonConfiguration['metadata']);
        }
    }

    /**
     *
     */
    protected function startModuleGeneration(ModuleGeneratorController $oModuleGenerator)
    {
        $oModuleGenerator->generateModule();
    }
}