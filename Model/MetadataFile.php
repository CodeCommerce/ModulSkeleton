<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 05.09.18
 * Time: 15:02
 */

namespace CodeCommerce\ModulSkeleton\Model;


class MetadataFile
{
    const FILE_NAME = 'metadata.php';

    protected $name;
    protected $title;
    protected $description;
    protected $version;
    protected $module_version;
    protected $thumbnail;
    protected $path;

    /**
     * @return mixed
     */
    public function getModuleVersion()
    {
        return $this->module_version;
    }

    /**
     * @param mixed $module_version
     * @return MetadataFile
     */
    public function setModuleVersion($module_version)
    {
        $this->module_version = $module_version;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path . "/" . self::FILE_NAME;
    }

    /**
     * @param mixed $path
     * @return MetadataFile
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return MetadataFile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return MetadataFile
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return MetadataFile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     * @return MetadataFile
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     * @return MetadataFile
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}