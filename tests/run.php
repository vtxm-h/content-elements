<?php

declare(strict_types=1);

namespace Contao {
    final class Backend
    {
        /**
         * @param bool|array<string, mixed> $extras
         */
        public static function getDcaPickerWizard($extras, string $table, string $field, string $inputName): string
        {
            return '<a id="pp_'.$inputName.'" data-table="'.$table.'" data-field="'.$field.'">Pick</a>';
        }
    }

    final class Config
    {
        /**
         * @return string
         */
        public static function get(string $key)
        {
            return 'jpg,jpeg,png,gif,webp,svg';
        }
    }

    final class StringUtil
    {
        public static function specialchars(string $value): string
        {
            return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
    }

    class Widget
    {
        /** @var string */
        public $id = '';

        /** @var string */
        public $tl_class = '';
    }
}

namespace {
    final class TemplateContext
    {
        /** @var array<string, mixed> */
        private $values;

        /**
         * @param array<string, mixed> $values
         */
        public function __construct(array $values)
        {
            $this->values = $values;
        }

        /**
         * @return mixed
         */
        public function __get(string $name)
        {
            return $this->values[$name] ?? null;
        }
    }

    $assertions = 0;

    function failTest(string $message): void
    {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }

    /**
     * @param mixed $actual
     * @param mixed $expected
     */
    function assertSameValue($expected, $actual, string $message): void
    {
        global $assertions;
        ++$assertions;

        if ($expected !== $actual) {
            failTest($message."\nExpected: ".var_export($expected, true)."\nActual: ".var_export($actual, true));
        }
    }

    function assertContainsText(string $needle, string $haystack, string $message): void
    {
        global $assertions;
        ++$assertions;

        if (false === strpos($haystack, $needle)) {
            failTest($message."\nMissing: {$needle}");
        }
    }

    function assertNotContainsText(string $needle, string $haystack, string $message): void
    {
        global $assertions;
        ++$assertions;

        if (false !== strpos($haystack, $needle)) {
            failTest($message."\nUnexpected: {$needle}");
        }
    }

    function assertTrueValue(bool $condition, string $message): void
    {
        global $assertions;
        ++$assertions;

        if (!$condition) {
            failTest($message);
        }
    }

    /**
     * @return list<string>
     */
    function paletteFields(string $palette): array
    {
        $withoutLegends = preg_replace('/\{[^}]+\}/', '', $palette);
        $fields = preg_split('/[,;]/', (string) $withoutLegends) ?: [];

        return array_values(array_filter(array_map('trim', $fields), static function (string $field): bool {
            return '' !== $field;
        }));
    }

    /**
     * @param array<string, mixed> $values
     */
    function renderTemplate(string $template, array $values): string
    {
        $context = new TemplateContext($values);

        return (string) (function (string $templatePath): string {
            ob_start();
            include $templatePath;

            return (string) ob_get_clean();
        })->call($context, $template);
    }

    $root = dirname(__DIR__);
    $globalTargetField = [
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default ''",
    ];
    $GLOBALS['TL_DCA'] = ['tl_content' => ['palettes' => [], 'subpalettes' => [], 'fields' => ['target' => $globalTargetField]]];
    $GLOBALS['TL_LANG'] = ['tl_content' => []];

    require $root.'/src/TeamGrid/TeamGridIconRegistry.php';
    require $root.'/src/TeamGrid/TeamGridLinkNormalizer.php';
    require $root.'/src/TeamGrid/TeamGridProfileWidgetWrapper.php';
    require $root.'/src/Resources/contao/config/config.php';
    require $root.'/src/Resources/contao/dca/tl_content.php';

    $mediaPalette = $GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_media_text'];
    $mediaFields = paletteFields($mediaPalette);

    assertTrueValue(!in_array('fullsize', $mediaFields, true), 'Media Text must not expose the Contao fullsize/new-window image option.');
    assertTrueValue(!in_array('target', $mediaFields, true), 'Media Text must not expose the Contao new-window target option.');

    foreach (['type', 'headline', 'singleSRC', 'alt', 'size', 'caption', 'mediaTextEyebrow', 'text', 'url', 'linkTitle', 'mediaTextLayout', 'mediaTextStyle', 'cssID'] as $requiredField) {
        assertTrueValue(in_array($requiredField, $mediaFields, true), "Media Text must retain the {$requiredField} field.");
    }

