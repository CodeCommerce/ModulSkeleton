<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 04.09.18
 * Time: 16:07
 */

namespace CodeCommerce\ModuleSkeleton\Model;


class ComposerVendorFile extends ComposerFile
{
    protected $modul_name;
    protected $vendor_namespace;
    protected $vendor_homepage;
    protected $vendor_email;
    protected $author_name;
    protected $author_email;
    protected $author_homepage;
    protected $composer_version;
    protected $composer_description;
    protected $file_path;

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param mixed $file_path
     * @return ComposerVendorFile
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModulName()
    {
        return $this->modul_name;
    }

    /**
     * @param mixed $modul_name
     * @return ComposerVendorFile
     */
    public function setModulName($modul_name)
    {
        $this->modul_name = $modul_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVendorNamespace()
    {
        return $this->vendor_namespace;
    }

    /**
     * @param mixed $vendor_namespace
     * @return ComposerVendorFile
     */
    public function setVendorNamespace($vendor_namespace)
    {
        $this->vendor_namespace = $vendor_namespace;

        return $this;
    }

    public function getComposerName($bToLower = false)
    {
        $sComposerName = $this->getVendorNamespace() . "/" . $this->getModulName();
        if ($bToLower) {
            $sComposerName = strtolower($sComposerName);
        }

        return $sComposerName;
    }

    /**
     * @return mixed
     */
    public function getVendorHomepage()
    {
        return $this->vendor_homepage;
    }

    /**
     * @param mixed $vendor_homepage
     * @return ComposerVendorFile
     */
    public function setVendorHomepage($vendor_homepage)
    {
        $this->vendor_homepage = $vendor_homepage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVendorEmail()
    {
        return $this->vendor_email;
    }

    /**
     * @param mixed $vendor_email
     * @return ComposerVendorFile
     */
    public function setVendorEmail($vendor_email)
    {
        $this->vendor_email = $vendor_email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->author_name;
    }

    /**
     * @param mixed $author_name
     * @return ComposerVendorFile
     */
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorEmail()
    {
        return $this->author_email;
    }

    /**
     * @param mixed $author_email
     * @return ComposerVendorFile
     */
    public function setAuthorEmail($author_email)
    {
        $this->author_email = $author_email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorHomepage()
    {
        return $this->author_homepage;
    }

    /**
     * @param mixed $author_homepage
     * @return ComposerVendorFile
     */
    public function setAuthorHomepage($author_homepage)
    {
        $this->author_homepage = $author_homepage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComposerVersion()
    {
        return $this->composer_version;
    }

    /**
     * @param mixed $composer_version
     * @return ComposerVendorFile
     */
    public function setComposerVersion($composer_version)
    {
        $this->composer_version = $composer_version;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComposerDescription()
    {
        return $this->composer_description;
    }

    /**
     * @param mixed $composer_description
     * @return ComposerVendorFile
     */
    public function setComposerDescription($composer_description)
    {
        $this->composer_description = $composer_description;

        return $this;
    }

    protected function getComposerNamespaceFormated()
    {
        $sVendorName = $this->getComposerName();
        $sVendorNamespace = $sVendorName . "/";
        $sVendorNamespace = str_replace("//", "/", $sVendorNamespace);
        $sVendorNamespace = str_replace("/", "\\", $sVendorNamespace);

        return $sVendorNamespace;
    }

    public function toObject()
    {
        $oComposer = new \stdClass();
        $oComposer->name = $this->getComposerName();
        $oComposer->description = $this->getComposerDescription();
        $oComposer->version = $this->getComposerVersion();
        $oComposer->homepage = $this->getVendorHomepage();
        $oComposer->author = new \stdClass();
        $oComposer->author->name = $this->getAuthorName();
        $oComposer->author->email = $this->getAuthorEmail();
        $oComposer->author->homepage = $this->getAuthorEmail();
        $oComposer->support = new \stdClass();
        $oComposer->support->email = $this->getVendorEmail();
        $oComposer->support->homepage = $this->getVendorHomepage();

        $sVendorNamespace = $this->getComposerNamespaceFormated();
        $oComposer->autoload = [
            'psr-4' => [
                $sVendorNamespace => "./"
            ]
        ];

        return $oComposer;
    }
}