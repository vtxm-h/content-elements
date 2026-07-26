<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\TeamGrid;

final class TeamGridLinkNormalizer
{
    /**
     * @param array<string, mixed> $item
     *
     * @return list<array{type: string, icon: string, iconSvg: string, label: string, url: string, accessibleLabel: string, target: bool, rel: string}>
     */
    public static function normalize(array $item, bool $openInNewWindow = false): array
    {
        $links = [];
        $seenUrls = [];

        foreach ([1, 2, 3] as $slot) {
            $icon = TeamGridIconRegistry::normalizeKey(trim((string) ($item['link'.$slot.'Icon'] ?? '')));
            $iconSvg = TeamGridIconRegistry::svg($icon);
            $label = trim((string) ($item['link'.$slot.'Label'] ?? ''));
            $url = self::normalizeWebUrl(trim((string) ($item['link'.$slot.'Url'] ?? '')));

            if (
                '' === $url
                || ('' === $icon && '' === $label)
                || ('external-link' === $icon && '' === $label)
                || ('' === $label && '' === $iconSvg)
                || isset($seenUrls[$url])
            ) {
                continue;
            }

            $links[] = [
                'type' => '' !== $icon ? $icon : 'additional-'.$slot,
                'icon' => $icon,
                'iconSvg' => $iconSvg,
                'label' => $label,
                'url' => $url,
                'accessibleLabel' => '' === $label ? TeamGridIconRegistry::label($icon) : '',
                'target' => $openInNewWindow,
                'rel' => $openInNewWindow ? 'noopener noreferrer' : '',
            ];
            $seenUrls[$url] = true;
        }

        return $links;
    }

    public static function normalizeWebUrl(string $url): string
    {
        if ('' === $url || 1 === preg_match('/[\x00-\x20\x7F<>"\']/', $url)) {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url) && !preg_match('/^https?:/i', $url)) {
            return '';
        }

        return $url;
    }
}
