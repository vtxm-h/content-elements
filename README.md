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
- Team Grid
- Members Grid
- Live Teaser
- Quote Teaser
- Announcement
- Tabs
- Accordion
- Timeline
- Process Steps / Timeline
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
- `vtxm_team_grid`
- `vtxm_members_grid`
- `vtxm_live_teaser`
- `vtxm_quote_teaser`
- `vtxm_announcement`
- `vtxm_tabs`
- `vtxm_accordion`
- `vtxm_timeline`
- `vtxm_process_steps`
- `vtxm_factsbox`


## Usage

Add a new content element from the `vtxm` category.

Typical use cases:

- `vtxm_iconbox` for service boxes, benefits or compact feature blocks
- `vtxm_media_text` for image/media plus text blocks, biographies, project stories and editorial image/text sections; supports image-left, image-right, image-top, image-bottom, float-left and float-right layouts plus default, editorial, card and minimal styles
- `vtxm_link_list` for structured links and Contact Links such as websites, email, telephone, WhatsApp, profile links, streaming platforms, downloads, press kits, booking links and external resources; supports standard, icons-only, left/right edge, buttons and minimal styles plus left, center and right alignment
- `vtxm_slider` for structured Splide-compatible hero sliders, image sliders, background-video heroes, quotes, card sliders and no-JavaScript Static Hero output; supports hero, images, cards and quotes styles plus render mode, autoplay, arrows, pagination, loop, perPage, gap, transition, image effect, text animation, overlay, width, height, pattern, alignment and scroll-fade settings
- `vtxm_teaser_grid` for reusable teaser cards with image, title, text, badge and optional link; supports default, cards, editorial and minimal styles plus 2, 3 or 4 columns and small, medium or large gaps
- `vtxm_team_grid` for repeatable team/profile grids with image, role, biography, first-class contact links, social links, two generic profile links and one primary CTA
- `vtxm_members_grid` for the existing fixed four-position team / band member layout
- `vtxm_live_teaser` for concerts, events or live announcements
- `vtxm_quote_teaser` for quotes, reviews or press snippets
- `vtxm_announcement` for short announcements and callouts
- `vtxm_tabs` for tabbed content groups
- `vtxm_accordion` for FAQ-style expandable content
- `vtxm_timeline` for history, milestones or chronological entries
- `vtxm_process_steps` for process steps, project phases, how-it-works sections, milestones or reusable timelines; supports process and timeline variants, vertical and horizontal orientation, number, icon or dot markers, alignment hooks and optional reveal hooks
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
- `vtxm_team_grid`
- `vtxm_process_steps`

Editors can manage entries in structured rows instead of writing JSON manually.


## Media Text

`vtxm_media_text` renders one optional image/media block next to editorial content. It is intended for image/text sections, biographies, project stories and compact editorial blocks.

Available layouts:

- `image-top`
- `image-left`
- `image-right`
- `image-bottom`
- `float-left`
- `float-right`

Available styles:

- `default`
- `editorial`
- `card`
- `minimal`

The template emits `.media-text` and `[data-vtxm-media-text]` on the component root plus `.media-text__inner` around the media/content pair. These hooks define the Media Text layout boundary independently of VTXM Section elements. `frontend-assets` or project CSS must establish a modern formatting context on that boundary, preferably with `display: flow-root` on `.media-text` or `.media-text__inner`, so floated media in the `float-left` and `float-right` variants cannot affect following content elements. The remaining position variants can continue to use their existing grid or flex behavior.

The image is selected through the Contao `singleSRC` file picker. Stored UUIDs are resolved through Contao's file model and only valid image files with configured image extensions are rendered. Invalid UUIDs, folders, missing files and files outside the configured image types do not render broken image markup.

The explicit alt text field is used first. If it is empty, the element tries to use the selected file metadata alt text for the current frontend language. It does not derive alt text from filenames or captions.

The Contao `size` field is normalized and exposed to the template. Width and height attributes are emitted when reliable values are available: configured size dimensions are used when present; otherwise natural local image dimensions are used when they can be read safely. SVG files can render, but SVG dimensions are not inferred by this bundle. The element keeps the original image path and does not generate resized image files or cache paths.

