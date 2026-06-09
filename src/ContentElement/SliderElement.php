<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class SliderElement extends AbstractWrappedContentElement
{
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
        $perPage = (int) $this->normalizeOption((string) ($this->sliderPerPage ?: '1'), ['1', '2', '3', '4'], '1');
        $interval = (int) ($this->sliderInterval ?: 5000);

        if ($interval <= 0) {
            $interval = 5000;
        }

        $this->Template->sliderStyle = $style;
        $this->Template->sliderGap = $gap;
        $this->Template->sliderItems = $this->normalizeItems(StringUtil::deserialize($this->sliderItems, true));
        $this->Template->sliderOptions = $this->encodeOptions([
            'type' => $this->checkboxValue($this->sliderLoop) ? 'loop' : 'slide',
            'autoplay' => $this->checkboxValue($this->sliderAutoplay),
            'interval' => $interval,
            'arrows' => $this->checkboxValue($this->sliderArrows),
            'pagination' => $this->checkboxValue($this->sliderPagination),
            'perPage' => $perPage,
            'gap' => self::GAP_VALUES[$gap],
        ]);
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
