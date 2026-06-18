# Content Elements (Contao)

Reusable Contao 4.13 content elements for VTXM projects.

This bundle contains presentation-ready content elements only. It intentionally does not include structural layout or container elements.

Structural elements such as `article-insert`, `layout-preset` and `content-grid` are handled separately.


## Features

Content elements included:

- Iconbox
- Media Text
- Link List
- Slider
- Teaser Grid
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
- `vtxm_slider`
- `vtxm_teaser_grid`
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
- `vtxm_slider` for structured Splide-compatible hero sliders, image sliders, quotes and card sliders; supports hero, images, cards and quotes styles plus autoplay, arrows, pagination, loop, perPage and gap settings
- `vtxm_teaser_grid` for reusable teaser cards with image, title, text, badge and optional link; supports default, cards, editorial and minimal styles plus 2, 3 or 4 columns and small, medium or large gaps
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
- `vtxm_slider`
- `vtxm_teaser_grid`

Editors can manage entries in structured rows instead of writing JSON manually.


## Teaser Grid

`vtxm_teaser_grid` renders reusable teaser entries in a stable frontend structure. It is intended for project teasers, editorial cards, campaign links or compact overview grids.

Available styles:

- `default`
- `cards`
- `editorial`
- `minimal`

Column options:

- `2`
- `3`
- `4`

Gap options:

- `small`
- `medium`
- `large`

Item fields:

- image
- alt text
- title
- text
- badge
- link URL
- link label
- new-window target

Images are selected through the Contao file picker and resolved from stored UUIDs. Invalid UUIDs, folders and missing files do not render an image. No image resizing, fullsize or lightbox behavior is included in this element.

The badge and link are optional. Links are rendered only when both a URL and a visible label are provided. The entire teaser card is not clickable.

This bundle does not include frontend CSS or JavaScript for Teaser Grid. Styling is expected through `frontend-assets` or project CSS.


## Notes

No styling or JavaScript behavior is included by design.

Use your project CSS and JavaScript to define:

- spacing
- grid behavior
- colors
- animations
- tab switching
- accordion behavior
- slider initialization

All elements preserve Contao `cssID` support through the shared `AbstractWrappedContentElement`.

The `iconboxIcon` value is escaped in the template. Use it for icon class names, labels or short markers. SVG or HTML icon markup is intentionally not rendered raw in this version.

The `vtxm_slider` element outputs Splide-compatible markup and data attributes only. Styling and JavaScript are expected through `frontend-assets`, especially `css/vtxm-components.css`, `js/vtxm-components.js`, and vendor Splide assets or a local Splide build.


## HTML Hooks

Root classes:

- `.ce_vtxm_iconbox`
- `.ce_vtxm_media_text`
- `.ce_vtxm_link_list`
- `.ce_vtxm_slider`
- `.ce_vtxm_teaser_grid`
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

Slider hooks:

- `.ce_vtxm_slider`
- `.vtxm-slider`
- `.vtxm-slider__slide`
- `.vtxm-slider__item`
- `.vtxm-slider__media`
- `.vtxm-slider__content`
- `.vtxm-slider__eyebrow`
- `.vtxm-slider__headline`
- `.vtxm-slider__text`
- `.vtxm-slider__action`
- `.slider--hero`
- `.slider--images`
- `.slider--cards`
- `.slider--quotes`
- `.slider--gap-none`
- `.slider--gap-small`
- `.slider--gap-medium`
- `.slider--gap-large`
- `[data-vtxm-slider]`

Slider styling and JavaScript initialization are expected through `frontend-assets`, especially `css/vtxm-components.css`, `js/vtxm-components.js`, and vendor Splide assets or a local Splide build.

Teaser Grid hooks:

- `.ce_vtxm_teaser_grid`
- `.teaser-grid`
- `.teaser-grid--default`
- `.teaser-grid--cards`
- `.teaser-grid--editorial`
- `.teaser-grid--minimal`
- `.teaser-grid--cols-2`
- `.teaser-grid--cols-3`
- `.teaser-grid--cols-4`
- `.teaser-grid--gap-small`
- `.teaser-grid--gap-medium`
- `.teaser-grid--gap-large`
- `.teaser-grid__headline`
- `.teaser-grid__items`
- `.teaser-grid__item`
- `.teaser-grid__media`
- `.teaser-grid__image`
- `.teaser-grid__overlay`
- `.teaser-grid__content`
- `.teaser-grid__title`
- `.teaser-grid__text`
- `.teaser-grid__link`
- `.teaser-grid__badge`

Teaser Grid styling is expected through `frontend-assets`, especially `css/vtxm-components.css`, or project CSS.

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
- `ce_vtxm_slider.html5`
- `ce_vtxm_teaser_grid.html5`
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
        "version": "1.1.0",
        "type": "contao-bundle",
        "license": "MIT",
        "description": "Reusable Contao 4.13 content elements for VTXM projects.",
        "dist": {
          "url": "https://github.com/vtxm-h/content-elements/archive/refs/tags/v1.1.0.zip",
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
