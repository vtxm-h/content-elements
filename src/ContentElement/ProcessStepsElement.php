<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\Config;
use Contao\FilesModel;
use Contao\StringUtil;

class ProcessStepsElement extends AbstractWrappedContentElement
{
    private const VARIANT_VALUES = ['process', 'timeline'];
    private const ORIENTATION_VALUES = ['vertical', 'horizontal'];
    private const MARKER_STYLE_VALUES = ['number', 'icon', 'dot'];
    private const ALIGN_VALUES = ['left', 'center', 'right', 'alternate'];
    private const REVEAL_VALUES = ['none', 'fade-up'];

    protected $strTemplate = 'ce_vtxm_process_steps';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_process_steps process-steps');
        $this->assignHeadline();

        $intro = (string) $this->processStepsIntro;
        $items = $this->normalizeItems($this->deserializeItems($this->processStepsItems));

        $this->Template->processStepsVariant = $this->normalizeOption((string) ($this->processStepsVariant ?: 'process'), self::VARIANT_VALUES, 'process');
        $this->Template->processStepsOrientation = $this->normalizeOption((string) ($this->processStepsOrientation ?: 'vertical'), self::ORIENTATION_VALUES, 'vertical');
        $this->Template->processStepsMarkerStyle = $this->normalizeOption((string) ($this->processStepsMarkerStyle ?: 'number'), self::MARKER_STYLE_VALUES, 'number');
        $this->Template->processStepsAlign = $this->normalizeOption((string) ($this->processStepsAlign ?: 'left'), self::ALIGN_VALUES, 'left');
        $this->Template->processStepsReveal = $this->normalizeOption((string) ($this->processStepsReveal ?: 'none'), self::REVEAL_VALUES, 'none');
        $this->Template->processStepsIntro = $intro;
        $this->Template->processStepsItems = $items;
        $this->Template->processStepsHasHeader = '' !== trim((string) $this->Template->headlineText) || '' !== trim($intro);
        $this->Template->processStepsHasContent = $this->Template->processStepsHasHeader || [] !== $items;
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
     * @return list<array{index: int, marker: string, eyebrow: string, title: string, text: string, icon: string, image: string, alt: string, linkUrl: string, linkLabel: string, target: bool, cssClass: string}>
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
            $title = trim((string) ($item['title'] ?? ''));
            $text = trim((string) ($item['text'] ?? ''));
            $icon = $this->normalizeIcon((string) ($item['icon'] ?? ''));
            $linkUrl = $this->normalizeUrl(trim((string) ($item['linkUrl'] ?? '')));
            $linkLabel = trim((string) ($item['linkLabel'] ?? ''));
            $hasLink = '' !== $linkUrl && '' !== $linkLabel;

            if ('' === $eyebrow && '' === $title && '' === $text && '' === $icon && '' === $image['src'] && !$hasLink) {
                continue;
            }

            $index = \count($normalized) + 1;
            $marker = trim((string) ($item['marker'] ?? ''));
            $alt = trim((string) ($item['alt'] ?? ''));

            if ('' === $marker) {
                $marker = (string) $index;
            }

            if ('' === $alt && '' !== $image['metaAlt']) {
                $alt = $image['metaAlt'];
            }

            $normalized[] = [
                'index' => $index,
                'marker' => $marker,
                'eyebrow' => $eyebrow,
                'title' => $title,
                'text' => $text,
                'icon' => $icon,
                'image' => $image['src'],
                'alt' => $alt,
                'linkUrl' => $linkUrl,
                'linkLabel' => $linkLabel,
                'target' => $this->checkboxValue($item['target'] ?? null),
                'cssClass' => $this->normalizeCssClasses((string) ($item['cssClass'] ?? '')),
            ];
        }

        return $normalized;
    }

    /**
     * @param mixed $value
     *
     * @return array{src: string, metaAlt: string}
     */
    private function resolveImage($value): array
    {
        $empty = ['src' => '', 'metaAlt' => ''];
        $extensions = $this->configuredExtensions('validImageTypes');

        if ([] === $extensions) {
            return $empty;
        }

        $uuid = $this->normalizeUuid($value);

        if ('' === $uuid) {
            return $empty;
        }

        try {
            $file = FilesModel::findByUuid($uuid);
        } catch (\Throwable $exception) {
            return $empty;
        }

        if (!$file || 'file' !== (string) $file->type) {
            return $empty;
        }

        $path = $this->normalizePublicPath((string) $file->path);

        if ('' === $path) {
            return $empty;
        }

        $extension = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));

        if ('' === $extension || !\in_array($extension, $extensions, true)) {
            return $empty;
        }

        if ('' === $this->physicalPath($path)) {
            return $empty;
        }

        return [
            'src' => $path,
            'metaAlt' => $this->metadataAlt($file),
        ];
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

        if (preg_match('/[\x00-\x1F\x7F<>"\']/', $path)) {
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

    private function metadataAlt(FilesModel $file): string
    {
        $language = trim((string) ($GLOBALS['TL_LANGUAGE'] ?? ''));

        if ('' === $language) {
            return '';
        }

        try {
            $meta = StringUtil::deserialize($file->meta, true);
        } catch (\Throwable $exception) {
            return '';
        }

        if (!\is_array($meta) || !isset($meta[$language]) || !\is_array($meta[$language])) {
            return '';
        }

        return trim((string) ($meta[$language]['alt'] ?? ''));
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

    private function normalizeCssClasses(string $classes): string
    {
        $classes = preg_split('/\s+/', trim($classes)) ?: [];
        $normalized = [];

        foreach ($classes as $class) {
            $class = preg_replace('/[^A-Za-z0-9_-]+/', '-', $class) ?? '';
            $class = trim($class, '-_');

            if ('' !== $class) {
                $normalized[] = $class;
            }
        }

        return implode(' ', array_values(array_unique($normalized)));
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

    /**
     * @param mixed $value
     */
    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }
}
