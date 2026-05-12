<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class ContentAccordion extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_accordion';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_accordion');
        $this->assignHeadline();

        $this->Template->accordionStyle = $this->normalizeOption((string) ($this->accordionStyle ?: 'default'), ['default', 'minimal'], 'default');
        $this->Template->accordionItems = StringUtil::deserialize($this->accordionItems, true);
    }
}
