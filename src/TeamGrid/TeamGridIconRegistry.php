<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\TeamGrid;

final class TeamGridIconRegistry
{
    private const ICONS = [
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'github' => 'GitHub',
        'mastodon' => 'Mastodon',
        'bluesky' => 'Bluesky',
        'facebook' => 'Facebook',
        'youtube' => 'YouTube',
        'tiktok' => 'TikTok',
        'x' => 'X',
        'website' => 'Website',
        'external-link' => 'External link',
    ];

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::ICONS);
    }

    public static function normalizeKey(string $key): string
    {
        return isset(self::ICONS[$key]) ? $key : '';
    }

    public static function label(string $key): string
    {
        return self::ICONS[$key] ?? '';
    }

    public static function assetPath(string $key): string
    {
        if ('' === self::normalizeKey($key)) {
            return '';
        }

        return dirname(__DIR__).'/Resources/public/icons/team-grid/'.$key.'.svg';
    }

    public static function svg(string $key): string
    {
        $path = self::assetPath($key);

        if ('' === $path || !is_file($path)) {
            return '';
        }

        $svg = file_get_contents($path);

        if (false === $svg || 1 !== preg_match('/^<svg\b/', $svg)) {
            return '';
        }

        $svg = preg_replace(
            '/^<svg\b/',
            '<svg class="team-grid__social-icon-svg" width="1em" height="1em" aria-hidden="true" focusable="false"',
            trim($svg),
            1
        );

        return \is_string($svg) ? $svg : '';
    }
}