    $mediaTextEyebrowField = $GLOBALS['TL_DCA']['tl_content']['fields']['mediaTextEyebrow'];

    assertSameValue('text', $mediaTextEyebrowField['inputType'], 'Media Text eyebrow must remain a normal editable text input.');
    assertSameValue(255, $mediaTextEyebrowField['eval']['maxlength'], 'Media Text eyebrow must retain its text length limit.');
    assertSameValue('clr', $mediaTextEyebrowField['eval']['tl_class'], 'Media Text eyebrow must clear the backend field layout instead of floating beside the rich-text editor.');
    assertTrueValue(!isset($mediaTextEyebrowField['eval']['readonly']) && !isset($mediaTextEyebrowField['eval']['disabled']), 'Media Text eyebrow must not be configured as read-only or disabled.');
    assertSameValue($globalTargetField, $GLOBALS['TL_DCA']['tl_content']['fields']['target'], 'Media Text configuration must not alter Contao\'s global target field.');

    $expectedUnrelatedPalettes = [
        'vtxm_iconbox' => '{type_legend},type,headline;{iconbox_legend},iconboxStyle,iconboxIcon,iconboxText,iconboxLink,iconboxLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop',
        'vtxm_quote_teaser' => '{type_legend},type,headline;{quote_legend},quoteText,quoteAuthor,quoteMeta,quoteLink,quoteLinkText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop',
        'vtxm_slider' => '{type_legend},type,headline;{slider_legend},sliderStyle,sliderItems;{slider_settings_legend:hide},sliderRenderMode,sliderAutoplay,sliderInterval,sliderArrows,sliderPagination,sliderLoop,sliderPerPage,sliderGap,sliderTransition,sliderImageEffect,sliderTextAnimation,sliderOverlay,sliderMode,sliderWidth,sliderHeight,sliderContentAlign,sliderContentPosition,sliderMediaPosition,sliderPattern,sliderScrollEffect;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop',
    ];

    foreach ($expectedUnrelatedPalettes as $element => $expectedPalette) {
        assertSameValue($expectedPalette, $GLOBALS['TL_DCA']['tl_content']['palettes'][$element], "The {$element} palette must remain unchanged.");
    }

    $teamPalette = $GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_team_grid'];
    $teamPaletteFields = paletteFields($teamPalette);

