<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentFeatureItem extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_feature_item';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_feature_item');

        $this->Template->headline = $this->headline;
        $this->Template->fiIcon = (string) $this->fiIcon;
        $this->Template->fiText = (string) $this->fiText;
        $this->Template->fiLink = (string) $this->fiLink;
        $this->Template->fiLinkText = (string) ($this->fiLinkText ?: 'Learn more');
    }
}