The custom Media Text backend palette does not expose Contao's `fullsize` option (labelled “Großansicht/Neues Fenster” in German). The Contao core field and database value are not changed globally. Existing stored values remain compatible with the legacy renderer, but editors cannot enable or change this option through the Media Text palette. The separate editorial action fields `url`, `linkTitle` and `target` remain available.

Captions are escaped and rendered inside the figure only when set. Multiline captions keep safe line breaks. The text field keeps Contao editor-managed rich text output. The optional action link is rendered only for a safe URL and uses `rel="noopener noreferrer"` when opened in a new window.

Existing Media Text records remain compatible. Visual layout, responsive styling, card/editorial/minimal presentation, hover states and any lightbox behavior belong in `frontend-assets` or project CSS/JavaScript, not in this bundle.


## Quote Teaser

`vtxm_quote_teaser` renders one reusable quote card. It does not include a grid or card-arrangement system. To arrange multiple Quote Teasers, place the individual elements through `content-grid`.

The component root exposes `.ce_vtxm_quote_teaser`, `.quote-teaser` and `[data-vtxm-quote-teaser]`. Quote text uses a semantic `blockquote` with `.quote-teaser__quote` and `.quote-teaser__text`. Optional attribution is rendered outside the quoted content in `.quote-teaser__attribution`; the author uses `.quote-teaser__author`, while the existing `quoteMeta` source metadata uses a semantic `cite` with `.quote-teaser__source`. The existing optional link retains `.quote-teaser__action` and adds `.quote-teaser__link`.

Quote Teaser currently exposes no backend style or variant option. Frontend styling should therefore target the stable base hooks rather than assume a stored variant. Card borders, radii, shadows, spacing, accent lines, typography, equal-height behavior and responsive presentation belong in `frontend-assets` or project CSS and are not implemented in this bundle.


## Link List / Contact Links

`vtxm_link_list` remains the single reusable element type for structured links and Contact Links. No dedicated Social Links element is included.

Contact Links can point to final editor-entered destinations such as:

- website or profile URLs, for example `https://example.com`
- email links, for example `mailto:info@example.com`
- telephone links, for example `tel:+491701234567`
- WhatsApp links, for example `https://wa.me/491701234567` or `https://wa.me/491701234567?text=Hello`

Editors enter the final destination URL. The element does not generate WhatsApp URLs from phone numbers, does not normalize phone numbers and does not prepend `https://` to `mailto:` or `tel:` values. Query strings and fragments are preserved. Dangerous schemes such as `javascript:` are ignored by the renderer.

The existing MultiColumnWizard row structure stays compatible. Existing rows with `label`, `url`, `icon`, `description` and `target` keep rendering. New row flags are optional:

- `nofollow` adds `nofollow` to the link's `rel` tokens.
- `relMe` adds `me` for profile verification via `rel="me"`.

Rel values are generated centrally with stable token order. New-window links keep `noopener noreferrer`; optional `nofollow` and `me` are added without duplicates. Empty `rel` attributes are not emitted.

Available display styles:

- `default`: Standard link list output.
- `icons`: Icons-only output. The legacy stored value is preserved and now also emits `.link-list--icons-only`.
- `edge-left`: Contact Links hooks for a left page-edge presentation.
- `edge-right`: Contact Links hooks for a right page-edge presentation.
- `buttons`: Existing button-style output.
- `minimal`: Existing minimal output.

The free-text icon marker is preserved. It is normalized to a safe class suffix and exposed through stable classes and data hooks. No predefined platform select, fixed platform list, icon library, SVG injection or unsafe HTML is included.

Icons-only output keeps labels in the DOM so they remain accessible. Labels are expected to be visually hidden by frontend CSS, not removed. If an icons-only row has no usable icon marker, the template emits a visible text fallback so the link is not blank.

Edge variants only provide semantic server-rendered markup hooks in this bundle. Fixed positioning, slide-out presentation, hover/focus expansion and mobile or touch fallback belong in `frontend-assets` or project CSS. The frontend implementation must reveal labels for both hover and keyboard focus, for example with `:hover` and `:focus-within`. Edge positioning can overlap page content, so projects must be able to override or disable that positioning. No JavaScript is required by this bundle.

