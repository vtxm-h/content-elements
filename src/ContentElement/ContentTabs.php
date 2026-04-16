<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentTabs extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_tabs';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_tabs');

        $this->Template->headline = $this->headline;
        $this->Template->tabsStyle = (string) $this->tabsStyle;
        $this->Template->tabsItems = $this->decodeItems((string) $this->tabsItems);
    }

    protected function decodeItems(string $json): array
    {
        $data = json_decode($json, true);

        return \is_array($data) ? $data : [];
    }
}
