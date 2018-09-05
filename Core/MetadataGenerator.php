<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 05.09.18
 * Time: 15:01
 */

namespace CodeCommerce\ModulSkeleton\Core;


use CodeCommerce\ModulSkeleton\Model\MetadataFile;

class MetadataGenerator extends FileStructorGenerator
{
    protected $oMetadataFile;

    public function __construct(MetadataFile $oMetadataFile = null)
    {
        if (null !== $oMetadataFile) {
            $this->oMetadataFile = $oMetadataFile;
            $this->generateMetadataFile();
        }
    }

    public function setMetadataFile(MetadataFile $oMetadataFile)
    {
        $this->oMetadataFile = $oMetadataFile;
    }

    public function generateMetadataFile()
    {
        if (is_a($this->oMetadataFile, MetadataFile::class)) {
            $this->generateIfNotExists($this->oMetadataFile->getPath());
            $sContent = $this->getMetadataContent();
            $this->writeFile($this->oMetadataFile->getPath(), $sContent);
        }
    }

    /**
     * @todo add console command for description / title usw.
     */
    protected function getMetadataContent()
    {
        $sTemplateContent = $this->getMetadataTemplateFile();
        $sTemplateContent = str_replace('##metadata_version##', $this->oMetadataFile->getVersion(), $sTemplateContent);
        $sTemplateContent = str_replace('##module_name##', $this->oMetadataFile->getName(), $sTemplateContent);
        $sTemplateContent = str_replace('##module_title##', $this->oMetadataFile->getTitle(), $sTemplateContent);
        $sTemplateContent = str_replace('##module_description##', $this->oMetadataFile->getDescription(),
            $sTemplateContent);
        $sTemplateContent = str_replace('##module_thumbnail##', $this->oMetadataFile->getThumbnail(),
            $sTemplateContent);
        $sTemplateContent = str_replace('##module_version##', $this->oMetadataFile->getModuleVersion(),
            $sTemplateContent);
        $sTemplateContent = str_replace('##module_author##', 'Author', $sTemplateContent);
        $sTemplateContent = str_replace('##module_email##', 'Email', $sTemplateContent);
        $sTemplateContent = str_replace('##module_url##', 'Url', $sTemplateContent);

        return $sTemplateContent;
    }

    protected function getMetadataTemplateFile()
    {
        $sFilePath = __DIR__ . "/../Config/Templates/metadata.php";
        if (file_exists($sFilePath)) {
            return $this->readFile($sFilePath);
        }
    }
}