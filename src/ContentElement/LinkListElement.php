<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class LinkListElement extends AbstractWrappedContentElement
{
    private const REL_TOKEN_ORDER = ['noopener', 'noreferrer', 'nofollow', 'me'];

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
     * @return list<array{label: string, url: string, icon: string, description: string, target: bool, nofollow: bool, relMe: bool, rel: string}>
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

            $target = $this->checkboxValue($item['target'] ?? null);
            $nofollow = $this->checkboxValue($item['nofollow'] ?? null);
            $relMe = $this->checkboxValue($item['relMe'] ?? null);

            $normalized[] = [
                'label' => $label,
                'url' => $url,
                'icon' => $this->normalizeIcon((string) ($item['icon'] ?? '')),
                'description' => trim((string) ($item['description'] ?? '')),
                'target' => $target,
                'nofollow' => $nofollow,
                'relMe' => $relMe,
                'rel' => $this->buildRel($target, $nofollow, $relMe, (string) ($item['rel'] ?? '')),
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

    private function buildRel(bool $target, bool $nofollow, bool $relMe, string $existingRel): string
    {
        $tokens = $this->normalizeRelTokens($existingRel);

        if ($target) {
            $tokens[] = 'noopener';
            $tokens[] = 'noreferrer';
        }

        if ($nofollow) {
            $tokens[] = 'nofollow';
        }

        if ($relMe) {
            $tokens[] = 'me';
        }

        return implode(' ', $this->orderRelTokens($tokens));
    }

    /**
     * @return list<string>
     */
    private function normalizeRelTokens(string $rel): array
    {
        $rel = strtolower(trim($rel));

        if ('' === $rel) {
            return [];
        }

        $tokens = preg_split('/\s+/', $rel) ?: [];
        $normalized = [];

        foreach ($tokens as $token) {
            $token = trim($token);

            if ('' === $token || !preg_match('/^[a-z0-9][a-z0-9:._-]*$/', $token)) {
                continue;
            }

            if (!\in_array($token, $normalized, true)) {
                $normalized[] = $token;
            }
        }

        return $normalized;
    }

    /**
     * @param list<string> $tokens
     *
     * @return list<string>
     */
    private function orderRelTokens(array $tokens): array
    {
        $tokens = array_values(array_unique($tokens));
        $ordered = [];

        foreach (self::REL_TOKEN_ORDER as $preferredToken) {
            if (\in_array($preferredToken, $tokens, true)) {
                $ordered[] = $preferredToken;
            }
        }

        foreach ($tokens as $token) {
            if (!\in_array($token, $ordered, true)) {
                $ordered[] = $token;
            }
        }

        return $ordered;
    }

    /**
     * @param mixed $value
     */
    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }
}
