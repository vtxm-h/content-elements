# Content Elements

Reusable Contao 4.13 content elements for VTXM projects.

This bundle contains presentation-ready content elements only. It intentionally does not include structural layout or container elements.

## Installation

Add the repository to your Contao project:

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

Then install the package:

```bash
composer require vtxm-h/content-elements
```

Update the database in the Contao install tool or Contao Manager afterwards.

## Content Elements

The bundle registers these content elements in the `vtxm` category:

- `vtxm_iconbox`
- `vtxm_members_grid`
- `vtxm_live_teaser`
- `vtxm_quote_teaser`
- `vtxm_announcement`
- `vtxm_tabs`
- `vtxm_accordion`
- `vtxm_timeline`

## Templates

Templates are located in `src/Resources/contao/templates/`:

- `ce_vtxm_iconbox.html5`
- `ce_vtxm_members_grid.html5`
- `ce_vtxm_live_teaser.html5`
- `ce_vtxm_quote_teaser.html5`
- `ce_vtxm_announcement.html5`
- `ce_vtxm_tabs.html5`
- `ce_vtxm_accordion.html5`
- `ce_vtxm_timeline.html5`

## Styling

No frontend CSS or JavaScript is included. The templates expose stable classes and data attributes so project themes can style and enhance the elements as needed.

All elements preserve Contao `cssID` support through the shared `AbstractWrappedContentElement`.

## Item Fields

Tabs, accordion and timeline use MultiColumnWizard fields in the Contao backend. Editors can manage entries in structured rows.

## Requirements

- Contao `^4.13`
- PHP `^8.0`
- `menatwork/contao-multicolumnwizard-bundle`

## License

MIT
