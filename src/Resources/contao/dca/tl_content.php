<?php

use Contao\Config;

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_iconbox'] = '{type_legend},type,headline;{iconbox_legend},iconboxStyle,iconboxIcon,iconboxText,iconboxLink,iconboxLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_members_grid'] = '{type_legend},type,headline;{members_legend},memberImageTop,memberNameTop,memberImageLeft,memberNameLeft,memberImageRight,memberNameRight,memberImageBottom,memberNameBottom;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_live_teaser'] = '{type_legend},type,headline;{live_legend},liveDate,liveLocation,liveText,liveLink,liveLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_quote_teaser'] = '{type_legend},type,headline;{quote_legend},quoteText,quoteAuthor,quoteMeta,quoteLink,quoteLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_announcement'] = '{type_legend},type,headline;{announcement_legend},announcementEyebrow,announcementText,announcementLink,announcementLinkText,announcementStyle;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_media_text'] = '{type_legend},type,headline;{media_legend},singleSRC,alt,size,fullsize,caption;{text_legend},mediaTextEyebrow,text;{link_legend:hide},url,linkTitle,target;{media_text_legend},mediaTextLayout,mediaTextStyle;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_link_list'] = '{type_legend},type,headline;{link_list_legend},linkListStyle,linkListAlign,linkListItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_slider'] = '{type_legend},type,headline;{slider_legend},sliderStyle,sliderItems;{slider_settings_legend:hide},sliderAutoplay,sliderInterval,sliderArrows,sliderPagination,sliderLoop,sliderPerPage,sliderGap,sliderTransition,sliderImageEffect,sliderTextAnimation,sliderOverlay;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_teaser_grid'] = '{type_legend},type,headline;{teaser_grid_legend},teaserGridStyle,teaserGridColumns,teaserGridGap,teaserGridItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_tabs'] = '{type_legend},type,headline;{tabs_legend},tabsStyle,tabsItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_accordion'] = '{type_legend},type,headline;{accordion_legend},accordionStyle,accordionItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_timeline'] = '{type_legend},type,headline;{timeline_legend},timelineTitle,timelineItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_factsbox'] = '{type_legend},type,headline;{factsbox_legend},factsboxStyle,factsboxItems;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

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

