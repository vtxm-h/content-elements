# content-elements

Contao 4.13 bundle with reusable content elements:

- accordion
- tabs
- members grid
- live teaser
- timeline
- quote teaser
- announcement
- feature grid
- feature item

## Content elements

Category:
- vtxm

Types:
- vtxm_accordion
- vtxm_tabs
- vtxm_members_grid
- vtxm_live_teaser
- vtxm_timeline
- vtxm_quote_teaser
- vtxm_announcement
- vtxm_feature_grid
- vtxm_feature_item

## Notes

This bundle provides reusable content elements only.

Structure-oriented bundles such as:
- article-insert
- layout-preset

remain separate.

The feature grid is built as:
- parent CE: `vtxm_feature_grid`
- child CE: `vtxm_feature_item`
