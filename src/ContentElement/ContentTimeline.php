<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentTimeline extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_timeline';

    protected function compile()
    {
        $this->assignWrapper('vtxm-timeline');
        $this->assignHeadline();

        $this->Template->timelineTitle = (string) $this->timelineTitle;
        $this->Template->timelineItems = $this->decodeItems((string) $this->timelineItems);
    }
}
