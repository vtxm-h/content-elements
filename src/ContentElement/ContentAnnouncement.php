<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentAnnouncement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_announcement';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_announcement');
        $this->assignHeadline();

        $this->Template->announcementEyebrow = (string) $this->announcementEyebrow;
        $this->Template->announcementText = (string) $this->announcementText;
        $this->Template->announcementLink = (string) $this->announcementLink;
        $this->Template->announcementLinkText = (string) $this->announcementLinkText;
        $this->Template->announcementStyle = $this->normalizeOption((string) ($this->announcementStyle ?: 'default'), ['default', 'outline', 'soft'], 'default');
    }
}
