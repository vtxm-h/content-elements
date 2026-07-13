<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\Config;
use Contao\FilesModel;
use Contao\StringUtil;

class TeamGridElement extends AbstractWrappedContentElement
{
    private const STYLE_VALUES = ['cards', 'minimal', 'list'];
    private const LAYOUT_VALUES = ['grid', 'list'];
    private const COLUMN_VALUES = ['2', '3', '4'];
    private const GAP_VALUES = ['small', 'medium', 'large'];
    private const IMAGE_RATIO_VALUES = ['portrait', 'square', 'landscape', 'natural'];
    private const ALIGN_VALUES = ['left', 'center'];
    private const REVEAL_VALUES = ['none', 'fade-up'];

    private const SOCIAL_FIELDS = [
        'linkedinUrl' => ['type' => 'linkedin', 'label' => 'LinkedIn'],
        'instagramUrl' => ['type' => 'instagram', 'label' => 'Instagram'],
        'mastodonUrl' => ['type' => 'mastodon', 'label' => 'Mastodon'],
        'blueskyUrl' => ['type' => 'bluesky', 'label' => 'Bluesky'],
        'githubUrl' => ['type' => 'github', 'label' => 'GitHub'],
    ];

    protected $strTemplate = 'ce_vtxm_team_grid';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_team_grid team-grid');
        $this->assignHeadline();

        $items = $this->normalizeItems($this->deserializeItems($this->teamGridItems));

        $this->Template->teamGridStyle = $this->normalizeOption((string) ($this->teamGridStyle ?: 'cards'), self::STYLE_VALUES, 'cards');
        $this->Template->teamGridLayout = $this->normalizeOption((string) ($this->teamGridLayout ?: 'grid'), self::LAYOUT_VALUES, 'grid');
        $this->Template->teamGridColumns = $this->normalizeOption((string) ($this->teamGridColumns ?: '3'), self::COLUMN_VALUES, '3');
        $this->Template->teamGridGap = $this->normalizeOption((string) ($this->teamGridGap ?: 'medium'), self::GAP_VALUES, 'medium');
        $this->Template->teamGridImageRatio = $this->normalizeOption((string) ($this->teamGridImageRatio ?: 'portrait'), self::IMAGE_RATIO_VALUES, 'portrait');
        $this->Template->teamGridAlign = $this->normalizeOption((string) ($this->teamGridAlign ?: 'left'), self::ALIGN_VALUES, 'left');
        $this->Template->teamGridReveal = $this->normalizeOption((string) ($this->teamGridReveal ?: 'none'), self::REVEAL_VALUES, 'none');
        $this->Template->teamGridItems = $items;
        $this->Template->teamGridHasItems = [] !== $items;
        $this->Template->teamGridHasMedia = $this->itemsHaveMedia($items);
        $this->Template->teamGridHasHeader = '' !== trim((string) $this->Template->headlineText);
        $this->Template->teamGridItemHeadlineUnit = $this->itemHeadlineUnit((string) $this->Template->headlineUnit, (bool) $this->Template->teamGridHasHeader);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function deserializeItems($value)
    {
        try {
            return StringUtil::deserialize($value, true);
        } catch (\Throwable $exception) {
            return [];
        }
    }

