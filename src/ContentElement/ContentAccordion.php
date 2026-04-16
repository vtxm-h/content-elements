<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentAccordion extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_accordion';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_accordion');

        $this->Template->headline = $this->headline;
        $this->Template->accordionStyle = (string) $this->accordionStyle;
        $this->Template->accordionItems = $this->decodeItems((string) $this->accordionItems);
    }

    protected function decodeItems(string $json): array
    {
        $data = json_decode($json, true);

        return \is_array($data) ? $data : [];
    }
}
