<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\ContentElement;
use Contao\StringUtil;

abstract class AbstractWrappedContentElement extends ContentElement
{
    protected function assignWrapper(string $baseClass): void
    {
        $rawCssId = $this->arrData['cssID'] ?? [];

        if (!\is_array($rawCssId)) {
            $rawCssId = StringUtil::deserialize($rawCssId, true);
        }

        $extraClasses = [];

        if (!empty($rawCssId[1])) {
            $extraClasses = preg_split('/\s+/', trim((string) $rawCssId[1])) ?: [];
        }

        $classes = array_merge([$baseClass], $extraClasses);

        $this->Template->elementId = (string) ($rawCssId[0] ?? '');
        $this->Template->elementClass = implode(' ', array_filter($classes));
    }

    protected function assignHeadline(string $defaultUnit = 'h2'): void
    {
        $headline = StringUtil::deserialize($this->headline, true);
        $unit = (string) ($headline['unit'] ?? $defaultUnit);

        if (!\in_array($unit, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true)) {
            $unit = $defaultUnit;
        }

        $this->Template->headlineText = trim((string) ($headline['value'] ?? ''));
        $this->Template->headlineUnit = $unit;
    }

    protected function decodeItems(string $value): array
    {
        $data = json_decode($value, true);

        return \is_array($data) ? $data : [];
    }

    protected function normalizeOption(string $value, array $allowed, string $default): string
    {
        return \in_array($value, $allowed, true) ? $value : $default;
    }
}
