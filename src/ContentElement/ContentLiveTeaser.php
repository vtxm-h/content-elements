<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentLiveTeaser extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_live_teaser';

    protected function compile()
    {
        $this->assignWrapper('vtxm-live-teaser');
        $this->assignHeadline();

        $this->Template->liveDate = (string) $this->liveDate;
        $this->Template->liveLocation = (string) $this->liveLocation;
        $this->Template->liveText = (string) $this->liveText;
        $this->Template->liveLink = (string) $this->liveLink;
        $this->Template->liveLinkText = (string) $this->liveLinkText;
    }
}