$GLOBALS['TL_DCA']['tl_content']['fields']['mediaTextLayout'] = [
    'exclude' => true,
    'default' => 'image-left',
    'inputType' => 'select',
    'options' => ['image-top', 'image-left', 'image-right', 'image-bottom', 'float-left', 'float-right'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['mediaTextLayoutOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['mediaTextStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'editorial', 'card', 'minimal'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['mediaTextStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['mediaTextEyebrow'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['linkListStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'buttons', 'icons', 'minimal'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['linkListStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['linkListAlign'] = [
    'exclude' => true,
    'default' => 'left',
    'inputType' => 'select',
    'options' => ['left', 'center', 'right'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['linkListAlignOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['linkListItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'label' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['linkListItemsLabel'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:180px'],
            ],
            'url' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['linkListItemsUrl'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:280px', 'rgxp' => 'url'],
            ],
            'icon' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['linkListItemsIcon'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:160px'],
            ],
            'description' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['linkListItemsDescription'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:260px'],
            ],
            'target' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['linkListItemsTarget'],
                'inputType' => 'checkbox',
                'eval' => ['style' => 'width:80px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderStyle'] = [
    'exclude' => true,
    'default' => 'hero',
    'inputType' => 'select',
    'options' => ['hero', 'images', 'cards', 'quotes'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderAutoplay'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderInterval'] = [
    'exclude' => true,
    'default' => '5000',
    'inputType' => 'text',
    'eval' => ['rgxp' => 'natural', 'tl_class' => 'w50'],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderArrows'] = [
    'exclude' => true,
    'default' => '1',
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPagination'] = [
    'exclude' => true,
    'default' => '1',
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderLoop'] = [
    'exclude' => true,
    'default' => '1',
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPerPage'] = [
    'exclude' => true,
    'default' => '1',
    'inputType' => 'select',
    'options' => ['1', '2', '3', '4'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderPerPageOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderGap'] = [
    'exclude' => true,
    'default' => 'medium',
    'inputType' => 'select',
    'options' => ['none', 'small', 'medium', 'large'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderGapOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderTransition'] = [
    'exclude' => true,
    'default' => 'slide',
    'inputType' => 'select',
    'options' => ['slide', 'fade'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderTransitionOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(16) NOT NULL default 'slide'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderImageEffect'] = [
    'exclude' => true,
    'default' => 'none',
    'inputType' => 'select',
    'options' => ['none', 'slow-zoom'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderImageEffectOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'none'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderTextAnimation'] = [
    'exclude' => true,
    'default' => 'none',
    'inputType' => 'select',
    'options' => ['none', 'fade-up'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderTextAnimationOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'none'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderOverlay'] = [
    'exclude' => true,
    'default' => 'none',
    'inputType' => 'select',
    'options' => ['none', 'dark', 'light'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderOverlayOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(16) NOT NULL default 'none'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'image' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsImage'],
                'inputType' => 'fileTree',
                'eval' => [
                    'filesOnly' => true,
                    'fieldType' => 'radio',
                    'extensions' => 'jpg,jpeg,png,webp,svg',
                    'style' => 'width:260px',
                ],
            ],
            'alt' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsAlt'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:180px'],
            ],
            'eyebrow' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsEyebrow'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:160px'],
            ],
            'headline' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsHeadline'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:220px'],
            ],
            'text' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsText'],
                'inputType' => 'textarea',
                'eval' => ['style' => 'width:260px;height:70px'],
            ],
            'linkLabel' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsLinkLabel'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:160px'],
            ],
            'linkUrl' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsLinkUrl'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:240px'],
            ],
            'target' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderItemsTarget'],
                'inputType' => 'checkbox',
                'eval' => ['style' => 'width:80px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['teaserGridStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'cards', 'editorial', 'minimal'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'default'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['teaserGridColumns'] = [
    'exclude' => true,
    'default' => '3',
    'inputType' => 'select',
    'options' => ['2', '3', '4'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridColumnsOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default '3'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['teaserGridGap'] = [
    'exclude' => true,
    'default' => 'medium',
    'inputType' => 'select',
    'options' => ['small', 'medium', 'large'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridGapOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(16) NOT NULL default 'medium'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['teaserGridItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'image' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsImage'],
                'inputType' => 'fileTree',
                'eval' => [
                    'filesOnly' => true,
                    'fieldType' => 'radio',
                    'extensions' => Config::get('validImageTypes'),
                    'style' => 'width:260px',
                ],
            ],
            'alt' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsAlt'],
                'inputType' => 'text',
                'eval' => ['maxlength' => 255, 'style' => 'width:180px'],
            ],
            'title' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsTitle'],
                'inputType' => 'text',
                'eval' => ['maxlength' => 255, 'style' => 'width:220px'],
            ],
            'text' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsText'],
                'inputType' => 'textarea',
                'eval' => ['allowHtml' => false, 'style' => 'width:260px;height:70px'],
            ],
            'badge' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsBadge'],
                'inputType' => 'text',
                'eval' => ['maxlength' => 128, 'style' => 'width:160px'],
            ],
            'linkUrl' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsLinkUrl'],
                'inputType' => 'text',
                'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'style' => 'width:240px'],
            ],
            'linkLabel' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsLinkLabel'],
                'inputType' => 'text',
                'eval' => ['maxlength' => 128, 'style' => 'width:160px'],
            ],
            'target' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['teaserGridItemsTarget'],
                'inputType' => 'checkbox',
                'eval' => ['style' => 'width:80px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
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

$GLOBALS['TL_DCA']['tl_content']['fields']['factsboxStyle'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'compact', 'card'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['factsboxStyleOptions'],
    'eval' => ['chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['factsboxItems'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'label' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['factsboxItemsLabel'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:220px'],
            ],
            'value' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['factsboxItemsValue'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:360px'],
            ],
        ],
        'tl_class' => 'clr',
    ],
    'sql' => 'blob NULL',
];
