<?php

use Contao\Config;

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_iconbox'] = '{type_legend},type,headline;{iconbox_legend},iconboxStyle,iconboxIcon,iconboxText,iconboxLink,iconboxLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_members_grid'] = '{type_legend},type,headline;{members_legend},memberImageTop,memberNameTop,memberImageLeft,memberNameLeft,memberImageRight,memberNameRight,memberImageBottom,memberNameBottom;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_live_teaser'] = '{type_legend},type,headline;{live_legend},liveDate,liveLocation,liveText,liveLink,liveLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_quote_teaser'] = '{type_legend},type,headline;{quote_legend},quoteText,quoteAuthor,quoteMeta,quoteLink,quoteLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_announcement'] = '{type_legend},type,headline;{announcement_legend},announcementEyebrow,announcementText,announcementLink,announcementLinkText,announcementStyle;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_tabs'] = '{type_legend},type,headline;{tabs_legend},tabsStyle,tabsItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_accordion'] = '{type_legend},type,headline;{accordion_legend},accordionStyle,accordionItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_timeline'] = '{type_legend},type,headline;{timeline_legend},timelineTitle,timelineItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['iconboxStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'centered', 'inline'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['iconboxStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['iconboxIcon'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['iconboxText'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['iconboxLink'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['iconboxLinkText'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

foreach (['Top', 'Left', 'Right', 'Bottom'] as $suffix) {
    $GLOBALS['TL_DCA']['tl_content']['fields']['memberImage'.$suffix] = [
        'exclude' => true,
        'inputType' => 'fileTree',
        'eval' => [
            'filesOnly' => true,
            'fieldType' => 'radio',
            'extensions' => Config::get('validImageTypes'),
            'tl_class' => 'w50',
        ],
        'sql' => 'binary(16) NULL',
    ];

    $GLOBALS['TL_DCA']['tl_content']['fields']['memberName'.$suffix] = [
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql' => "varchar(255) NOT NULL default ''",
    ];
}

$GLOBALS['TL_DCA']['tl_content']['fields']['liveDate'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLocation'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveText'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLink'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['liveLinkText'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteText'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteAuthor'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteMeta'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteLink'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['quoteLinkText'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementEyebrow'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 128, 'tl_class' => 'w50'],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementText'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementLink'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementLinkText'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['announcementStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'outline', 'soft'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['announcementStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabsStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'minimal'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['simpleStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabsItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'title' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['tabsItemsTitle'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:220px'],
            ],
            'content' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['tabsItemsContent'],
                'inputType' => 'textarea',
                'eval' => ['allowHtml' => true, 'style' => 'width:420px;height:80px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['accordionStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'minimal'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['simpleStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['accordionItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'title' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['accordionItemsTitle'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:220px'],
            ],
            'content' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['accordionItemsContent'],
                'inputType' => 'textarea',
                'eval' => ['allowHtml' => true, 'style' => 'width:420px;height:80px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['timelineTitle'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['timelineItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'year' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['timelineItemsYear'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:160px'],
            ],
            'text' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['timelineItemsText'],
                'inputType' => 'textarea',
                'eval' => ['style' => 'width:480px;height:70px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];
