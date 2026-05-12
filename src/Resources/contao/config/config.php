<?php

use Vendor\ContentElementsBundle\ContentElement\ContentAccordion;
use Vendor\ContentElementsBundle\ContentElement\ContentAnnouncement;
use Vendor\ContentElementsBundle\ContentElement\ContentIconbox;
use Vendor\ContentElementsBundle\ContentElement\ContentLiveTeaser;
use Vendor\ContentElementsBundle\ContentElement\ContentMembersGrid;
use Vendor\ContentElementsBundle\ContentElement\ContentQuoteTeaser;
use Vendor\ContentElementsBundle\ContentElement\ContentTabs;
use Vendor\ContentElementsBundle\ContentElement\ContentTimeline;

$GLOBALS['TL_CTE']['vtxm']['vtxm_iconbox'] = ContentIconbox::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_members_grid'] = ContentMembersGrid::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_live_teaser'] = ContentLiveTeaser::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_quote_teaser'] = ContentQuoteTeaser::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_announcement'] = ContentAnnouncement::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_tabs'] = ContentTabs::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_accordion'] = ContentAccordion::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_timeline'] = ContentTimeline::class;
