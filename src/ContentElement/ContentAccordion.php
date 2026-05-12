<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentAccordion extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_accordion';

    protected function compile()
    {
        $this->assignWrapper('vtxm-accordion');
        $this->assignHeadline();

        $this->Template->accordionStyle = $this->normalizeOption((string) ($this->accordionStyle ?: 'default'), ['default', 'minimal'], 'default');
        $this->Template->accordionItems = $this->decodeItems((string) $this->accordionItems);
    }
}