Existing Link List records remain compatible. The element still emits native anchors, escapes `href` attributes, keeps visible or visually hidden label text as the accessible name and does not add `aria-label` when meaningful label text is already present.


## Slider

`vtxm_slider` outputs structured hero, image, card, quote and decorative background-video content in one of two render modes. It does not include Splide, Splide Premium files, CSS, JavaScript, scroll listeners, video lifecycle code or slider initialization.

Render modes:

- `slider`: existing Splide-compatible carousel markup and configuration for multi-item sliders
- `static`: Static Hero output for one editorial or media hero that must remain usable without JavaScript

Static Hero mode reuses the existing slider items and renders only the first usable normalized item. A usable item contains visible text, usable image or video media, or one valid CTA. Empty or invalid rows are skipped before the first usable item is selected.

Static Hero output intentionally does not render Splide markup, carousel controls, pagination or the `[data-vtxm-slider]` initialization hook. It emits `data-vtxm-slider-render-mode="static"` and stable Static Hero classes instead. The selected image, text and CTA are visible without JavaScript. Decorative videos keep the existing video hooks for optional source switching and reduced-motion handling, but the desktop video source remains present as the no-JavaScript fallback.

Available transitions:

- `slide`
- `fade`

Optional instance-wide effects:

- image effect: `none` or `slow-zoom`
- text animation: `none` or `fade-up`
- overlay: `none`, `dark` or `light`

Display modes:

- `standard`
- `hero`

Width hooks:

- `contained`
- `fullwidth`

Hero height hooks:

- `auto`
- `compact`
- `medium`
- `large`
- `viewport`
- `custom`

Custom height is normalized as a pixel value and emitted through a data attribute only. The template does not output inline height styles.

Slide media types:

- image slides
- muted decorative background-video slides

Video slides can define separate desktop and mobile video files plus an optional poster image. Rendered videos are decorative, muted, autoplaying, looping and inline. Video controls are intentionally not rendered. The desktop video is rendered as a fallback `<source>` so the slide can play before any optional frontend source switching runs.

Pattern overlays:

- `none`
- `dots-fine`
- `dots-coarse`
- `lines-diagonal`
- `lines-horizontal`

Color overlays and pattern overlays are separate decorative layers. Styling for dark/light overlays, dotted patterns and striped patterns belongs in `frontend-assets` or project CSS.

Scroll fade modes:

- `none`
- `fade`
- `fade-background`

The fade distance is normalized as pixels and emitted through a data attribute. `fade-background` exposes hooks so frontend-assets may fade the Hero into the theme or project background. Background colors belong in `frontend-assets` or project CSS, not in this bundle.

Static Hero alignment hooks:

- content alignment: `left`, `center`, `right`
- content position: `top`, `center`, `bottom`
- media position: `left-top`, `center-top`, `right-top`, `left-center`, `center-center`, `right-center`, `left-bottom`, `center-bottom`, `right-bottom`

Static Hero mode reuses the existing overlay, pattern, width, height, custom-height and scroll-fade hooks. It supports the same image media and decorative background-video media as slider items. Version 1 renders one existing CTA only. Multiple CTAs, foreground video controls, transcripts, arbitrary focal coordinates, responsive art direction, overlay intensity fields, new reveal systems, project-specific visual themes and migrations from another element are intentionally deferred.

Effects apply to the complete slider instance, not to individual slides. The visual implementation for transitions, image effects, text animation, overlays, patterns, Hero heights, full-width presentation, scroll fading, video source handling and reduced-motion behavior belongs in `frontend-assets` or project assets. This bundle only outputs stable classes, data attributes, image/video markup, Splide-compatible slider HTML and no-Splide Static Hero HTML.

Selecting `perPage = 3` keeps using Splide `perPage` and can display three cards or teaser-style items simultaneously. No separate three-box implementation is included.

The consuming project must load Splide before `frontend-assets` initializes the slider. Fade transition mode uses Splide `type: "fade"`; when loop is enabled in the backend, the generated Splide options use `rewind: true` instead of `type: "loop"`.

