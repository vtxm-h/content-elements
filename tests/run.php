<?php

declare(strict_types=1);

namespace Contao {
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
