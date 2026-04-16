<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentTimeline extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_timeline';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_timeline');

        $this->Template->headline = $this->headline;
        $this->Template->timelineTitle = (string) $this->timelineTitle;
        $this->Template->timelineItems = $this->decodeItems((string) $this->timelineItems);
    }

    protected function decodeItems(string $json): array
    {
        $data = json_decode($json, true);

        return \is_array($data) ? $data : [];
    }
}
