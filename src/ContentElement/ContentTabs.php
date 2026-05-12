<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class ContentTabs extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_tabs';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_tabs');
        $this->assignHeadline();

        $this->Template->tabsStyle = $this->normalizeOption((string) ($this->tabsStyle ?: 'default'), ['default', 'minimal'], 'default');
        $this->Template->tabsItems = StringUtil::deserialize($this->tabsItems, true);
    }
}
