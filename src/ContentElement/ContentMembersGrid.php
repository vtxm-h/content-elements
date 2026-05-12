<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class ContentMembersGrid extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_members_grid';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_members_grid');
        $this->assignHeadline();

        $this->Template->members = [
            'top' => [
                'name' => (string) $this->memberNameTop,
                'image' => $this->resolveImage($this->memberImageTop),
            ],
            'left' => [
                'name' => (string) $this->memberNameLeft,
                'image' => $this->resolveImage($this->memberImageLeft),
            ],
            'right' => [
                'name' => (string) $this->memberNameRight,
                'image' => $this->resolveImage($this->memberImageRight),
            ],
            'bottom' => [
                'name' => (string) $this->memberNameBottom,
                'image' => $this->resolveImage($this->memberImageBottom),
            ],
        ];
    }

    protected function resolveImage($value): string
    {
        $uuid = $value;

        if (!\is_array($uuid)) {
            $uuid = StringUtil::deserialize($uuid);
        }

        if (\is_array($uuid)) {
            $uuid = reset($uuid);
        }

        if (empty($uuid)) {
            return '';
        }

        $file = FilesModel::findByUuid($uuid);

        return $file ? $file->path : '';
    }
}
