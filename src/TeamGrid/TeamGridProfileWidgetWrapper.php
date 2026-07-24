<?php

declare(strict_types=1);

namespace Vendor\ContentElementsBundle\TeamGrid;

use Contao\Backend;
use Contao\Widget;

final class TeamGridProfileWidgetWrapper
{
    /**
     * @param mixed $dataContainer
     */
    public function renderPagePicker($dataContainer, Widget $widget): string
    {
        $widgetId = (string) $widget->id;

        if (1 !== preg_match('/^teamGridItems_row\d+_(?:website|link[123]Url)$/', $widgetId)) {
            return '';
        }

        return Backend::getDcaPickerWizard(true, 'tl_content', 'teamGridItems', $widgetId);
    }

    public function wrap(string $buffer, Widget $widget): string
    {
        $widgetId = (string) $widget->id;

        if (1 !== preg_match('/^teamGridItems_row\d+_[a-zA-Z0-9]+$/', $widgetId)) {
            return $buffer;
        }

        preg_match_all(
            '/(?:^|\s)(team-grid-profile-field(?:--[a-z0-9-]+)?)(?=\s|$)/',
            (string) $widget->tl_class,
            $matches
        );

        $classes = array_values(array_unique($matches[1] ?? []));

        if (!\in_array('team-grid-profile-field', $classes, true)) {
            return $buffer;
        }

        return '<div class="widget '.implode(' ', $classes).'">'.$buffer.'</div>';
    }
}