Existing image-only sliders remain compatible. Missing media type values default to image. The Static Hero item headline uses the configured Contao headline unit. Explicit image alt text is preserved, and an empty alt text remains valid for decorative images. Decorative videos are rendered muted, inline, looping and hidden from assistive technologies. Links render only when both a safe URL and a visible label are available; new-window links use `rel="noopener noreferrer"`.

Reduced-motion handling belongs in `frontend-assets`. It should respect `prefers-reduced-motion`, avoid scroll-motion effects, avoid slow image zoom and text movement, and pause or avoid autoplaying decorative video where practical while retaining poster or static media visibility.


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


## Team Grid

`vtxm_team_grid` renders repeatable team, staff or profile entries in server-rendered markup. It is the reusable profile grid element for new team sections.

Use `vtxm_team_grid` when editors need an arbitrary number of people with structured profile data. Use the legacy `vtxm_members_grid` only when the existing fixed four-position top/left/right/bottom member layout is required. Existing `vtxm_members_grid` records are not migrated and its rendering remains unchanged.

Available styles:

- `cards`
- `minimal`
- `list`

Layouts:

- `grid`
- `list`

Column options:

- `2`
- `3`
- `4`

Gap options:

- `small`
- `medium`
- `large`

Image ratio hooks:

- `portrait`
- `square`
- `landscape`
- `natural`

Alignment hooks:

- `left`
- `center`

Reveal hooks:

- `none`
- `fade-up`

Person fields:

- image
- explicit image alt text
- name
- role
- biography
- email
- phone
- website
- LinkedIn URL
- Instagram URL
- Mastodon URL
- Bluesky URL
- GitHub URL
- primary CTA URL, label and new-window target
- two generic social/profile links with explicit labels and URLs

Rows are edited through MultiColumnWizard and keep their backend order in the frontend. Completely empty rows are skipped. A row is usable when it has a name, or at least one of role, biography, valid media, contact/social link or primary CTA.

Images are selected through the Contao file picker and resolved from stored UUIDs. Invalid UUIDs, folders, missing files and files outside the configured image types do not render an image. Missing images render no media element and expose no-media hooks instead of a fake placeholder image.

Explicit image alt text is preserved. Empty alt text remains empty and marks the image as decorative. The element does not derive alt text from the person name.

The biography is rendered as escaped plain text with line breaks preserved. Contact links render only when valid: email becomes `mailto:`, phone becomes `tel:`, and website/social links accept safe web URLs. First-class social links use stable labels; generic links render only when both explicit label and safe URL are present. The primary CTA renders only when both a safe URL and visible label are present, and new-window CTAs use `rel="noopener noreferrer"`.

The optional `fade-up` reveal setting emits the existing generic reveal-group hooks used by `frontend-assets`: `.vtxm-reveal-group`, `.vtxm-reveal-item`, `data-vtxm-reveal-type`, `data-vtxm-reveal-target` and `data-vtxm-reveal-stagger`. Content remains visible without JavaScript.

The output uses list semantics, one article per person, a heading for each name, visible link text, accessible labels for contact/social/CTA links, decorative empty `alt` attributes when configured, keyboard-accessible native links and no modal or disclosure behavior.

Styling, profile card presentation, icon visuals, reveal animation details and reduced-motion handling belong in `frontend-assets` or project CSS/JavaScript. This bundle only outputs stable markup, classes and data hooks.

Deferred features for this element include frontend CSS, JavaScript, icon libraries, SVG icon bundles, modal profiles, detail pages, person database entities, categories, departments, filtering, sorting UI, arbitrary focal points, responsive art direction, automatic image placeholders, project-specific colors and migrations from `vtxm_members_grid`.


## Process Steps / Timeline

`vtxm_process_steps` renders ordered process steps, phases, milestones, how-it-works entries or timeline entries in stable server-rendered markup.

Supported variants:

- `process`
- `timeline`

Orientation hooks:

- `vertical`
- `horizontal`

Marker styles:

- `number`
- `icon`
- `dot`

Alignment hooks:

- `left`
- `center`
- `right`
- `alternate`

Reveal hooks:

- `none`
- `fade-up`

Backend fields:

- optional Contao headline
- optional intro text
- variant
- orientation
- marker style
- alignment
- reveal hook
- repeatable entries
- custom CSS ID and class through Contao `cssID`

