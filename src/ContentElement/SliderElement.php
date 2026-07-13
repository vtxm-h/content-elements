<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\Config;
use Contao\FilesModel;
use Contao\StringUtil;

class SliderElement extends AbstractWrappedContentElement
{
    private const RENDER_MODE_VALUES = ['slider', 'static'];
    private const TRANSITION_VALUES = ['slide', 'fade'];
    private const IMAGE_EFFECT_VALUES = ['none', 'slow-zoom'];
    private const TEXT_ANIMATION_VALUES = ['none', 'fade-up'];
    private const OVERLAY_VALUES = ['none', 'dark', 'light'];
    private const MODE_VALUES = ['standard', 'hero'];
    private const WIDTH_VALUES = ['contained', 'fullwidth'];
    private const HEIGHT_VALUES = ['auto', 'compact', 'medium', 'large', 'viewport', 'custom'];
    private const CONTENT_ALIGN_VALUES = ['left', 'center', 'right'];
    private const CONTENT_POSITION_VALUES = ['top', 'center', 'bottom'];
    private const MEDIA_POSITION_VALUES = ['left-top', 'center-top', 'right-top', 'left-center', 'center-center', 'right-center', 'left-bottom', 'center-bottom', 'right-bottom'];
    private const PATTERN_VALUES = ['none', 'dots-fine', 'dots-coarse', 'lines-diagonal', 'lines-horizontal'];
    private const SCROLL_EFFECT_VALUES = ['none', 'fade', 'fade-background'];
    private const MEDIA_TYPE_VALUES = ['image', 'video'];
    private const VIDEO_MIME_TYPES = [
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'ogv' => 'video/ogg',
        'ogg' => 'video/ogg',
    ];

    private const GAP_VALUES = [
        'none' => '0',
        'small' => '.75rem',
        'medium' => '1.5rem',
        'large' => '2.5rem',
    ];

    protected $strTemplate = 'ce_vtxm_slider';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_slider vtxm-slider');
        $this->assignHeadline();

        $renderMode = $this->normalizeOption((string) ($this->sliderRenderMode ?: 'slider'), self::RENDER_MODE_VALUES, 'slider');
        $style = $this->normalizeOption((string) ($this->sliderStyle ?: 'hero'), ['hero', 'images', 'cards', 'quotes'], 'hero');
        $gap = $this->normalizeOption((string) ($this->sliderGap ?: 'medium'), ['none', 'small', 'medium', 'large'], 'medium');
        $transition = $this->normalizeOption((string) ($this->sliderTransition ?: 'slide'), self::TRANSITION_VALUES, 'slide');
        $imageEffect = $this->normalizeOption((string) ($this->sliderImageEffect ?: 'none'), self::IMAGE_EFFECT_VALUES, 'none');
        $textAnimation = $this->normalizeOption((string) ($this->sliderTextAnimation ?: 'none'), self::TEXT_ANIMATION_VALUES, 'none');
        $overlay = $this->normalizeOption((string) ($this->sliderOverlay ?: 'none'), self::OVERLAY_VALUES, 'none');
        $mode = $this->normalizeOption((string) ($this->sliderMode ?: 'standard'), self::MODE_VALUES, 'standard');
        $width = $this->normalizeOption((string) ($this->sliderWidth ?: 'contained'), self::WIDTH_VALUES, 'contained');
        $height = $this->normalizeOption((string) ($this->sliderHeight ?: 'auto'), self::HEIGHT_VALUES, 'auto');
        $contentAlign = $this->normalizeOption((string) ($this->sliderContentAlign ?: 'left'), self::CONTENT_ALIGN_VALUES, 'left');
        $contentPosition = $this->normalizeOption((string) ($this->sliderContentPosition ?: 'bottom'), self::CONTENT_POSITION_VALUES, 'bottom');
        $mediaPosition = $this->normalizeOption((string) ($this->sliderMediaPosition ?: 'center-center'), self::MEDIA_POSITION_VALUES, 'center-center');
        $customHeight = $this->normalizeInteger($this->sliderCustomHeight, 160, 1600, 640);
        $pattern = $this->normalizeOption((string) ($this->sliderPattern ?: 'none'), self::PATTERN_VALUES, 'none');
        $scrollEffect = $this->normalizeOption((string) ($this->sliderScrollEffect ?: 'none'), self::SCROLL_EFFECT_VALUES, 'none');
        $scrollDistance = $this->normalizeInteger($this->sliderScrollDistance, 100, 2000, 600);
        $perPage = (int) $this->normalizeOption((string) ($this->sliderPerPage ?: '1'), ['1', '2', '3', '4'], '1');
        $interval = (int) ($this->sliderInterval ?: 5000);
        $loop = $this->checkboxValue($this->sliderLoop);

