<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentLiveTeaser extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_live_teaser';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_live_teaser');

        $this->Template->headline = $this->headline;
        $this->Template->liveDate = (string) $this->liveDate;
        $this->Template->liveLocation = (string) $this->liveLocation;
        $this->Template->liveText = (string) $this->liveText;
        $this->Template->liveLink = (string) $this->liveLink;
        $this->Template->liveLinkText = (string) ($this->liveLinkText ?: 'Details');
    }
}
