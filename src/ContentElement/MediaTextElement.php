<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\Config;
use Contao\FilesModel;
use Contao\StringUtil;

class MediaTextElement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_media_text';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_media_text');
        $this->assignHeadline();

        $size = $this->normalizeSize($this->size);
        $image = $this->resolveImage($this->singleSRC, $size);
        $url = $this->normalizeUrl(trim((string) $this->url));
        $linkTitle = trim((string) $this->linkTitle);
        $alt = trim((string) $this->alt);

        if ('' === $alt && '' !== $image['metaAlt']) {
            $alt = $image['metaAlt'];
        }

        if ('' === $linkTitle && '' !== $url) {
            $linkTitle = $url;
        }

        $eyebrow = trim((string) $this->mediaTextEyebrow);
        $text = (string) $this->text;
        $caption = trim((string) $this->caption);
        $hasAction = '' !== $url && '' !== $linkTitle;

        $this->Template->mediaTextLayout = $this->normalizeOption((string) ($this->mediaTextLayout ?: 'image-left'), ['image-top', 'image-left', 'image-right', 'image-bottom', 'float-left', 'float-right'], 'image-left');
        $this->Template->mediaTextStyle = $this->normalizeOption((string) ($this->mediaTextStyle ?: 'default'), ['default', 'editorial', 'card', 'minimal'], 'default');
        $this->Template->mediaTextEyebrow = $eyebrow;
        $this->Template->mediaTextText = $text;
        $this->Template->mediaTextUrl = $url;
        $this->Template->mediaTextLinkTitle = $linkTitle;
        $this->Template->mediaTextTarget = $this->checkboxValue($this->target);
        $this->Template->mediaTextImage = $image['src'];
        $this->Template->mediaTextImageWidth = $image['width'];
        $this->Template->mediaTextImageHeight = $image['height'];
        $this->Template->mediaTextOriginalImage = $image['original'];
        $this->Template->mediaTextSize = $size;
        $this->Template->mediaTextAlt = $alt;
        $this->Template->mediaTextCaption = $caption;
        $this->Template->mediaTextFullsize = $this->checkboxValue($this->fullsize) && '' !== $image['original'];
        $this->Template->mediaTextHasImage = '' !== $image['src'];
        $this->Template->mediaTextHasContent =
            '' !== $eyebrow
            || '' !== trim(strip_tags($text))
            || $hasAction
            || '' !== trim((string) $this->Template->headlineText);
    }

    /**
     * @param mixed $value
     * @param array{width: int, height: int, mode: string} $size
     *
     * @return array{src: string, original: string, width: int, height: int, metaAlt: string}
     */
    private function resolveImage($value, array $size): array
    {
        $empty = [
            'src' => '',
            'original' => '',
            'width' => 0,
            'height' => 0,
            'metaAlt' => '',
        ];
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

        $physicalPath = $this->physicalPath($path);

        if ('' === $physicalPath) {
            return $empty;
        }

        $naturalDimensions = $this->imageDimensions($physicalPath, $extension);
        $dimensions = $this->outputDimensions($size, $naturalDimensions);

        return [
            'src' => $path,
            'original' => $path,
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
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

    /**
     * @param mixed $value
     *
     * @return array{width: int, height: int, mode: string}
     */
    private function normalizeSize($value): array
    {
        if (!\is_array($value)) {
            try {
                $value = StringUtil::deserialize($value, true);
            } catch (\Throwable $exception) {
                $value = [];
            }
        }

        if (!\is_array($value)) {
            $value = [];
        }

        $mode = trim((string) ($value[2] ?? $value['mode'] ?? ''));

        if (preg_match('/[\x00-\x1F\x7F<>"\']/', $mode)) {
            $mode = '';
        }

        return [
            'width' => $this->positiveInteger($value[0] ?? $value['width'] ?? null),
            'height' => $this->positiveInteger($value[1] ?? $value['height'] ?? null),
            'mode' => $mode,
        ];
    }

    /**
     * @return array{width: int, height: int}
     */
    private function imageDimensions(string $physicalPath, string $extension): array
    {
        if ('svg' === $extension) {
            return ['width' => 0, 'height' => 0];
        }

        $size = @getimagesize($physicalPath);

        if (!\is_array($size)) {
            return ['width' => 0, 'height' => 0];
        }

        return [
            'width' => $this->positiveInteger($size[0] ?? null),
            'height' => $this->positiveInteger($size[1] ?? null),
        ];
    }

    /**
     * @param array{width: int, height: int, mode: string} $size
     * @param array{width: int, height: int}               $naturalDimensions
     *
     * @return array{width: int, height: int}
     */
    private function outputDimensions(array $size, array $naturalDimensions): array
    {
        $width = $size['width'];
        $height = $size['height'];

        if (0 === $width && 0 === $height) {
            return $naturalDimensions;
        }

        return [
            'width' => $width,
            'height' => $height,
        ];
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
    private function positiveInteger($value): int
    {
        $value = trim((string) $value);

        if (!preg_match('/^\d+$/', $value)) {
            return 0;
        }

        return max(0, (int) $value);
    }

    /**
     * @param mixed $value
     */
    private function checkboxValue($value): bool
    {
        return '1' === (string) $value || 1 === $value || true === $value;
    }
}