    /**
     * @param mixed $items
     *
     * @return list<array{index: int, image: string, alt: string, name: string, role: string, biography: string, contacts: list<array{type: string, label: string, url: string, ariaLabel: string, target: bool}>, socials: list<array{type: string, label: string, url: string, ariaLabel: string, target: bool}>, action: array{label: string, url: string, target: bool, ariaLabel: string}|null, hasMedia: bool}>
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
            $name = trim((string) ($item['name'] ?? ''));
            $role = trim((string) ($item['role'] ?? ''));
            $biography = trim((string) ($item['biography'] ?? ''));
            $contacts = $this->normalizeContacts($item, $name);
            $socials = $this->normalizeSocials($item, $name);
            $action = $this->normalizeAction($item, $name);

            if (
                '' === $name
                && '' === $role
                && '' === $biography
                && '' === $image
                && [] === $contacts
                && [] === $socials
                && null === $action
            ) {
                continue;
            }

            $normalized[] = [
                'index' => \count($normalized) + 1,
                'image' => $image,
                'alt' => trim((string) ($item['alt'] ?? '')),
                'name' => $name,
                'role' => $role,
                'biography' => $biography,
                'contacts' => $contacts,
                'socials' => $socials,
                'action' => $action,
                'hasMedia' => '' !== $image,
            ];
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $item
     *
     * @return list<array{type: string, label: string, url: string, ariaLabel: string, target: bool}>
     */
    private function normalizeContacts(array $item, string $name): array
    {
        $contacts = [];
        $email = $this->normalizeEmail((string) ($item['email'] ?? ''));

        if ('' !== $email) {
            $contacts[] = [
                'type' => 'email',
                'label' => $email,
                'url' => 'mailto:'.$email,
                'ariaLabel' => $this->personLinkLabel('Email', $name),
                'target' => false,
            ];
        }

        $phone = $this->normalizePhone((string) ($item['phone'] ?? ''));

        if (null !== $phone) {
            $contacts[] = [
                'type' => 'phone',
                'label' => $phone['label'],
                'url' => 'tel:'.$phone['href'],
                'ariaLabel' => $this->personLinkLabel('Phone', $name),
                'target' => false,
            ];
        }

        $website = $this->normalizeWebUrl(trim((string) ($item['website'] ?? '')));

        if ('' !== $website) {
            $contacts[] = [
                'type' => 'website',
                'label' => 'Website',
                'url' => $website,
                'ariaLabel' => $this->personLinkLabel('Website', $name),
                'target' => false,
            ];
        }

        return $contacts;
    }

    /**
     * @param array<string, mixed> $item
     *
     * @return list<array{type: string, label: string, url: string, ariaLabel: string, target: bool}>
     */
    private function normalizeSocials(array $item, string $name): array
    {
        $socials = [];

        foreach (self::SOCIAL_FIELDS as $field => $meta) {
            $url = $this->normalizeWebUrl(trim((string) ($item[$field] ?? '')));

            if ('' === $url) {
                continue;
            }

            $label = $meta['label'];

            $socials[] = [
                'type' => $meta['type'],
                'label' => $label,
                'url' => $url,
                'ariaLabel' => $this->personLinkLabel($label, $name),
                'target' => false,
            ];
        }

        foreach ([1, 2] as $number) {
            $label = trim((string) ($item['genericLink'.$number.'Label'] ?? ''));
            $url = $this->normalizeWebUrl(trim((string) ($item['genericLink'.$number.'Url'] ?? '')));

            if ('' === $label || '' === $url) {
                continue;
            }

            $socials[] = [
                'type' => 'generic-'.$number,
                'label' => $label,
                'url' => $url,
                'ariaLabel' => $this->personLinkLabel($label, $name),
                'target' => false,
            ];
        }

        return $socials;
    }

    /**
     * @param array<string, mixed> $item
     *
     * @return array{label: string, url: string, target: bool, ariaLabel: string}|null
     */
    private function normalizeAction(array $item, string $name): ?array
    {
        $url = $this->normalizeUrl(trim((string) ($item['ctaUrl'] ?? '')));
        $label = trim((string) ($item['ctaLabel'] ?? ''));

        if ('' === $url || '' === $label) {
            return null;
        }

        return [
            'label' => $label,
            'url' => $url,
            'target' => $this->checkboxValue($item['ctaTarget'] ?? null),
            'ariaLabel' => $this->personLinkLabel($label, $name),
        ];
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

        $uuid = $this->normalizeUuid($value);

        if ('' === $uuid) {
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

        $path = $this->normalizePublicPath((string) $file->path);

        if ('' === $path) {
            return '';
        }

        $extension = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));

