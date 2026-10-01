# Initial refactor investigation notes

These are follow-up candidates from the 24 September 2026 read-only audit. No fixes were made. Preserve existing functionality and migration contracts; code style alone is not a reason to replace a working system.

## Critical: investigate before deployment

- **Public-root SQL export.** The local WordPress public directory contains a database dump. Determine whether the deployment excludes it and whether any corresponding production file exists. Do not publish it. Acceptance: backups are stored outside served content and deploy artifacts exclude them. No remote accessibility test or production assertion was made in this audit.

## Important: establish the working baseline

- **Reconcile current DB with export.** Audit evidence is from the existing SQL snapshot. Verify active theme/plugins, CPT UI options, 24 ACF groups, forms, menu assignments, custom CSS/JS, WPCode, FireBox and commerce settings against the running local site. Acceptance: a reproducible migration inventory without credentials or submissions in the repository.
- **Preserve pre-existing changes.** The working tree has many edits and new blocks. Decide which represent the intended baseline before branching, committing or generating assets. Do not restore the deleted archive automatically.
- **Document real journeys.** Browser-check Home → activity → external booking; corporate/birthday → event enquiry; academy age filter → detail; sleepover → hotel booking/enquiry; subscription; contact links; cart/checkout/account if still used. Record current intended outcomes before redesign.
- **Inventory database styling and tracking.** Custom CSS IDs 577/871 and later overrides contain significant layout/visibility rules; JS records 2272/2273/2278 contain purchase events. Decide authoritative ownership before moving these into theme source. Acceptance: no appearance changes or duplicate conversion events caused by migration.

## Important: bounded correctness work

| Area | Evidence | Investigation / acceptance |
| --- | --- | --- |
| Activity/location model | `single-activity.php` takes the last term and uses uninitialized values for missing terms | Decide whether one location is required; test zero/one/multiple terms and WP_Error safely. Keep slugs and booking links. |
| Activity archive/search/404 | Deleted `archive-activity.php`; content-only `index.php`; empty `404.php` | Agree on intended listing/search behavior and routes. Results must have correct counts, empty states and navigation. |
| ACF contract | Specials `sub_text` vs code `subtitle`; missing specials `url` and activity `tab_icon`; legacy academies repeater | Compare actual metadata and editor history. Do not rename field keys blindly. Establish each canonical field and migrate only where justified. |
| Legacy event schema | No published event posts in snapshot; `public-event` ACF location and `event-type` term records remain | Determine whether events now live as ordinary pages/featured cards. Keep dormant schema until intent and usage are confirmed. |
| Academy fallbacks | `setup_postdata($academy)` without assigning global `$post`, then global title/excerpt/thumbnail calls | Test cards with and without custom fields. Correct post identity must be used in every fallback. |
| Cuisine links | `$term->ID` and `get_permalink()` in cusine block | Decide taxonomy destination versus restaurant/menu URL. Keep `cusine` slug unless a redirect/migration is planned. |
| Hero interaction | Hover-out references `windowWidth` outside its scope | Desktop hover/leave and mobile timer behavior must work without console errors and with keyboard access. |
| Mobile tabs | `event-spaces.js` has `alert()`; taxonomy select lacks activation handling | Match desktop/mobile selected content and slider sizing; no disruptive dialogs. |
| Repeated blocks | Hardcoded select IDs, broad selectors and global tab state | Test two instances of the same block on one page before extracting shared controllers. |
| Slider listeners | `beforeChange` bound inside `setPosition` in offers/tab JS | Ensure one handler per instance across resizes and tab reveals. |
| Event archives | Independent get_posts/main-query counts; missing pagination; publication-date sorting | Define past/upcoming rules and count/pagination contract before changing queries. |
| Markup | Extra close in pre-packed-fun; unclosed activity wrapper; conditional slider closing tag; images inside options | Validate representative HTML with empty and populated data; protect surrounding page/footer layout. |
| Output safety | Raw ACF/menu values in hrefs/text/styles; SVG and WYSIWYG intentionally accepted | Apply context-aware escaping while preserving intended formatting/SVG. Establish editor trust boundaries; do not strip legitimate content indiscriminately. |

