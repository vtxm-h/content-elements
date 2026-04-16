<?php

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class ContentMembersGrid extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_members_grid';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_members_grid');

        $this->Template->headline = $this->headline;

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
        $uuid = StringUtil::deserialize($value, true);

        if (empty($uuid[0])) {
            return '';
        }

        $file = FilesModel::findByUuid($uuid[0]);

        return $file ? $file->path : '';
    }
}
