<?php

namespace Vendor\ContentElementsBundle\ContentElement;

use Contao\ContentModel;

class ContentFeatureGrid extends AbstractWrappedContentElement
{
    protected $strTemplate = 'ce_vtxm_feature_grid';

    protected function compile(): void
    {
        $this->assignWrapper('ce_vtxm_feature_grid');

        $this->Template->headline = $this->headline;
        $this->Template->fgStyle = (string) $this->fgStyle;
        $this->Template->fgColumns = (string) $this->fgColumns;
        $this->Template->fgTheme = (string) $this->fgTheme;
        $this->Template->items = [];

        $elements = ContentModel::findPublishedByPidAndTable($this->id, 'tl_content');

        if (null !== $elements) {
            while ($elements->next()) {
                if ($elements->type === 'vtxm_feature_item') {
                    $this->Template->items[] = $this->getContentElement($elements->id);
                }
            }
        }
    }
}
