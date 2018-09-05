<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 04.09.18
 * Time: 16:21
 */

namespace CodeCommerce\ModulSkeleton\Model;


/**
 * Class SkeletonConfiguration
 * @package CodeCommerce\ModulSkeleton\Model
 */
/**
 * Class SkeletonConfiguration
 * @package CodeCommerce\ModulSkeleton\Model
 */
/**
 * Class SkeletonConfiguration
 * @package CodeCommerce\ModulSkeleton\Model
 */
class SkeletonConfiguration
{
    /**
     * @var
     */
    protected $base_path;
    /**
     * @var
     */
    protected $modul_base_path;
    /**
     * @var
     */
    protected $generate_file_structur;
    /**
     * @var
     */
    protected $file_structur_directories;

    /**
     * @var
     */
    protected $generate_files;

    /**
     * @var
     */
    protected $file_to_generate;

    /**
     * @var
     */
    protected $composer_update;

    /**
     * @return mixed
     */
    public function getComposerUpdate()
    {
        return $this->composer_update;
    }

    /**
     * @param mixed $composer_update
     * @return SkeletonConfiguration
     */
    public function setComposerUpdate($composer_update)
    {
        $this->composer_update = $composer_update;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileToGenerate()
    {
        return $this->file_to_generate;
    }

    /**
     * @param mixed $file_to_generate
     * @return SkeletonConfiguration
     */
    public function setFileToGenerate($file_to_generate)
    {
        $this->file_to_generate = $file_to_generate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenerateFiles()
    {
        return $this->generate_files;
    }

    /**
     * @param mixed $generate_files
     * @return SkeletonConfiguration
     */
    public function setGenerateFiles($generate_files)
    {
        $this->generate_files = $generate_files;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->base_path;
    }

    /**
     * @param mixed $base_path
     * @return SkeletonConfiguration
     */
    public function setBasePath($base_path)
    {
        $this->base_path = $base_path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModulBasePath()
    {
        return $this->modul_base_path;
    }

    /**
     * @param mixed $modul_base_path
     * @return SkeletonConfiguration
     */
    public function setModulBasePath($modul_base_path)
    {
        $this->modul_base_path = $modul_base_path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenerateFileStructur()
    {
        return $this->generate_file_structur;
    }

    /**
     * @param mixed $generate_file_structur
     * @return SkeletonConfiguration
     */
    public function setGenerateFileStructur($generate_file_structur)
    {
        $this->generate_file_structur = $generate_file_structur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileStructurDirectories()
    {
        return $this->file_structur_directories;
    }

    /**
     * @param mixed $file_structur_directories
     * @return SkeletonConfiguration
     */
    public function setFileStructurDirectories($file_structur_directories)
    {
        $this->file_structur_directories = $file_structur_directories;

        return $this;
    }
}