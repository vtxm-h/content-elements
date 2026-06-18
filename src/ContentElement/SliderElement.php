<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class SliderElement extends AbstractWrappedContentElement
{
    private const TRANSITION_VALUES = ['slide', 'fade'];
    private const IMAGE_EFFECT_VALUES = ['none', 'slow-zoom'];
    private const TEXT_ANIMATION_VALUES = ['none', 'fade-up'];
    private const OVERLAY_VALUES = ['none', 'dark', 'light'];

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

        $style = $this->normalizeOption((string) ($this->sliderStyle ?: 'hero'), ['hero', 'images', 'cards', 'quotes'], 'hero');
        $gap = $this->normalizeOption((string) ($this->sliderGap ?: 'medium'), ['none', 'small', 'medium', 'large'], 'medium');
        $transition = $this->normalizeOption((string) ($this->sliderTransition ?: 'slide'), self::TRANSITION_VALUES, 'slide');
        $imageEffect = $this->normalizeOption((string) ($this->sliderImageEffect ?: 'none'), self::IMAGE_EFFECT_VALUES, 'none');
        $textAnimation = $this->normalizeOption((string) ($this->sliderTextAnimation ?: 'none'), self::TEXT_ANIMATION_VALUES, 'none');
        $overlay = $this->normalizeOption((string) ($this->sliderOverlay ?: 'none'), self::OVERLAY_VALUES, 'none');
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

        $this->Template->sliderStyle = $style;
        $this->Template->sliderGap = $gap;
        $this->Template->sliderTransition = $transition;
        $this->Template->sliderImageEffect = $imageEffect;
        $this->Template->sliderTextAnimation = $textAnimation;
        $this->Template->sliderOverlay = $overlay;
        $this->Template->sliderHasOverlay = 'none' !== $overlay;
        $this->Template->sliderItems = $this->normalizeItems(StringUtil::deserialize($this->sliderItems, true));
        $this->Template->sliderOptions = $this->encodeOptions($options);
    }

    /**
     * @param mixed $items
     *
     * @return list<array{image: string, alt: string, eyebrow: string, headline: string, text: string, linkLabel: string, linkUrl: string, target: bool, hasContent: bool}>
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
            $eyebrow = trim((string) ($item['eyebrow'] ?? ''));
            $headline = trim((string) ($item['headline'] ?? ''));
            $text = trim((string) ($item['text'] ?? ''));
            $linkLabel = trim((string) ($item['linkLabel'] ?? ''));
            $linkUrl = $this->normalizeUrl(trim((string) ($item['linkUrl'] ?? '')));
            $hasAction = '' !== $linkLabel && '' !== $linkUrl;
            $hasContent = '' !== $eyebrow || '' !== $headline || '' !== $text || $hasAction;

            if ('' === $image && !$hasContent) {
                continue;
            }

            $normalized[] = [
                'image' => $image,
                'alt' => trim((string) ($item['alt'] ?? '')),
                'eyebrow' => $eyebrow,
                'headline' => $headline,
                'text' => $text,
                'linkLabel' => $linkLabel,
                'linkUrl' => $linkUrl,
                'target' => !empty($item['target']),
                'hasContent' => $hasContent,
            ];
        }

        return $normalized;
    }

    private function resolveImage($value): string
    {
        $uuid = $value;

        if (!\is_array($uuid)) {
            $uuid = StringUtil::deserialize($uuid);
        }

        if (\is_array($uuid)) {
            $uuid = reset($uuid);
        }

        if (empty($uuid)) {
            return '';
        }

        $file = FilesModel::findByUuid($uuid);

        return $file ? (string) $file->path : '';
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
