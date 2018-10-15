<?php

namespace CodeCommerce\ModuleSkeleton\Model;

/**
 * Class ComposerFile
 * @package CodeCommerce\ModuleSkeleton\Model
 */
class ComposerFile
{
    /**
     * @var
     */
    protected $oContent;

    /**
     * ComposerFile constructor.
     * @param null $oContent
     */
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
        if (!array_key_exists($sKey, $oComposerContent)) {
            $oComposerContent->{$sKey} = new \stdClass();
        }
        $oComposerContent->{$sKey}->{$sField} = $sValue;
        $this->setContent($oComposerContent);
    }
}