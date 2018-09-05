<?php

namespace CodeCommerce\ModulSkeleton\Core;

/**
 * Class FileStructorGenerator
 * @package CodeCommerce\ModulSkeleton\Core
 */
class FileStructorGenerator
{
    /**
     * @var
     */
    protected $hFile;

    /**
     * @param $sDir
     * @return bool
     */
    public function isDir($sDir)
    {
        return is_dir($sDir) && file_exists($sDir);
    }

    /**
     * @param $sFile
     * @return bool
     */
    protected function isFile($sFile)
    {
        return file_exists($sFile) && is_file($sFile);
    }

    /**
     * @param $sPath
     * @return bool
     */
    public function generateFileStructur($sPath)
    {
        if (!$this->isDir($sPath)) {
            mkdir($sPath, 0755, true);
        }

        if ($this->isDir($sPath)) {
            return true;
        }

        return false;
    }

    /**
     * @param        $sFilePath
     * @param string $sMode
     * @return bool|resource
     */
    public function generateFile($sFilePath, $sMode = 'w+')
    {
        $bOpen = $f = fopen($sFilePath, $sMode);
        fclose($f);

        return $bOpen;
    }

    /**
     * @param        $sFilePath
     * @param string $sMode
     * @return bool|resource
     */
    public function getFile($sFilePath, $sMode = 'w+')
    {
        $sDirPath = dirname($sFilePath);
        if (null !== $this->hFile) {
            return $this->hFile;
        }


        if (!$this->isDir($sDirPath)) {
            $this->generateFileStructur($sDirPath);
        }

        if (!$this->isFile($sFilePath)) {
            if ($this->generateFile($sFilePath)) {
                $this->hFile = fopen($sFilePath, $sMode);

                return $this->hFile;
            }
        }

        return false;
    }

    /**
     * @param $sFilePath
     * @param $sInput
     */
    public function writeFile($sFilePath, $sInput)
    {
        file_put_contents($sFilePath, $sInput);
    }

    /**
     * generate filepath / file if not exist
     */
    protected function generateIfNotExists($sFile = null)
    {
        if (null !== $sFile) {
            $this->sFilePath = $sFile;
        }

        if (!$this->isFile($this->sFilePath)) {
            $this->generateFile($this->sFilePath);
        }
    }

    protected function readFile($sFilePath = null)
    {
        if (null === $sFilePath) {
            if (null === $this->sFilePath) {
                return false;
            } else {
                $sFilePath = $this->sFilePath;
            }
        }
        $sContent = file_get_contents($sFilePath);
        return $sContent;
    }
}