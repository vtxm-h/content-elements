<?php

namespace Vendor\ContentElementsBundle\ContentElement;

class ContentAnnouncement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_announcement';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_announcement');

        $this->Template->headline = $this->headline;
        $this->Template->announcementEyebrow = (string) $this->announcementEyebrow;
        $this->Template->announcementText = (string) $this->announcementText;
        $this->Template->announcementLink = (string) $this->announcementLink;
        $this->Template->announcementLinkText = (string) ($this->announcementLinkText ?: 'Learn more');
        $this->Template->announcementStyle = (string) $this->announcementStyle;
    }
}