## Important: performance, accessibility and build reliability

- **CSS size first, architecture second.** `screen.min.css` is 655,732 bytes, largely selectors. Measure the contribution of `@extend .wrap`, duplicated component rules and global page styles. Preserve screenshots before changing Sass structure. Acceptance: equivalent layout with smaller measured output; avoid a token-system rewrite merely for neatness.
- **Build correctness.** Return streams/complete tasks correctly, include block JS watches, rebuild blocks when shared variables change, verify sourcemaps, configure the real Local proxy, pin/test a compatible Node/dependency environment and establish a deliberate lockfile policy. Acceptance: clean reproducible build and complete initial/watch outputs. The audit ran no build.
- **Caching and loading.** Review timestamp asset versions, globally loaded vendors and full inline CSS. Test dependencies in frontend/editor before making scripts conditional. Do not optimize away code needed by database-injected blocks or forms.
- **Media and fonts.** Identify whether large theme PNGs actually load; evaluate full-size attachment use, absent thumbnail generation, hero video loading and font imports. Preserve aspect ratios and media IDs. Repair referenced missing UI sprites only after confirming actual visual effects.
- **Accessible controls.** Native buttons/labels/focus states for hamburger/pagers/tabs, reduced-motion and pause behavior, useful image alt text, announced tab state and native disabled states. Acceptance: keyboard and mobile journeys still work. This needs browser/assistive-technology checks, not only source review.
- **Forms and commerce.** Preserve form IDs 1/2/4/5/6, event form wrapper fields, validation/confirmation behavior and delivery settings. Determine whether WooCommerce checkout/account pages are operational or historical before removing them. External activity/hotel booking is a separate integration.

## Cleanup candidates after usage checks

- Empty `event`/`membership`, development `sample-block`, empty above-the-fold CSS, disabled missing favicon assets and old story/navigation code.
- `event` CSS handles missing theme registration; `offers-slider` malformed version punctuation; undefined sample `$style`; stale `checkArray()` helper and unused build imports.
- Duplicated benefits/event/offer markup across PHP templates and blocks; repetitive SVG pager markup; analogous activity/location SCSS; duplicated card styles in events/featured-events.
- Hardcoded archive academy IDs/field keys, placeholder text and `#` links. Some were made obsolete by query-driven rendering; confirm before removing.
- Invalid `flex-wrap: no-wrap`, repeated heading overrides, raw pixel spacing, inconsistent `option`/`options` spelling, misspelled comments/classes and old IE assumptions. Both ACF option spellings are used intentionally by existing code; normalize only if useful.
- Source maps under nested directories, extra sample CSS, font specimens and PSD source. Absence from published snapshot usage is not sufficient evidence for deletion.

## Preserve by default

| Preserve | Why |
| --- | --- |
| Six CPT slugs; `location`, `sports`, `cusine`; permalinks and term relationships | Search traffic, saved links and editor content rely on them. |
| ACF field keys, names, repeater hierarchy and return formats | Existing metadata and saved block payloads rely on these contracts. |
| Core Gutenberg composition and ACF block names | Pages remain editable without a wholesale content migration. |
| `tab_details`, `event_space_details`, weekday offers and benefits options | Useful structured content models; styling can change independently. |
| Activity booking URLs, accommodation booking links, forms and menu destinations | Existing conversion journeys have higher migration risk than visual components. |
| Attachments, featured images, menu locations and ordering | Avoid silent content/relationship loss. |
| Plugin-owned tracking, popups, SEO and caching until mapped | Theme inspection alone cannot establish their full runtime behavior. |

## Suggested sequence

1. Confirm baseline, safely retain schema/configuration, and check public-root export handling.
2. Capture representative page/interaction behavior, including database CSS and external links.
3. Address verified correctness and build blockers in small, separately reviewable changes.
4. Redesign styles and markup while retaining data contracts and forms.
5. Extract shared rendering/interaction components where duplication has demonstrated maintenance cost.
6. Consider backend or plugin replacement only with documented user benefit, migration plan and rollback path.

No decision to rebuild the entire website or replace its backend follows from this audit.
