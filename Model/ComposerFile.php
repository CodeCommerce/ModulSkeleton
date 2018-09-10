<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 04.09.18
 * Time: 15:45
 */

namespace CodeCommerce\ModuleSkeleton\Model;


class ComposerFile
{
    protected $oContent;

    public function __construct($oContent = null)
    {
        if (null !== $oContent) {
            $this->setContent($oContent);
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->oContent;
    }

    /**
     * @param mixed $oContent
     * @return ComposerFile
     */
    public function setContent($oContent)
    {
        $this->oContent = $oContent;

        return $this;
    }

    /**
     * @param $sField
     * @param $sValue
     */
    public function updateArrayFieldWithValue($sKey, $sField, $sValue)
    {
        $oComposerContent = $this->getContent();
        if (array_key_exists($sKey, $oComposerContent)) {
            $oComposerContent->{$sKey}->{$sField} = $sValue;
        }
        $this->setContent($oComposerContent);
    }
}