Item fields:

- marker
- date / eyebrow
- title
- text
- icon
- image
- alt text
- link URL
- link label
- new-window target
- optional CSS class

The entries are edited through MultiColumnWizard rows and keep their backend order in the frontend. Empty rows and rows without meaningful visible content are skipped. Number markers fall back to the 1-based entry number. Links are rendered only when both a safe URL and a visible label are present. Image UUIDs are resolved through Contao's file model and only valid existing image files are rendered. Explicit alt text is used first; when empty, file metadata alt text is used when available. Decorative images may render with an empty `alt` attribute.

The output uses ordered-list semantics and remains fully usable without JavaScript. The optional reveal setting only emits classes and data attributes. Styling, horizontal layout behavior, marker visuals, reveal animation runtime and reduced-motion handling belong in `frontend-assets` or project CSS/JavaScript.


## Notes

No styling or JavaScript behavior is included by design.

Use your project CSS and JavaScript to define:

- spacing
- grid behavior
- colors
- animations
- process step and timeline styling
- tab switching
- accordion behavior
- slider initialization

All elements preserve Contao `cssID` support through the shared `AbstractWrappedContentElement`.

The `iconboxIcon` value is escaped in the template. Use it for icon class names, labels or short markers. SVG or HTML icon markup is intentionally not rendered raw in this version.

The `vtxm_slider` element outputs Splide-compatible markup and data attributes in `slider` render mode, or no-Splide Static Hero markup in `static` render mode. Styling and JavaScript are expected through `frontend-assets`, especially `css/vtxm-components.css`, `js/vtxm-components.js`, and vendor Splide assets or a local Splide build loaded by the consuming project.


## HTML Hooks

Root classes:

- `.ce_vtxm_iconbox`
- `.ce_vtxm_media_text`
- `.ce_vtxm_link_list`
- `.ce_vtxm_slider`
- `.ce_vtxm_teaser_grid`
- `.ce_vtxm_team_grid`
- `.ce_vtxm_members_grid`
- `.ce_vtxm_live_teaser`
- `.ce_vtxm_quote_teaser`
- `.ce_vtxm_announcement`
- `.ce_vtxm_tabs`
- `.ce_vtxm_accordion`
- `.ce_vtxm_timeline`
- `.ce_vtxm_process_steps`
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

- `.media-text`
- `.media-text__inner`
- `.media-text__media`
- `.media-text__link`
- `.media-text__image`
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
- `[data-vtxm-media-text]`

Media Text styling is expected through `frontend-assets`, especially `css/vtxm-components.css`.

Quote Teaser hooks:

- `.ce_vtxm_quote_teaser`
- `.quote-teaser`
- `.quote-teaser__headline`
- `.quote-teaser__quote`
- `.quote-teaser__text`
- `.quote-teaser__attribution`
- `.quote-teaser__author`
- `.quote-teaser__source`
- `.quote-teaser__action`
- `.quote-teaser__link`
- `[data-vtxm-quote-teaser]`

Quote Teaser styling is expected through `frontend-assets` or project CSS. Multiple-card layout is handled by `content-grid`, not by Quote Teaser.

Link List hooks:

- `.ce_vtxm_link_list`
- `.link-list__headline`
- `.link-list__items`
- `.link-list__item`
- `.link-list__item--has-icon`
- `.link-list__item--no-icon`
- `.link-list__link`
- `.link-list__link--has-icon`
- `.link-list__link--no-icon`
- `.link-list__icon`
- `.link-list__label`
- `.link-list__label-fallback`
- `.link-list__description`
- `.link-list--default`
- `.link-list--buttons`
- `.link-list--icons`
- `.link-list--icons-only`
- `.link-list--minimal`
- `.link-list--edge`
- `.link-list--edge-left`
- `.link-list--edge-right`
- `.link-list--expand-labels`
- `.link-list--align-left`
- `.link-list--align-center`
- `.link-list--align-right`
- `[data-vtxm-link-list]`
- `[data-vtxm-link-list-style]`
- `[data-vtxm-link-list-align]`
- `[data-vtxm-link-list-edge]`
- `[data-vtxm-link-list-item]`
- `[data-vtxm-link-list-item-index]`
- `[data-vtxm-link-list-icon]`