        if ($interval <= 0) {
            $interval = 5000;
        }

        $options = [
            'type' => 'fade' === $transition ? 'fade' : ($loop ? 'loop' : 'slide'),
            'autoplay' => $this->checkboxValue($this->sliderAutoplay),
            'interval' => $interval,
            'arrows' => $this->checkboxValue($this->sliderArrows),
            'pagination' => $this->checkboxValue($this->sliderPagination),
            'perPage' => $perPage,
            'gap' => self::GAP_VALUES[$gap],
        ];

        if ('fade' === $transition) {
            $options['rewind'] = $loop;
        }

        $items = $this->normalizeItems(StringUtil::deserialize($this->sliderItems, true));
        $staticItem = 'static' === $renderMode ? $this->firstUsableStaticItem($items) : null;

        $this->Template->sliderRenderMode = $renderMode;
        $this->Template->sliderStyle = $style;
        $this->Template->sliderGap = $gap;
        $this->Template->sliderTransition = $transition;
        $this->Template->sliderImageEffect = $imageEffect;
        $this->Template->sliderTextAnimation = $textAnimation;
        $this->Template->sliderOverlay = $overlay;
        $this->Template->sliderHasOverlay = 'none' !== $overlay;
        $this->Template->sliderMode = $mode;
        $this->Template->sliderWidth = $width;
        $this->Template->sliderHeight = $height;
        $this->Template->sliderContentAlign = $contentAlign;
        $this->Template->sliderContentPosition = $contentPosition;
        $this->Template->sliderMediaPosition = $mediaPosition;
        $this->Template->sliderCustomHeight = $customHeight;
        $this->Template->sliderPattern = $pattern;
        $this->Template->sliderHasPattern = 'none' !== $pattern;
        $this->Template->sliderScrollEffect = $scrollEffect;
        $this->Template->sliderScrollDistance = $scrollDistance;
        $this->Template->sliderItems = $items;
        $this->Template->sliderStaticItem = $staticItem;
        $this->Template->sliderHasStaticItem = null !== $staticItem;
        $this->Template->sliderOptions = $this->encodeOptions($options);
    }

    /**
     * @param mixed $items
     *
     * @return list<array{mediaType: string, image: string, alt: string, videoDesktop: string, videoMobile: string, videoPoster: string, videoMimeType: string, eyebrow: string, headline: string, text: string, linkLabel: string, linkUrl: string, target: bool, hasAction: bool, hasMedia: bool, hasVisibleText: bool, hasContent: bool}>
     */
    private function normalizeItems($items): array
    {
        if (!\is_array($items)) {
            return [];
        }

        $normalized = [];

        foreach ($items as $item) {
            if (!\is_array($item)) {
                continue;
            }

            $image = $this->resolveImage($item['image'] ?? null);
            $mediaType = $this->normalizeOption((string) ($item['mediaType'] ?? 'image'), self::MEDIA_TYPE_VALUES, 'image');
            $videoDesktop = $this->resolveVideo($item['videoDesktop'] ?? null);
            $videoMobile = $this->resolveVideo($item['videoMobile'] ?? null);
            $videoPoster = $this->resolveVideoPoster($item['videoPoster'] ?? null);
            $eyebrow = trim((string) ($item['eyebrow'] ?? ''));
            $headline = trim((string) ($item['headline'] ?? ''));
            $text = trim((string) ($item['text'] ?? ''));
            $linkLabel = trim((string) ($item['linkLabel'] ?? ''));
            $linkUrl = $this->normalizeUrl(trim((string) ($item['linkUrl'] ?? '')));
            $hasAction = '' !== $linkLabel && '' !== $linkUrl;
            $hasVisibleText = '' !== $eyebrow || '' !== $headline || '' !== $text;
            $hasContent = $hasVisibleText || $hasAction;

            if ('' === $videoDesktop && '' !== $videoMobile) {
                $videoDesktop = $videoMobile;
            }

            if ('' === $videoMobile && '' !== $videoDesktop) {
                $videoMobile = $videoDesktop;
            }

            if ('video' === $mediaType && '' === $videoDesktop) {
                $mediaType = 'image';
            }

            $hasMedia = ('video' === $mediaType && '' !== $videoDesktop) || ('video' !== $mediaType && '' !== $image);

            if (!$hasMedia && !$hasContent) {
                continue;
            }

            $normalized[] = [
                'mediaType' => $mediaType,
                'image' => $image,
                'alt' => trim((string) ($item['alt'] ?? '')),
                'videoDesktop' => $videoDesktop,
                'videoMobile' => $videoMobile,
                'videoPoster' => $videoPoster,
                'videoMimeType' => $this->videoMimeType($videoDesktop),
                'eyebrow' => $eyebrow,
                'headline' => $headline,
                'text' => $text,
                'linkLabel' => $linkLabel,
                'linkUrl' => $linkUrl,
                'target' => $this->checkboxValue($item['target'] ?? null),
                'hasAction' => $hasAction,
                'hasMedia' => $hasMedia,
                'hasVisibleText' => $hasVisibleText,
                'hasContent' => $hasContent,
            ];
        }

        return $normalized;
    }

    /**
     * @param list<array{mediaType: string, image: string, alt: string, videoDesktop: string, videoMobile: string, videoPoster: string, videoMimeType: string, eyebrow: string, headline: string, text: string, linkLabel: string, linkUrl: string, target: bool, hasAction: bool, hasMedia: bool, hasVisibleText: bool, hasContent: bool}> $items
     *
     * @return array{mediaType: string, image: string, alt: string, videoDesktop: string, videoMobile: string, videoPoster: string, videoMimeType: string, eyebrow: string, headline: string, text: string, linkLabel: string, linkUrl: string, target: bool, hasAction: bool, hasMedia: bool, hasVisibleText: bool, hasContent: bool}|null
     */
    private function firstUsableStaticItem(array $items): ?array
    {
        foreach ($items as $item) {
            if ($item['hasVisibleText'] || $item['hasMedia'] || $item['hasAction']) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     */
    private function resolveImage($value): string
    {
        $extensions = $this->configuredExtensions('validImageTypes');

        if ([] === $extensions) {
            return '';
        }

        return $this->resolveFile($value, $extensions);
    }

    /**
     * @param mixed $value
     */
    private function resolveVideo($value): string
    {
        $extensions = $this->configuredExtensions('validVideoTypes');

        if ([] === $extensions) {
            return '';
        }

        return $this->resolveFile($value, $extensions);
    }

    /**
     * @param mixed $value
     */
    private function resolveVideoPoster($value): string
    {
        $extensions = $this->configuredExtensions('validImageTypes');

        if ([] === $extensions) {
            return '';
        }

        return $this->resolveFile($value, $extensions);
    }

    /**
     * @param mixed        $value
     * @param list<string> $extensions
     */
    private function resolveFile($value, array $extensions): string
    {
        $uuid = $value;

        if (!\is_array($uuid)) {
            $uuid = StringUtil::deserialize($uuid);
        }

        if (\is_array($uuid)) {
            $uuid = reset($uuid);
        }

        if (empty($uuid) || !\is_string($uuid)) {
            return '';
        }

        try {
            $file = FilesModel::findByUuid($uuid);
        } catch (\Throwable $exception) {
            return '';
        }

        if (!$file || 'file' !== (string) $file->type) {
            return '';
        }

        $path = trim((string) $file->path);

        if ('' === $path) {
            return '';
        }

        if ([] !== $extensions) {
            $extension = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));

            if ('' === $extension || !\in_array($extension, $extensions, true)) {
                return '';
            }
        }

        if (\defined('TL_ROOT') && !is_file(TL_ROOT.'/'.$path)) {
            return '';
        }

        return $path;
    }

    private function normalizeUrl(string $url): string
    {
        if ('' === $url) {
            return '';
        }

        if (preg_match('/[\x00-\x1F\x7F<>"\']/', $url)) {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url) && !preg_match('/^(https?:|mailto:|tel:)/i', $url)) {
            return '';
        }

        return $url;
    }

    /**
     * @param mixed $value
     */
    private function normalizeInteger($value, int $min, int $max, int $default): int
    {
        $value = trim((string) $value);

        if (!preg_match('/^\d+$/', $value)) {
            return $default;
        }

        $integer = (int) $value;

        if ($integer < $min || $integer > $max) {
            return $default;
        }

        return $integer;
    }

    /**
     * @return list<string>
     */
    private function configuredExtensions(string $configKey): array
    {
        $extensions = Config::get($configKey);

        if (\is_array($extensions)) {
            $extensions = implode(',', $extensions);
        }

        if (!\is_string($extensions)) {
            return [];
        }

        $values = array_filter(array_map(static function (string $extension): string {
            return strtolower(ltrim(trim($extension), '.'));
        }, explode(',', $extensions)));

        return array_values(array_unique($values));
    }

    private function videoMimeType(string $path): string
    {
        $extension = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));

        return self::VIDEO_MIME_TYPES[$extension] ?? '';
    }

    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }

    /**
     * @param array<string, bool|int|string> $options
     */
    private function encodeOptions(array $options): string
    {
        $json = json_encode($options, JSON_UNESCAPED_SLASHES);

        return \is_string($json) ? $json : '{}';
    }
}
