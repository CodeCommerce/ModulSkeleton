<?php

namespace CodeCommerce\ModuleSkeleton\Core;

/**
 * Class ComposerGenerator
 * @package CodeCommerce\ModuleSkeleton\Core
 */

use CodeCommerce\ModuleSkeleton\Model\ComposerFile;

// use CodeCommerce\ModuleSkeleton\Model\ComposerVendorSettings;

/**
 * Class ComposerGenerator
 * @package CodeCommerce\ModuleSkeleton\Core
 */
class ComposerGenerator extends FileStructorGenerator
{
    /**
     * @var
     */
    protected $oFileHandle;
    /**
     * @var
     */
    protected $oSettings;
    /**
     * @var null
     */
    protected $sFilePath;

    /**
     * @var ComposerFile
     */
    protected $oComposerFile;

    /**
     * ComposerGenerator constructor.
     * @param null $sFile
     */
    public function __construct($sFile = null)
    {
        if (null !== $sFile) {
            $this->sFilePath = $sFile;
            $this->generateIfNotExists();
            $this->loadComposerFile();
        }
    }

    /**
     * @param $sFilePath
     * @return $this
     */
    public function setFilePath($sFilePath)
    {
        $this->sFilePath = $sFilePath;

        return $this;
    }

    /**
     * @return null
     */
    public function getFilePath()
    {
        return $this->sFilePath;
    }

    /**
     * @param $sFilePath
     * @return mixed
     */
    public function readComposerFile($sFilePath = null)
    {
        $sConent = $this->readFile($sFilePath);
        $oComposer = json_decode($sConent);

        return $oComposer;
    }

    public function modifyArrayToJson($aContent)
    {
        return json_encode($aContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function updateComposerArrayField($aUpdateArray)
    {
        foreach ($aUpdateArray as $sKey => $aData) {
            foreach ($aData as $sField => $sValue) {
                $this->oComposerFile->updateArrayFieldWithValue($sKey, $sField, $sValue);
            }
        }
    }

    protected function loadComposerFile($sFilePath = null)
    {
        try {
            if ($sFilePath === null && $this->sFilePath === null) {
                throw new \Exception('No composerfilepath set');
            }

            if (null !== $sFilePath) {
                $this->sFilePath = $sFilePath;
            }

            $oContent = $this->readComposerFile($this->sFilePath);
            $this->oComposerFile = new ComposerFile($oContent);

        } catch (\Exception $e) {
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            exit();
        }
    }

    public function saveComposerFile()
    {
        $this->writeFile($this->sFilePath, $this->modifyArrayToJson($this->oComposerFile->getContent()));
    }

    public function addContent($oContent)
    {
        $this->oComposerFile->setContent($oContent);
    }
}