Link List styling is expected through `frontend-assets`, especially `css/vtxm-components.css`. Edge positioning and label expansion are not implemented in this bundle.

Slider hooks:

- `.ce_vtxm_slider`
- `.vtxm-slider`
- `.vtxm-slider__slide`
- `.vtxm-slider__item`
- `.vtxm-slider__media`
- `.vtxm-slider__media--image`
- `.vtxm-slider__media--video`
- `.vtxm-slider__image`
- `.vtxm-slider__video`
- `.vtxm-slider__overlay`
- `.vtxm-slider__pattern`
- `.vtxm-slider__content`
- `.vtxm-slider__eyebrow`
- `.vtxm-slider__headline`
- `.vtxm-slider__text`
- `.vtxm-slider__action`
- `.vtxm-slider--render-static`
- `.vtxm-slider--content-align-left`
- `.vtxm-slider--content-align-center`
- `.vtxm-slider--content-align-right`
- `.vtxm-slider--content-position-top`
- `.vtxm-slider--content-position-center`
- `.vtxm-slider--content-position-bottom`
- `.vtxm-slider--media-position-left-top`
- `.vtxm-slider--media-position-center-top`
- `.vtxm-slider--media-position-right-top`
- `.vtxm-slider--media-position-left-center`
- `.vtxm-slider--media-position-center-center`
- `.vtxm-slider--media-position-right-center`
- `.vtxm-slider--media-position-left-bottom`
- `.vtxm-slider--media-position-center-bottom`
- `.vtxm-slider--media-position-right-bottom`
- `.vtxm-static-hero`
- `.vtxm-static-hero__media`
- `.vtxm-static-hero__media--image`
- `.vtxm-static-hero__media--video`
- `.vtxm-static-hero__image`
- `.vtxm-static-hero__video`
- `.vtxm-static-hero__overlay`
- `.vtxm-static-hero__pattern`
- `.vtxm-static-hero__content`
- `.vtxm-static-hero__eyebrow`
- `.vtxm-static-hero__headline`
- `.vtxm-static-hero__text`
- `.vtxm-static-hero__action`
- `.vtxm-static-hero__link`
- `.slider--hero`
- `.slider--images`
- `.slider--cards`
- `.slider--quotes`
- `.slider--gap-none`
- `.slider--gap-small`
- `.slider--gap-medium`
- `.slider--gap-large`
- `.slider--transition-slide`
- `.slider--transition-fade`
- `.slider--image-none`
- `.slider--image-slow-zoom`
- `.slider--text-none`
- `.slider--text-fade-up`
- `.slider--overlay-none`
- `.slider--overlay-dark`
- `.slider--overlay-light`
- `.slider--mode-standard`
- `.slider--mode-hero`
- `.slider--width-contained`
- `.slider--width-fullwidth`
- `.slider--height-auto`
- `.slider--height-compact`
- `.slider--height-medium`
- `.slider--height-large`
- `.slider--height-viewport`
- `.slider--height-custom`
- `.slider--pattern-none`
- `.slider--pattern-dots-fine`
- `.slider--pattern-dots-coarse`
- `.slider--pattern-lines-diagonal`
- `.slider--pattern-lines-horizontal`
- `.slider--scroll-none`
- `.slider--scroll-fade`
- `.slider--scroll-fade-background`
- `[data-vtxm-slider]`
- `[data-vtxm-slider-render-mode]`
- `[data-vtxm-slider-mode]`
- `[data-vtxm-slider-width]`
- `[data-vtxm-slider-height]`
- `[data-vtxm-slider-custom-height]`
- `[data-vtxm-slider-pattern]`
- `[data-vtxm-slider-scroll-effect]`
- `[data-vtxm-slider-scroll-distance]`
- `[data-vtxm-video]`
- `[data-vtxm-video-desktop]`
- `[data-vtxm-video-mobile]`

`[data-vtxm-slider]` is emitted only by the `slider` render mode. Static Hero mode emits `data-vtxm-slider-render-mode="static"` and remains usable without JavaScript. Slider styling, Static Hero styling and optional JavaScript enhancements are expected through `frontend-assets`, especially `css/vtxm-components.css`, `js/vtxm-components.js`, and vendor Splide assets or a local Splide build.

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

