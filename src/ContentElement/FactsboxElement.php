<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\StringUtil;

class FactsboxElement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_factsbox';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_factsbox');
        $this->assignHeadline();

        $this->Template->factsboxStyle = $this->normalizeOption((string) ($this->factsboxStyle ?: 'default'), ['default', 'compact', 'card'], 'default');
        $this->Template->factsboxItems = $this->normalizeItems(StringUtil::deserialize($this->factsboxItems, true));
    }

    /**
     * @param mixed $items
     *
     * @return list<array{label: string, value: string}>
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

            $label = \trim((string) ($item['label'] ?? ''));
            $value = \trim((string) ($item['value'] ?? ''));

            if ('' === $label && '' === $value) {
                continue;
            }

            $normalized[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        return $normalized;
    }
}
