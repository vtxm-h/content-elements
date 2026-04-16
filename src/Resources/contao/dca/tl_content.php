<?php

/* ======================================================
   PALETTES
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_live_teaser']
    = '{type_legend},type,headline;'
    . '{live_legend},liveDate,liveLocation,liveText,liveLink,liveLinkText;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_quote_teaser']
    = '{type_legend},type,headline;'
    . '{quote_legend},quoteText,quoteAuthor,quoteMeta,quoteLink,quoteLinkText;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_announcement']
    = '{type_legend},type,headline;'
    . '{announcement_legend},announcementEyebrow,announcementText,announcementLink,announcementLinkText,announcementStyle;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_timeline']
    = '{type_legend},type,headline;'
    . '{timeline_legend},timelineTitle,timelineItems;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_tabs']
    = '{type_legend},type,headline;'
    . '{tabs_legend},tabsStyle,tabsItems;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_accordion']
    = '{type_legend},type,headline;'
    . '{accordion_legend},accordionStyle,accordionItems;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_members_grid']
    = '{type_legend},type,headline;'
    . '{members_legend},memberImageTop,memberNameTop,memberImageLeft,memberNameLeft,memberImageRight,memberNameRight,memberImageBottom,memberNameBottom;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_feature_grid']
    = '{type_legend},type,headline;'
    . '{feature_grid_legend},fgStyle,fgColumns,fgTheme;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_feature_item']
    = '{type_legend},type,headline;'
    . '{feature_item_legend},fiIcon,fiText,fiLink,fiLinkText;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space';

/* ======================================================
   FIELDS: LIVE TEASER
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['liveDate'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['liveDate'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLocation'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['liveLocation'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['liveText'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['liveLink'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLinkText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['liveLinkText'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

/* ======================================================
   FIELDS: QUOTE TEASER
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['quoteText'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['mandatory' => true, 'tl_class' => 'clr'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteAuthor'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['quoteAuthor'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteMeta'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['quoteMeta'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteLink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['quoteLink'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteLinkText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['quoteLinkText'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

/* ======================================================
   FIELDS: ANNOUNCEMENT
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementEyebrow'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['announcementEyebrow'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 128, 'tl_class' => 'w50'],
    'sql'       => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['announcementText'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementLink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['announcementLink'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementLinkText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['announcementLinkText'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementStyle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['announcementStyle'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['default', 'outline', 'soft'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(32) NOT NULL default 'default'",
];

/* ======================================================
   FIELDS: TIMELINE
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['timelineTitle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['timelineTitle'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'clr'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['timelineItems'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['timelineItems'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 65535, 'tl_class' => 'clr', 'class' => 'monospace'],
    'sql'       => "mediumtext NULL",
];

/* ======================================================
   FIELDS: TABS / ACCORDION
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['tabsStyle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['tabsStyle'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['default', 'minimal'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabsItems'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['tabsItems'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 65535, 'tl_class' => 'clr', 'class' => 'monospace'],
    'sql'       => "mediumtext NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['accordionStyle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['accordionStyle'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['default', 'minimal'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['accordionItems'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['accordionItems'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 65535, 'tl_class' => 'clr', 'class' => 'monospace'],
    'sql'       => "mediumtext NULL",
];

/* ======================================================
   FIELDS: MEMBERS GRID
====================================================== */

foreach ([
    'Top' => 'Top',
    'Left' => 'Left',
    'Right' => 'Right',
    'Bottom' => 'Bottom',
] as $suffix => $label) {
    $GLOBALS['TL_DCA']['tl_content']['fields']['memberImage' . $suffix] = [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['memberImage' . $suffix],
        'exclude'   => true,
        'inputType' => 'fileTree',
        'eval'      => ['filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
        'sql'       => "binary(16) NULL",
    ];

    $GLOBALS['TL_DCA']['tl_content']['fields']['memberName' . $suffix] = [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['memberName' . $suffix],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql'       => "varchar(255) NOT NULL default ''",
    ];
}

/* ======================================================
   FIELDS: FEATURE GRID / FEATURE ITEM
====================================================== */

$GLOBALS['TL_DCA']['tl_content']['fields']['fgStyle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fgStyle'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['centered', 'inline', 'minimal'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(32) NOT NULL default 'centered'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fgColumns'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fgColumns'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['2', '3', '4'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(2) NOT NULL default '3'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fgTheme'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fgTheme'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['light', 'dark'],
    'eval'      => ['chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(16) NOT NULL default 'light'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fiIcon'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fiIcon'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fiText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fiText'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fiLink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fiLink'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['fiLinkText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['fiLinkText'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql'       => "varchar(64) NOT NULL default ''",
];