    assertSameValue(
        ['cards', 'minimal', 'list'],
        $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridStyle']['options'],
        'Team Grid display style options must remain unchanged.'
    );
    assertSameValue(['grid', 'list'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridLayout']['options'], 'Team Grid layout options must remain unchanged.');
    assertSameValue(['2', '3', '4'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridColumns']['options'], 'Team Grid column options must remain unchanged.');
    assertSameValue(['small', 'medium', 'large'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridGap']['options'], 'Team Grid gap options must remain unchanged.');
    assertSameValue(['portrait', 'square', 'landscape', 'natural'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridImageRatio']['options'], 'Team Grid image-ratio options must remain unchanged.');
    assertSameValue(['left', 'center'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridAlign']['options'], 'Team Grid alignment options must remain unchanged.');
    assertSameValue(['none', 'fade-up'], $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridReveal']['options'], 'Team Grid reveal options must remain unchanged.');

    foreach (['teamGridStyle', 'teamGridLayout', 'teamGridColumns', 'teamGridGap', 'teamGridImageRatio', 'teamGridAlign', 'teamGridReveal', 'teamGridItems'] as $requiredField) {
        assertTrueValue(in_array($requiredField, $teamPaletteFields, true), "Team Grid must retain its {$requiredField} general field.");
    }

    $teamField = $GLOBALS['TL_DCA']['tl_content']['fields']['teamGridItems'];
    $teamColumns = $teamField['eval']['columnFields'];
    $requiredVisibleTeamColumns = [
        'image', 'alt', 'name', 'role', 'biography', 'email', 'phone', 'website',
        'link1Icon', 'link1Label', 'link1Url',
        'link2Icon', 'link2Label', 'link2Url',
        'link3Icon', 'link3Label', 'link3Url',
    ];

    foreach ($requiredVisibleTeamColumns as $column) {
        assertTrueValue(isset($teamColumns[$column]), "Team Grid must configure the visible {$column} profile field.");
        assertTrueValue(true !== ($teamColumns[$column]['eval']['hideBody'] ?? false), "Team Grid {$column} must remain visible.");
        assertSameValue('profile', $teamColumns[$column]['eval']['columnPos'], "Team Grid {$column} must use the grouped profile column.");
    }

    foreach ([1, 2, 3] as $slot) {
        assertSameValue('select', $teamColumns['link'.$slot.'Icon']['inputType'], "Team Grid link {$slot} must contain an icon select.");
        assertSameValue('text', $teamColumns['link'.$slot.'Label']['inputType'], "Team Grid link {$slot} must contain a label input.");
        assertSameValue('text', $teamColumns['link'.$slot.'Url']['inputType'], "Team Grid link {$slot} must contain a URL input.");
        assertTrueValue(!isset($teamColumns['link'.$slot.'Url']['eval']['dcaPicker']), "Team Grid link {$slot} must keep picker markup inside its grouped widget.");
        assertSameValue(
            [[\Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper::class, 'renderPagePicker']],
            $teamColumns['link'.$slot.'Url']['wizard'],
            "Team Grid link {$slot} must use the grouped page-picker callback."
        );
        assertSameValue(
            \Vendor\ContentElementsBundle\TeamGrid\TeamGridIconRegistry::keys(),
            $teamColumns['link'.$slot.'Icon']['options'],
            "Team Grid link {$slot} must use only the curated icon whitelist."
        );
        assertTrueValue(true === $teamColumns['link'.$slot.'Icon']['eval']['includeBlankOption'], "Team Grid link {$slot} must offer no icon.");
    }

    $removedTeamColumns = [
        'link1LegacySource', 'link2LegacySource', 'link3LegacySource',
        'linkedinUrl', 'instagramUrl', 'mastodonUrl', 'blueskyUrl', 'githubUrl',
        'ctaUrl', 'ctaLabel', 'ctaTarget',
        'genericLink1Label', 'genericLink1Url', 'genericLink2Label', 'genericLink2Url',
        'target', 'legacyPayload',
    ];

    foreach ($removedTeamColumns as $removedTeamColumn) {
        assertTrueValue(!isset($teamColumns[$removedTeamColumn]), "Old Team Grid {$removedTeamColumn} must not be exposed.");
    }
    assertSameValue($requiredVisibleTeamColumns, array_keys($teamColumns), 'Team Grid rows must contain exactly the seventeen visible profile fields.');

    assertSameValue('mediumblob NULL', $teamField['sql'], 'Team Grid must keep its existing top-level mediumblob storage type.');
    assertTrueValue(!isset($teamField['load_callback']), 'Team Grid must not use a compatibility load callback.');
    assertTrueValue(false !== strpos($teamColumns['biography']['eval']['tl_class'], 'team-grid-profile-field--biography'), 'Team Grid biography must receive full-width backend treatment.');
    assertTrueValue(!isset($teamColumns['biography']['eval']['style']), 'Team Grid biography must not retain a narrow fixed inline width.');
    assertTrueValue(!isset($teamField['eval']['hideButtons']) && !isset($teamField['eval']['disableSorting']), 'Team Grid must keep native repeated-row controls and sorting enabled.');
    assertSameValue($globalTargetField, $GLOBALS['TL_DCA']['tl_content']['fields']['target'], 'Team Grid configuration must not alter Contao\'s global target field.');
    assertSameValue('bundles/contentelements/css/team-grid-backend.css|static', $GLOBALS['TL_CSS']['vtxm_team_grid_backend'], 'Team Grid must register its local backend layout asset.');

    $backendCss = (string) file_get_contents($root.'/src/Resources/public/css/team-grid-backend.css');
    assertContainsText('#ctrl_teamGridItems', $backendCss, 'Team Grid backend CSS must be scoped to its widget ID.');
    assertContainsText('grid-template-columns', $backendCss, 'Team Grid backend CSS must use a responsive profile grid.');
    assertContainsText('min-height: 9rem', $backendCss, 'Team Grid biography must have a comfortable backend height.');
    assertContainsText('overflow: visible', $backendCss, 'Team Grid profile cells must not clip Chosen icon menus.');
    assertNotContainsText('overflow: hidden', $backendCss, 'Team Grid profile cells must keep Chosen icon menus reachable.');
    assertNotContainsText('body {', $backendCss, 'Team Grid backend CSS must not add a global body override.');

    assertTrueValue(
        in_array(
            [\Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper::class, 'wrap'],
            $GLOBALS['TL_HOOKS']['parseWidget'],
            true
        ),
        'Team Grid must register its scoped widget-wrapper hook.'
    );

    $teamProfileWidget = new \Contao\Widget();
    $teamProfileWidget->id = 'teamGridItems_row0_link1Url';
    $teamProfileWidget->tl_class = 'team-grid-profile-field team-grid-profile-field--link-url team-grid-profile-field--link-1-url mcwUpdateFields';
    $wrappedTeamProfileWidget = (new \Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper())->wrap(
        '<h3><label>Link URL</label></h3><input type="text">',
        $teamProfileWidget
    );
    assertContainsText(
        '<div class="widget team-grid-profile-field team-grid-profile-field--link-url team-grid-profile-field--link-1-url">',
        $wrappedTeamProfileWidget,
        'Grouped Team Grid fields must receive real per-field wrappers for the responsive grid.'
    );
    assertTrueValue(!isset($teamColumns['website']['eval']['dcaPicker']), 'The Team Grid website picker must remain inside its grouped widget.');
    assertSameValue(
        [[\Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper::class, 'renderPagePicker']],
        $teamColumns['website']['wizard'],
        'The Team Grid website must use the grouped page-picker callback.'
    );
    assertContainsText(
        'id="pp_teamGridItems_row0_link1Url"',
        (new \Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper())->renderPagePicker(null, $teamProfileWidget),
        'The Team Grid page-picker callback must target the grouped child widget.'
    );

    $unrelatedWidget = new \Contao\Widget();
    $unrelatedWidget->id = 'linkListItems_row0_url';
    $unrelatedWidget->tl_class = 'team-grid-profile-field team-grid-profile-field--link-url';
    assertSameValue(
        '<input type="text">',
        (new \Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper())->wrap('<input type="text">', $unrelatedWidget),
        'The Team Grid widget-wrapper hook must leave unrelated MultiColumnWizard fields unchanged.'
    );
    assertSameValue(
        '',
        (new \Vendor\ContentElementsBundle\TeamGrid\TeamGridProfileWidgetWrapper())->renderPagePicker(null, $unrelatedWidget),
        'The Team Grid page-picker callback must leave unrelated fields unchanged.'
    );

    $iconKeys = \Vendor\ContentElementsBundle\TeamGrid\TeamGridIconRegistry::keys();
    assertSameValue(11, count($iconKeys), 'Team Grid must expose only the curated eleven icon keys.');

    foreach ($iconKeys as $iconKey) {
        $iconPath = \Vendor\ContentElementsBundle\TeamGrid\TeamGridIconRegistry::assetPath($iconKey);
        assertTrueValue(is_file($iconPath), "The local Team Grid {$iconKey} SVG must exist.");
        $iconSvg = (string) file_get_contents($iconPath);
        assertNotContainsText('<script', strtolower($iconSvg), "The local Team Grid {$iconKey} SVG must not contain scripts.");
        assertNotContainsText('cdn.', strtolower($iconSvg), "The local Team Grid {$iconKey} SVG must not depend on a CDN.");
    }

    assertSameValue('', \Vendor\ContentElementsBundle\TeamGrid\TeamGridIconRegistry::normalizeKey('unknown'), 'Unknown Team Grid icon keys must fail closed.');
    assertSameValue('', \Vendor\ContentElementsBundle\TeamGrid\TeamGridIconRegistry::svg('unknown'), 'Unknown Team Grid icons must not produce SVG markup.');
    $iconLicenseDocumentation = (string) file_get_contents($root.'/ICON_SOURCES.md');
    assertContainsText('Simple Icons', $iconLicenseDocumentation, 'Team Grid icon source documentation must identify Simple Icons.');
    assertContainsText('Tabler Icons', $iconLicenseDocumentation, 'Team Grid icon source documentation must identify Tabler Icons.');
    assertContainsText('MIT License', $iconLicenseDocumentation, 'Team Grid icon source documentation must preserve the Tabler MIT notice.');

    $englishTeamTranslations = (string) file_get_contents($root.'/src/Resources/contao/languages/en/tl_content.php');
    $germanTeamTranslations = (string) file_get_contents($root.'/src/Resources/contao/languages/de/tl_content.php');
    assertContainsText('Person — image', $englishTeamTranslations, 'English Team Grid translations must identify the person group.');
    assertContainsText('Contact — email', $englishTeamTranslations, 'English Team Grid translations must identify the contact group.');
    assertContainsText('Additional links — Link 1: icon', $englishTeamTranslations, 'English Team Grid translations must identify the additional-links group.');
    assertContainsText('adjacent name already conveys the same information', $englishTeamTranslations, 'English Team Grid alt-text help must explain the decorative portrait case.');
    assertContainsText('Person — Bild', $germanTeamTranslations, 'German Team Grid translations must identify the person group.');
    assertContainsText('Kontakt — E-Mail', $germanTeamTranslations, 'German Team Grid translations must identify the contact group.');
    assertContainsText('Zusätzliche Links — Link 1: Icon', $germanTeamTranslations, 'German Team Grid translations must identify the additional-links group.');
    assertContainsText('direkt benachbarte Name dieselbe Information bereits vermittelt', $germanTeamTranslations, 'German Team Grid alt-text help must explain the decorative portrait case.');

    $oldProfileFields = [
        'linkedinUrl' => 'https://linkedin.example/person',
        'instagramUrl' => 'https://instagram.example/person',
        'mastodonUrl' => 'https://mastodon.example/@person',
        'blueskyUrl' => 'https://bsky.example/person',
        'githubUrl' => 'https://github.example/person',
        'genericLink1Label' => 'Portfolio',
        'genericLink1Url' => 'https://portfolio.example/person',
        'genericLink2Label' => 'Research',
        'genericLink2Url' => 'https://research.example/person',
        'ctaUrl' => 'https://action.example/person',
        'ctaLabel' => 'Read profile',
        'ctaTarget' => '1',
        'target' => '1',
    ];
    assertSameValue([], \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize($oldProfileFields), 'Old platform, generic-link, primary-action and target fields must not render.');
    assertSameValue([], \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize(['website' => 'https://example.com']), 'Website must remain separate from the three additional-link slots.');

    $invalidLinks = \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize([
        'link1Url' => 'https://empty.example',
        'link2Label' => 'Missing URL',
        'link3Icon' => 'external-link',
        'link3Url' => 'https://external.example',
    ]);
    assertSameValue([], $invalidLinks, 'URL-only, label-without-URL and unlabeled external-link combinations must not render.');
    assertSameValue([], \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize(['link1Icon' => 'github']), 'An icon without a URL must not render a link.');

    $unknownIconFallback = \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize([
        'link1Icon' => 'not-whitelisted',
        'link1Label' => 'Safe fallback',
        'link1Url' => 'https://fallback.example',
        'link2Icon' => 'instagram',
        'link2Url' => 'javascript:alert(1)',
        'link3Icon' => 'not-whitelisted',
        'link3Url' => 'https://inaccessible.example',
    ]);
    assertSameValue(1, count($unknownIconFallback), 'Unknown icon-only and unsafe-URL links must fail while an unknown icon with visible text falls back safely.');
    assertSameValue('', $unknownIconFallback[0]['icon'], 'Unknown icon markup must never reach the frontend.');

    $accessibleLinks = \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize([
        'link1Icon' => 'instagram',
        'link1Url' => 'https://instagram.example/current',
        'link2Label' => 'Documentation',
        'link2Url' => 'https://docs.example/current',
        'link3Icon' => 'github',
        'link3Label' => 'Source code',
        'link3Url' => 'https://github.example/current',
    ]);
    assertSameValue('Instagram', $accessibleLinks[0]['accessibleLabel'], 'Icon-only links must derive a meaningful platform name.');
    assertSameValue('', $accessibleLinks[1]['accessibleLabel'], 'Visible link text must provide the accessible name without a redundant aria-label.');
    assertSameValue('', $accessibleLinks[2]['accessibleLabel'], 'Icon-plus-label links must use the visible label as their accessible name.');

    $deduplicatedLinks = \Vendor\ContentElementsBundle\TeamGrid\TeamGridLinkNormalizer::normalize([
        'link1Label' => 'First',
        'link1Url' => 'https://duplicate.example',
        'link2Label' => 'Duplicate',
        'link2Url' => 'https://duplicate.example',
        'link3Label' => 'Third',
        'link3Url' => 'https://third.example',
        'link4Label' => 'Unsupported fourth slot',
        'link4Url' => 'https://fourth.example',
    ]);
    assertSameValue(['https://duplicate.example', 'https://third.example'], array_column($deduplicatedLinks, 'url'), 'Team Grid must deduplicate identical URLs and ignore a fourth additional-link slot.');

    $teamTemplateValues = [
        'elementId' => 'team-grid-test',
        'elementClass' => 'ce_vtxm_team_grid team-grid',
        'teamGridHasItems' => true,
        'teamGridStyle' => 'cards',
        'teamGridLayout' => 'grid',
        'teamGridColumns' => '3',
        'teamGridGap' => 'medium',
        'teamGridImageRatio' => 'portrait',
        'teamGridAlign' => 'left',
        'teamGridReveal' => 'none',
        'teamGridHasMedia' => false,
        'teamGridHasHeader' => false,
        'teamGridItemHeadlineUnit' => 'h3',
        'headlineText' => '',
        'headlineUnit' => 'h2',
        'teamGridItems' => [[
            'index' => 1,
            'image' => '',
            'alt' => '',
            'name' => 'Current Person',
            'role' => 'Engineer',
            'biography' => 'Biography',
            'contacts' => [],
            'socials' => $accessibleLinks,
            'hasMedia' => false,
        ]],
    ];
    $teamOutput = renderTemplate($root.'/src/Resources/contao/templates/ce_vtxm_team_grid.html5', $teamTemplateValues);

    assertContainsText('team-grid--style-cards team-grid--layout-grid team-grid--columns-3', $teamOutput, 'Team Grid must retain its existing layout and variant classes.');
    assertContainsText('aria-label="Instagram"', $teamOutput, 'An icon-only Team Grid link must expose its platform name.');
    assertContainsText('>Documentation</span>', $teamOutput, 'A label-only Team Grid link must render visible text.');
    assertContainsText('>Source code</span>', $teamOutput, 'An icon-plus-label Team Grid link must render its visible text.');
    assertContainsText('class="team-grid__social-icon-svg" width="1em" height="1em" aria-hidden="true" focusable="false"', $teamOutput, 'Team Grid SVG icons must be decorative to assistive technologies.');
    assertSameValue(3, substr_count($teamOutput, 'class="team-grid__social '), 'Each valid unified slot must render exactly one link.');
    assertNotContainsText('target="_blank"', $teamOutput, 'Unified Team Grid links must use normal browser navigation.');
    assertNotContainsText('team-grid__action', $teamOutput, 'Team Grid must not render a primary-action compatibility block.');

    $mediaOutput = renderTemplate($root.'/src/Resources/contao/templates/ce_vtxm_media_text.html5', [
        'elementId' => 'legacy-media-text',
        'elementClass' => 'ce_vtxm_media_text legacy-class',
        'mediaTextLayout' => 'float-left',
        'mediaTextStyle' => 'editorial',
        'mediaTextHasImage' => true,
        'mediaTextFullsize' => true,
        'mediaTextOriginalImage' => 'files/media/legacy.jpg',
        'mediaTextImage' => 'files/media/legacy.jpg',
        'mediaTextImageWidth' => 640,
        'mediaTextImageHeight' => 480,
        'mediaTextAlt' => 'Legacy image',
        'mediaTextCaption' => 'Legacy caption',
        'mediaTextHasContent' => true,
        'mediaTextEyebrow' => 'Eyebrow',
        'headlineText' => 'Legacy headline',
        'headlineUnit' => 'h2',
        'mediaTextText' => '<p>Legacy body</p>',
        'mediaTextUrl' => 'https://example.com/action',
        'mediaTextLinkTitle' => 'Read more',
        'mediaTextTarget' => true,
    ]);

    assertContainsText('class="ce_vtxm_media_text legacy-class media-text media-text--float-left media-text--editorial"', $mediaOutput, 'Media Text must keep its root and layout/style classes and expose the base component hook.');
    assertContainsText('data-vtxm-media-text', $mediaOutput, 'Media Text must expose its component data hook.');
    assertContainsText('class="media-text__inner"', $mediaOutput, 'Media Text must retain the inner layout-boundary hook.');
    assertContainsText('class="media-text__media"', $mediaOutput, 'Media Text must retain its media hook.');
    assertContainsText('class="media-text__content"', $mediaOutput, 'Media Text must retain its content hook.');
    assertContainsText('class="media-text__link"', $mediaOutput, 'A saved legacy fullsize value must remain renderable even though it is no longer editable in the palette.');
    assertContainsText('href="https://example.com/action" target="_blank" rel="noopener noreferrer"', $mediaOutput, 'The separate Media Text action link must remain available.');

    $quoteOutput = renderTemplate($root.'/src/Resources/contao/templates/ce_vtxm_quote_teaser.html5', [
        'elementId' => 'legacy-quote',
        'elementClass' => 'ce_vtxm_quote_teaser legacy-class',
        'headlineText' => 'Review',
        'headlineUnit' => 'h3',
        'quoteText' => "A reliable quote.\nWith a second line.",
        'quoteAuthor' => 'Ada Example',
        'quoteMeta' => 'Example Journal, 2026',
        'quoteLink' => 'https://example.com/review',
        'quoteLinkText' => 'Read review',
    ]);

    assertContainsText('class="ce_vtxm_quote_teaser legacy-class quote-teaser"', $quoteOutput, 'Quote Teaser must expose a stable card/component root while preserving custom classes.');
    assertContainsText('data-vtxm-quote-teaser', $quoteOutput, 'Quote Teaser must expose its component data hook.');
    assertContainsText('<blockquote class="quote-teaser__quote">', $quoteOutput, 'Quote Teaser must retain semantic blockquote output.');
    assertContainsText('<p class="quote-teaser__text">', $quoteOutput, 'Quote Teaser must expose a dedicated quote-text hook.');
    assertContainsText('<footer class="quote-teaser__attribution">', $quoteOutput, 'Quote Teaser must expose a dedicated attribution hook.');
    assertContainsText('<span class="quote-teaser__author">Ada Example</span>', $quoteOutput, 'Quote Teaser must distinguish its author field.');
    assertContainsText('<cite class="quote-teaser__source">Example Journal, 2026</cite>', $quoteOutput, 'Quote Teaser must distinguish source metadata with cite semantics.');
    assertContainsText('<a class="quote-teaser__link" href="https://example.com/review">Read review</a>', $quoteOutput, 'Existing Quote Teaser links must remain renderable with a stable link hook.');

    $blockquoteEnd = strpos($quoteOutput, '</blockquote>');
    $attributionStart = strpos($quoteOutput, '<footer class="quote-teaser__attribution">');
    assertTrueValue(false !== $blockquoteEnd && false !== $attributionStart && $blockquoteEnd < $attributionStart, 'Attribution must be outside the quoted block.');

    $minimalQuoteOutput = renderTemplate($root.'/src/Resources/contao/templates/ce_vtxm_quote_teaser.html5', [
        'elementId' => '',
        'elementClass' => 'ce_vtxm_quote_teaser',
        'headlineText' => '',
        'headlineUnit' => 'h2',
        'quoteText' => 'Quote without attribution',
        'quoteAuthor' => '',
        'quoteMeta' => '',
        'quoteLink' => '',
        'quoteLinkText' => '',
    ]);

    assertContainsText('Quote without attribution', $minimalQuoteOutput, 'Existing quote records without optional fields must remain renderable.');
    assertNotContainsText('quote-teaser__attribution', $minimalQuoteOutput, 'Empty attribution fields must not produce empty markup.');

    fwrite(STDOUT, "OK ({$assertions} assertions)\n");
}
