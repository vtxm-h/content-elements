<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class ContentTimeline extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_timeline';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_timeline');
        $this->assignHeadline();

        $this->Template->timelineTitle = (string) $this->timelineTitle;
        $this->Template->timelineItems = StringUtil::deserialize($this->timelineItems, true);
    }
}
