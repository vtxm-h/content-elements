<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class TeaserGridElement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_teaser_grid';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_teaser_grid teaser-grid');
        $this->assignHeadline();

        $this->Template->teaserGridStyle = $this->normalizeOption((string) ($this->teaserGridStyle ?: 'default'), ['default', 'cards', 'editorial', 'minimal'], 'default');
        $this->Template->teaserGridColumns = $this->normalizeOption((string) ($this->teaserGridColumns ?: '3'), ['2', '3', '4'], '3');
        $this->Template->teaserGridGap = $this->normalizeOption((string) ($this->teaserGridGap ?: 'medium'), ['small', 'medium', 'large'], 'medium');
        $this->Template->teaserGridItems = $this->normalizeItems(StringUtil::deserialize($this->teaserGridItems, true));
    }

    /**
     * @param mixed $items
     *
     * @return list<array{image: string, alt: string, title: string, text: string, badge: string, linkUrl: string, linkLabel: string, target: bool}>
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
            $title = trim((string) ($item['title'] ?? ''));
            $text = trim((string) ($item['text'] ?? ''));
            $badge = trim((string) ($item['badge'] ?? ''));
            $linkUrl = $this->normalizeUrl(trim((string) ($item['linkUrl'] ?? '')));
            $linkLabel = trim((string) ($item['linkLabel'] ?? ''));
            $hasVisibleLink = '' !== $linkUrl && '' !== $linkLabel;

            if ('' === $image && '' === $title && '' === $text && '' === $badge && !$hasVisibleLink) {
                continue;
            }

            $normalized[] = [
                'image' => $image,
                'alt' => trim((string) ($item['alt'] ?? '')),
                'title' => $title,
                'text' => $text,
                'badge' => $badge,
                'linkUrl' => $linkUrl,
                'linkLabel' => $linkLabel,
                'target' => $this->checkboxValue($item['target'] ?? null),
            ];
        }

        return $normalized;
    }

    /**
     * @param mixed $value
     */
    private function resolveImage($value): string
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

        if (!$file || 'file' !== (string) $file->type || '' === (string) $file->path) {
            return '';
        }

        if (\defined('TL_ROOT') && !is_file(TL_ROOT.'/'.$file->path)) {
            return '';
        }

        return (string) $file->path;
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
    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }
}
