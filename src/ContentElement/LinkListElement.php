<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class LinkListElement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_link_list';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_link_list');
        $this->assignHeadline();

        $this->Template->linkListStyle = $this->normalizeOption((string) ($this->linkListStyle ?: 'default'), ['default', 'buttons', 'icons', 'minimal'], 'default');
        $this->Template->linkListAlign = $this->normalizeOption((string) ($this->linkListAlign ?: 'left'), ['left', 'center', 'right'], 'left');
        $this->Template->linkListItems = $this->normalizeItems(StringUtil::deserialize($this->linkListItems, true));
    }

    /**
     * @param mixed $items
     *
     * @return list<array{label: string, url: string, icon: string, description: string, target: bool}>
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

            $label = trim((string) ($item['label'] ?? ''));
            $url = $this->normalizeUrl(trim((string) ($item['url'] ?? '')));

            if ('' === $label && '' === $url) {
                continue;
            }

            if ('' === $url) {
                continue;
            }

            if ('' === $label) {
                $label = $url;
            }

            $normalized[] = [
                'label' => $label,
                'url' => $url,
                'icon' => $this->normalizeIcon((string) ($item['icon'] ?? '')),
                'description' => trim((string) ($item['description'] ?? '')),
                'target' => !empty($item['target']),
            ];
        }

        return $normalized;
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

    private function normalizeIcon(string $icon): string
    {
        $icon = strtolower(trim($icon));
        $icon = preg_replace('/[^a-z0-9-]+/', '-', $icon) ?? '';

        return trim($icon, '-');
    }
}