        if ('' === $extension || !\in_array($extension, $extensions, true)) {
            return '';
        }

        if ('' === $this->physicalPath($path)) {
            return '';
        }

        return $path;
    }

    /**
     * @param mixed $value
     */
    private function normalizeUuid($value): string
    {
        $uuid = $value;

        if (!\is_array($uuid)) {
            try {
                $uuid = StringUtil::deserialize($uuid);
            } catch (\Throwable $exception) {
                return '';
            }
        }

        if (\is_array($uuid)) {
            $uuid = reset($uuid);
        }

        if (!\is_string($uuid) || '' === $uuid) {
            return '';
        }

        return $uuid;
    }

    private function normalizePublicPath(string $path): string
    {
        $path = str_replace('\\', '/', trim($path));

        if ('' === $path) {
            return '';
        }

        if ($this->hasUnsafeCharacters($path)) {
            return '';
        }

        if ('/' === $path[0] || preg_match('/^[a-z][a-z0-9+.-]*:/i', $path)) {
            return '';
        }

        if (preg_match('#(^|/)\.\.(/|$)#', $path)) {
            return '';
        }

        return $path;
    }

    private function physicalPath(string $path): string
    {
        if (!\defined('TL_ROOT')) {
            return '';
        }

        $physicalPath = rtrim((string) TL_ROOT, '/\\').'/'.$path;

        return is_file($physicalPath) ? $physicalPath : '';
    }

    private function normalizeEmail(string $email): string
    {
        $email = trim($email);

        if ('' === $email || $this->hasUnsafeCharacters($email)) {
            return '';
        }

        return false !== filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }

    /**
     * @return array{label: string, href: string}|null
     */
    private function normalizePhone(string $phone): ?array
    {
        $label = trim($phone);

        if ('' === $label || $this->hasUnsafeCharacters($label)) {
            return null;
        }

        $href = preg_replace('/[^\d+]+/', '', $label) ?? '';

        if ('' !== $href && '+' === $href[0]) {
            $href = '+'.str_replace('+', '', substr($href, 1));
        } else {
            $href = str_replace('+', '', $href);
        }

        if (!preg_match('/\d/', $href)) {
            return null;
        }

        return [
            'label' => $label,
            'href' => $href,
        ];
    }

    private function normalizeWebUrl(string $url): string
    {
        $url = $this->normalizeUrl($url);

        if ('' === $url) {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url) && !preg_match('/^https?:/i', $url)) {
            return '';
        }

        return $url;
    }

    private function normalizeUrl(string $url): string
    {
        if ('' === $url) {
            return '';
        }

        if ($this->hasUnsafeCharacters($url)) {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url) && !preg_match('/^(https?:|mailto:|tel:)/i', $url)) {
            return '';
        }

        return $url;
    }

    private function personLinkLabel(string $label, string $name): string
    {
        return '' !== $name ? $label.': '.$name : $label;
    }

    private function itemHeadlineUnit(string $headlineUnit, bool $hasHeadline): string
    {
        if (!$hasHeadline) {
            return 'h3';
        }

        $levels = ['h1' => 'h2', 'h2' => 'h3', 'h3' => 'h4', 'h4' => 'h5', 'h5' => 'h6', 'h6' => 'h6'];

        return $levels[$headlineUnit] ?? 'h3';
    }

    /**
     * @param list<array{hasMedia: bool}> $items
     */
    private function itemsHaveMedia(array $items): bool
    {
        foreach ($items as $item) {
            if ($item['hasMedia']) {
                return true;
            }
        }

        return false;
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

    private function hasUnsafeCharacters(string $value): bool
    {
        return 1 === preg_match('/[\x00-\x1F\x7F<>"\']/', $value);
    }

    /**
     * @param mixed $value
     */
    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }
}
