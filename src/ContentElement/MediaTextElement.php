<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\FilesModel;
use Contao\StringUtil;

class MediaTextElement extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_media_text';

    protected function compile()
    {
        $this->assignWrapper('ce_vtxm_media_text');
        $this->assignHeadline();

        $this->Template->mediaTextLayout = $this->normalizeOption((string) ($this->mediaTextLayout ?: 'image-left'), ['image-top', 'image-left', 'image-right', 'image-bottom', 'float-left', 'float-right'], 'image-left');
        $this->Template->mediaTextStyle = $this->normalizeOption((string) ($this->mediaTextStyle ?: 'default'), ['default', 'editorial', 'card', 'minimal'], 'default');
        $this->Template->mediaTextEyebrow = (string) $this->mediaTextEyebrow;
        $this->Template->mediaTextText = (string) $this->text;
        $this->Template->mediaTextUrl = (string) $this->url;
        $this->Template->mediaTextLinkTitle = (string) ($this->linkTitle ?: $this->url);
        $this->Template->mediaTextTarget = (bool) $this->target;
        $this->Template->mediaTextImage = $this->resolveImage($this->singleSRC);
        $this->Template->mediaTextAlt = (string) $this->alt;
        $this->Template->mediaTextCaption = (string) $this->caption;
    }

    private function resolveImage($value): string
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

        return $file ? (string) $file->path : '';
    }
}