Team Grid hooks:

- `.ce_vtxm_team_grid`
- `.team-grid`
- `.team-grid__header`
- `.team-grid__headline`
- `.team-grid__list`
- `.team-grid__item`
- `.team-grid__card`
- `.team-grid__media`
- `.team-grid__image`
- `.team-grid__media-placeholder`
- `.team-grid__content`
- `.team-grid__name`
- `.team-grid__role`
- `.team-grid__biography`
- `.team-grid__contacts`
- `.team-grid__contact`
- `.team-grid__socials`
- `.team-grid__social`
- `.team-grid__social-label`
- `.team-grid__action`
- `.team-grid__link`
- `.team-grid--style-cards`
- `.team-grid--style-minimal`
- `.team-grid--style-list`
- `.team-grid--layout-grid`
- `.team-grid--layout-list`
- `.team-grid--columns-2`
- `.team-grid--columns-3`
- `.team-grid--columns-4`
- `.team-grid--gap-small`
- `.team-grid--gap-medium`
- `.team-grid--gap-large`
- `.team-grid--ratio-portrait`
- `.team-grid--ratio-square`
- `.team-grid--ratio-landscape`
- `.team-grid--ratio-natural`
- `.team-grid--align-left`
- `.team-grid--align-center`
- `.team-grid--has-media`
- `.team-grid--no-media`
- `.team-grid--reveal-none`
- `.team-grid--reveal-fade-up`
- `[data-vtxm-team-grid]`
- `[data-vtxm-team-grid-item]`
- `[data-vtxm-team-grid-style]`
- `[data-vtxm-team-grid-layout]`
- `[data-vtxm-team-grid-columns]`
- `[data-vtxm-team-grid-gap]`
- `[data-vtxm-team-grid-ratio]`
- `[data-vtxm-team-grid-align]`
- `[data-vtxm-reveal-type]`
- `[data-vtxm-reveal-target]`
- `[data-vtxm-reveal-stagger]`
- `.vtxm-reveal-group`
- `.vtxm-reveal-item`

Team Grid styling and optional reveal behavior are expected through `frontend-assets`, especially `css/vtxm-components.css` and `js/vtxm-components.js`, or project assets.

Process Steps hooks:

- `.ce_vtxm_process_steps`
- `.process-steps`
- `.process-steps__header`
- `.process-steps__intro`
- `.process-steps__items`
- `.process-steps__item`
- `.process-steps__marker`
- `.process-steps__content`
- `.process-steps__eyebrow`
- `.process-steps__title`
- `.process-steps__text`
- `.process-steps__media`
- `.process-steps__link`
- `.process-steps--process`
- `.process-steps--timeline`
- `.process-steps--vertical`
- `.process-steps--horizontal`
- `.process-steps--marker-number`
- `.process-steps--marker-icon`
- `.process-steps--marker-dot`
- `.process-steps--align-left`
- `.process-steps--align-center`
- `.process-steps--align-right`
- `.process-steps--align-alternate`
- `.process-steps--reveal-none`
- `.process-steps--reveal-fade-up`
- `[data-vtxm-process-steps]`
- `[data-vtxm-process-steps-variant]`
- `[data-vtxm-process-steps-orientation]`
- `[data-vtxm-process-steps-marker]`
- `[data-vtxm-process-steps-reveal]`
- `[data-vtxm-process-step]`
- `[data-vtxm-process-step-index]`

Process Steps styling and optional reveal behavior are expected through `frontend-assets`, especially `css/vtxm-components.css` and `js/vtxm-components.js`, or project assets.

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
- `ce_vtxm_team_grid.html5`
- `ce_vtxm_members_grid.html5`
- `ce_vtxm_live_teaser.html5`
- `ce_vtxm_quote_teaser.html5`
- `ce_vtxm_announcement.html5`
- `ce_vtxm_tabs.html5`
- `ce_vtxm_accordion.html5`
- `ce_vtxm_timeline.html5`
- `ce_vtxm_process_steps.html5`
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
