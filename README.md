# Content Elements (Contao)

Reusable Contao 4.13 content elements for VTXM projects.

This bundle contains presentation-ready content elements only. It intentionally does not include structural layout or container elements.

Structural elements such as `article-insert`, `layout-preset` and `content-grid` are handled separately.


## Features

Content elements included:

- Iconbox
- Media Text
- Link List
- Members Grid
- Live Teaser
- Quote Teaser
- Announcement
- Tabs
- Accordion
- Timeline
- Factsbox

The bundle is theme-agnostic:

- no frontend CSS included
- no JavaScript included
- stable template hooks
- Contao `cssID` support preserved


## Content Elements

The bundle registers these content elements in the `vtxm` category:

- `vtxm_iconbox`
- `vtxm_media_text`
- `vtxm_link_list`
- `vtxm_members_grid`
- `vtxm_live_teaser`
- `vtxm_quote_teaser`
- `vtxm_announcement`
- `vtxm_tabs`
- `vtxm_accordion`
- `vtxm_timeline`
- `vtxm_factsbox`


## Usage

Add a new content element from the `vtxm` category.

Typical use cases:

- `vtxm_iconbox` for service boxes, benefits or compact feature blocks
- `vtxm_media_text` for image/media plus text blocks, biographies, project stories and editorial image/text sections; supports image-left, image-right, image-top, image-bottom, float-left and float-right layouts plus default, editorial, card and minimal styles
- `vtxm_link_list` for structured links, social links, streaming platforms, downloads, press kits, booking links and external resources; supports default, buttons, icons and minimal styles plus left, center and right alignment
- `vtxm_members_grid` for team / band member layouts
- `vtxm_live_teaser` for concerts, events or live announcements
- `vtxm_quote_teaser` for quotes, reviews or press snippets
- `vtxm_announcement` for short announcements and callouts
- `vtxm_tabs` for tabbed content groups
- `vtxm_accordion` for FAQ-style expandable content
- `vtxm_timeline` for history, milestones or chronological entries
- `vtxm_factsbox` for structured key-value facts, project facts, band facts, metadata or technical details; supports default, compact and card styles


## Recommended Role

Use this bundle for reusable content blocks.

Recommended separation:

- `article-insert` = article include module
- `layout-preset` = macro layout / split layout
- `content-grid` = micro layout / grid container
- `content-elements` = reusable content blocks

Example structure:

```text
Content Grid
└── Source article: Services
      ├── Iconbox
      ├── Iconbox
      ├── Iconbox
      └── Iconbox
```


## MultiColumnWizard Fields

These elements use MultiColumnWizard fields in the Contao backend:

- `vtxm_tabs`
- `vtxm_accordion`
- `vtxm_timeline`
- `vtxm_factsbox`
- `vtxm_link_list`

Editors can manage entries in structured rows instead of writing JSON manually.


## Notes

No styling or JavaScript behavior is included by design.

Use your project CSS and JavaScript to define:

- spacing
- grid behavior
- colors
- animations
- tab switching
- accordion behavior

All elements preserve Contao `cssID` support through the shared `AbstractWrappedContentElement`.

The `iconboxIcon` value is escaped in the template. Use it for icon class names, labels or short markers. SVG or HTML icon markup is intentionally not rendered raw in this version.


## HTML Hooks

Root classes:

- `.ce_vtxm_iconbox`
- `.ce_vtxm_media_text`
- `.ce_vtxm_link_list`
- `.ce_vtxm_members_grid`
- `.ce_vtxm_live_teaser`
- `.ce_vtxm_quote_teaser`
- `.ce_vtxm_announcement`
- `.ce_vtxm_tabs`
- `.ce_vtxm_accordion`
- `.ce_vtxm_timeline`
- `.ce_vtxm_factsbox`

Factsbox hooks:

- `.factsbox__headline`
- `.factsbox__items`
- `.factsbox__item`
- `.factsbox__key`
- `.factsbox__value`
- `.factsbox--default`
- `.factsbox--compact`
- `.factsbox--card`

Factsbox styling is expected through `frontend-assets`, especially `css/vtxm-components.css`.

Media Text hooks:

- `.media-text__inner`
- `.media-text__media`
- `.media-text__caption`
- `.media-text__content`
- `.media-text__eyebrow`
- `.media-text__headline`
- `.media-text__text`
- `.media-text__action`
- `.media-text--image-left`
- `.media-text--image-right`
- `.media-text--image-top`
- `.media-text--image-bottom`
- `.media-text--float-left`
- `.media-text--float-right`
- `.media-text--default`
- `.media-text--editorial`
- `.media-text--card`
- `.media-text--minimal`

Media Text styling is expected through `frontend-assets`, especially `css/vtxm-components.css`.

Link List hooks:

- `.ce_vtxm_link_list`
- `.link-list__headline`
- `.link-list__items`
- `.link-list__item`
- `.link-list__link`
- `.link-list__icon`
- `.link-list__label`
- `.link-list__description`
- `.link-list--default`
- `.link-list--buttons`
- `.link-list--icons`
- `.link-list--minimal`
- `.link-list--align-left`
- `.link-list--align-center`
- `.link-list--align-right`

Link List styling is expected through `frontend-assets`, especially `css/vtxm-components.css`.

Additional hooks are available inside the individual templates.


## Templates

Templates are located at:

```text
src/Resources/contao/templates/
```

Templates:

- `ce_vtxm_iconbox.html5`
- `ce_vtxm_media_text.html5`
- `ce_vtxm_link_list.html5`
- `ce_vtxm_members_grid.html5`
- `ce_vtxm_live_teaser.html5`
- `ce_vtxm_quote_teaser.html5`
- `ce_vtxm_announcement.html5`
- `ce_vtxm_tabs.html5`
- `ce_vtxm_accordion.html5`
- `ce_vtxm_timeline.html5`
- `ce_vtxm_factsbox.html5`


## Requirements

This bundle requires:

- Contao 4.13
- PHP 8.0+
- `menatwork/contao-multicolumnwizard-bundle`


## Installation (via Composer / Contao Manager)

Add the package definition to your Contao project `composer.json` or install it via your configured repository setup.

Example package reference:

```json
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "vtxm-h/content-elements",
        "version": "1.0.6",
        "type": "contao-bundle",
        "license": "MIT",
        "description": "Reusable Contao 4.13 content elements for VTXM projects.",
        "dist": {
          "url": "https://github.com/vtxm-h/content-elements/archive/refs/tags/v1.0.6.zip",
          "type": "zip"
        },
        "autoload": {
          "psr-4": {
            "Vendor\\ContentElementsBundle\\": "src/"
          }
        },
        "require": {
          "php": "^8.0",
          "contao/core-bundle": "^4.13",
          "contao/manager-plugin": "^2.0",
          "menatwork/contao-multicolumnwizard-bundle": "^3.6"
        },
        "extra": {
          "contao-manager-plugin": "Vendor\\ContentElementsBundle\\ContaoManager\\Plugin"
        }
      }
    }
  ]
}
```

Install:

```bash
composer require vtxm-h/content-elements
```

Then update the Contao database so the new `tl_content` fields are created.


## Compatibility

Contao 4.13
PHP 8.0+

## License

MIT
