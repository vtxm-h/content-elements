# Content Elements (Contao)

Reusable Contao content elements bundle providing a collection of structured, theme-agnostic components.

Designed for flexible use across projects: clean HTML output, no enforced styling or JavaScript.


## Features

Content elements included:

- Accordion
- Tabs
- Members Grid
- Live Teaser
- Timeline
- Quote Teaser
- Announcement
- Feature Grid (Parent)
- Feature Item (Child)

### Feature Grid System

- Parent element: **Feature Grid**
- Child elements: **Feature Item**
- Fully Contao-native (no MultiColumnWizard)
- Drag & drop ordering via content elements

Each feature item contains:
- Icon (HTML / SVG / class)
- Headline
- Text (RTE)
- Optional link

Grid configuration:
- Styles:
  - centered
  - inline
  - minimal
- Columns:
  - 2
  - 3
  - 4
- Theme:
  - light
  - dark


## Requirements

This bundle requires:

contao/core-bundle ^4.13  
PHP 8.0+

No additional dependencies required.


## Usage

- Add content elements from category **vtxm**
- Configure fields per element

### Feature Grid

- Add **Feature Grid**
- Inside it, add multiple **Feature Item** elements
- Configure grid style, columns and theme

### Other Elements

- Accordion / Tabs / Timeline use structured data fields
- Members Grid uses fixed positions (top, left, right, bottom)
- Live Teaser / Announcement / Quote Teaser are standalone blocks

## Notes

- No JavaScript is included by design
- No styling is enforced
- All elements output clean HTML hooks

You are expected to handle:
- Styling (CSS / Tailwind / etc.)
- Interaction (JS)

## HTML Hooks

Examples:

- Feature Grid:
  - `.feature-grid`
  - `.feature-grid__item`

- Tabs:
  - `[data-tabs]`
  - `.tabs__button`
  - `.tabs__panel`

- Accordion:
  - `.accordion-item`

- Members Grid:
  - `[data-members-grid]`

## Templates

Templates are located at:

src/Resources/contao/templates/

Examples:

- ce_vtxm_feature_grid.html5
- ce_vtxm_feature_item.html5
- ce_vtxm_tabs.html5
- ce_vtxm_accordion.html5
- ce_vtxm_members_grid.html5
- ce_vtxm_live_teaser.html5
- ce_vtxm_timeline.html5
- ce_vtxm_quote_teaser.html5
- ce_vtxm_announcement.html5


## Installation (via Composer / Contao Manager)

Add the repository to your **Contao project** `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/vtxm-h/content-elements"
    }
  ]
}
```
## Compatibility

Contao 4.13
PHP 8.0+

## License

MIT
