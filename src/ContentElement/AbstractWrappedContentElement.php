<?php

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
}
