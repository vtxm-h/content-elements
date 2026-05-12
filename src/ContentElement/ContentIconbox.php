<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentIconbox extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_iconbox';

    protected function compile()
    {
        $this->assignWrapper('vtxm-iconbox');
        $this->assignHeadline('h3');

        $this->Template->iconboxStyle = $this->normalizeOption((string) ($this->iconboxStyle ?: 'default'), ['default', 'centered', 'inline'], 'default');
        $this->Template->iconboxIcon = (string) $this->iconboxIcon;
        $this->Template->iconboxText = (string) $this->iconboxText;
        $this->Template->iconboxLink = (string) $this->iconboxLink;
        $this->Template->iconboxLinkText = (string) $this->iconboxLinkText;
    }
}
