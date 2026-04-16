<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentQuoteTeaser extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_quote_teaser';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_quote_teaser');

        $this->Template->headline = $this->headline;
        $this->Template->quoteText = (string) $this->quoteText;
        $this->Template->quoteAuthor = (string) $this->quoteAuthor;
        $this->Template->quoteMeta = (string) $this->quoteMeta;
        $this->Template->quoteLink = (string) $this->quoteLink;
        $this->Template->quoteLinkText = (string) ($this->quoteLinkText ?: 'Read more');
    }
}
