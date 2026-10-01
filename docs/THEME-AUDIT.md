# PlayArena theme audit

Audit date: 24 September 2026. This is a discovery baseline, not an implementation proposal.

## Scope and evidence

Inspected the current custom theme, including all PHP templates, block metadata, authored JavaScript, SCSS, compiled asset references, fonts, images, build configuration and lockfile. Identified bundled vendor code without treating it as application source. Inspected the local plugin inventory and selected configuration/content records in the existing `app/sql/*.20260922202609.sql` export, without loading WordPress or writing to the database. Database statements below describe that export, **not verified current runtime state**. The snapshot names `playarena.in` as both template and stylesheet.

There were substantial pre-existing tracked changes and untracked theme additions, including a deleted `archive-activity.php`. Those were left intact. Only the four requested documentation files were added. No installs, builds, refactors, theme switches, database imports or form submissions were performed. No production credentials, tokens, contact details or submission records are reproduced here.

Static validation: all 43 theme PHP files passed PHP syntax lint using Local's PHP 8.2 binary; all 29 JavaScript files (including Gulp and vendors) passed `node --check`. All 24 block JSON files parsed successfully. These checks do not establish runtime, visual, integration or accessibility correctness. Local browser behavior, active database differences, external booking completion and production configuration remain unverified. The live reference site was not used as evidence.

## Architecture

**PlayArena 1.0**, authored by Matsio, is a classic PHP theme that uses Gutenberg content and ACF Pro blocks. It is not a full-site-editing theme: no `theme.json`, HTML template system, React application, Elementor dependency or theme-owned page builder was found.

Most page layout lives in database `post_content`, combining core blocks with PHP-rendered ACF blocks. Activity details and location taxonomy pages are unusually large hand-written PHP compositions. The theme is therefore only one part of the working site: ACF definitions, CPT registrations, menu configuration, forms, custom CSS/JS and content also need preservation.

```text
style.css                       Theme identity only
functions.php                   Constants, includes, assets, menus, options, walker, filters
inc/matsio.php                  Theme support, login/admin branding, dashboard/widget cleanup
inc/block-management.php        Directory-driven block/script registration
header.php / footer.php         Global shell, navigation, tracking, front-page subscription
front-page.php / index.php      Header → the_content() → footer
archive-*.php                   Academies, events, restaurants
single-*.php                    Activity, academies, event, restaurant
taxonomy-location.php          Location + activity tabs + promotions
template-create-event.php       Named Create Event template, forms and relationship content
template-events.php             Named Page Events template, content passthrough
404.php                         Effectively empty (1 byte)
parts/favicon.php               Disabled include; referenced favicon directory absent
blocks/<name>/                  block.json, PHP, js/, scss/, css/ (24 blocks)
scss/                          Global source, component and page partials
css/                           Generated globals and nested source maps
js/index.js                    Directly served application source
js/vendor/                     Slick, GLightbox, jQuery UI datepicker minified distributions
fonts/                         Local Sora and Helvetica Neue; specimens/config artifacts
img/                           48 SVGs, 9 WebPs, 5 PNGs
src/screenshot.psd              Design artifact, not JS source
gulpfile.js / package*.json     Legacy Gulp Sass pipeline and installed dependencies
```

`functions.php` defines a timestamp `DEP_VERSION`, login colors and client name. It requires both `inc` files. There is one custom class, `AWP_Menu_Walker`; `checkArray()` is a small helper with no other theme call found. No application service layer or additional PHP class hierarchy is present.

## WordPress content model

Six site CPTs are configured in the snapshot's `wp_options.cptui_post_types`. Registration is performed by **Custom Post Type UI**, through `cptui_create_custom_post_types()` / `register_post_type()` in `wp-content/plugins/custom-post-type-ui/custom-post-type-ui.php`. Taxonomies use its `cptui_taxonomies` option and corresponding taxonomy registration functions. None is registered directly in this theme.

| CPT slug | Taxonomy | Rendering and data |
| --- | --- | --- |
| `activity` | `location` | `single-activity.php`; location page and hero queries. ACF Activity group supplies price, duration, age, players, icon, image repeater, host-event links and booking URL. The deleted archive now falls back to `index.php`. |
| `event` | None configured in CPT UI | `archive-event.php`, `single-event.php`; `events` and `coming-events` blocks; related-event sections. Event fields include activities, spaces, entertainment, cuisine, date, description, icon and color. |
| `restaurant` | `cusine` (existing spelling) | `archive-restaurant.php`, `single-restaurant.php`; core content plus reusable food/feature/hero blocks. No dedicated restaurant field group in snapshot. |
| `academies` | `sports` | `archive-academies.php`, `single-academies.php`, `academies-tab`; age group, card title/description/thumbnail/link fields; content blocks power detail pages. |
| `entertainment` | None configured | Event post-object selection and Create Event template; no dedicated single/archive template or field group. Individual requests fall back to `index.php`; archive disabled. |
| `specials` | None configured | `offers-slider` and related offers in activity detail; title, sub_text, description, dates, thumbnail and activity references. No dedicated single template; archive disabled. |

All six CPT definitions enable REST exposure; that is WordPress's standard API, not a theme-defined REST endpoint. Activity/event/restaurant/academies enable archives. Supports include title/editor/thumbnail; most also excerpt, entertainment also custom fields. Exact associations and field trees are in [THEME-MAP.md](THEME-MAP.md).

The snapshot contains 30 published activities, 4 academies, 1 restaurant, 7 entertainment posts and 9 specials. There are **no published events**, with one event in trash. Thus the coming-events block's outer query would hide it with this dataset. The event group also references `public-event`, which is not configured in CPT UI; `event-type` term records also exist without a matching current CPT UI taxonomy registration. These are legacy-data leads, not verified active models.

### Other WordPress features

- Five menus: `header-menu`, `footer-menu`, `footer-menu-1`, `footer-menu-2`, `mobile-menu-icons`. Max Mega Menu supplies markup heavily targeted by the theme.
- ACF options page `common-settings` (“Common Settings”), capability `edit_posts`, added conditionally when ACF is available. Its fields are subsequently used without ACF availability guards.
- Theme support: featured images, feed links, document title. No custom image sizes enabled. An `after_switch_theme` hook sets thumbnail, medium and large dimensions to zero; changing themes can therefore change sitewide media settings.
- Blocks registered from every directory under `blocks/`. Custom JS is registered under `<block-name>.js`; block JSON selects scripts/styles/render templates. `should_load_separate_core_block_assets` is enabled.
- No custom shortcode registrations, `wp_ajax_*` handlers, custom REST routes, frontend widget areas, search template, pagination helper or authentication flow found. Gravity Forms and WooCommerce supply shortcodes and their own endpoints.
- `js/index.js` retains an HTML-fragment load-more request using `$.get()` against a link URL. Its activity archive markup is absent from the current theme; no corresponding theme AJAX endpoint exists.
- Login work is branding only. The snapshot's `/my-account/` uses WooCommerce's shortcode; no theme profile system exists.
- The snapshot contains a `wp_navigation` record but no `wp_block` reusable-block posts. This does not rule out differences in the running database.

## ACF architecture and mismatches

There is no `acf-json` directory or PHP local field registration in this theme. The snapshot has **24 published field groups and 204 field records**, including nested repeaters and editor-only accordions. The typed field tree and every literal frontend field call are documented in THEME-MAP.

Relationships are actually **post-object fields**, with multiple selection for event activities/entertainment and specials activities. Individual selected events and academies return objects. No fields of ACF `relationship`, `flexible_content` or `gallery` type were found; a field named `gallery` is a repeater. Most images return attachment IDs, while location image and hero video poster return URLs. Preserve these distinctions.

Confirmed code/schema discrepancies:

- Specials defines `sub_text`, but offers code reads `subtitle`; `url` is read on specials but has no corresponding specials field definition in the snapshot. It exists as a subfield in a different offers repeater. Do not assume these are interchangeable.
- `tab_icon` is read on activities but not defined in their snapshot group. Activity detail reads term `image`, whereas the location group defines `location_image`; the former value is fetched but not used.
- The academies block no longer consumes its defined `academy → academy_list → academy` repeater: it queries all academies and groups by `age_group`. The archive still embeds old serialized repeater data and fixed IDs.
- `academy_logo_image` is defined but hero carousel uses the post featured image instead. Academy `link` is defined but cards normally link to the academy permalink.
- Coach `description` is fetched without a matching field definition and is not rendered. Pre-packed `price` is fetched but not rendered.
- Activity `stories.video` differs from `story_video` read by Create Event; Create Event also reads `select_an_age_group` without a matching field definition. Assignment of that named template is not established by the snapshot's published page template metadata.
- Offers Slider group 45 combines block and options-page conditions within the same AND rule. Common Settings defines another `offers_at_play` repeater. Confirm intended editor placement before changing either.
- Common Settings includes nested field records parented to a text field (`sub_title`), an unusual schema shape. Record it before cleanup; do not assume it is a valid repeater layer.
- Three published field records (201–203: title, description, image) reference missing parent 199. The map lists them separately; no group or frontend scope can be verified for these orphan records.

## Frontend composition

The fixed global header combines the logo, custom menu walker and Mega Menu styling. Mobile uses a hamburger plus a separate icon menu. The expanded subscription/address/social/footer-column section renders only on the front page; copyright and terms menu render globally.

Hero options include location-driven timed panels, a configurable image/video block and a Slick image carousel. Cards cover specials, events, academies, coaches, food, facilities and packages. Tabs use buttons on desktop and select/previous/next controls on mobile. `date-picker` chooses static weekday content from options; it does not check inventory or reserve a slot. Booking is primarily outbound links.

Forms use Gravity Forms: theme shortcode ID 2 for subscription and ID 1 in Create Event; published snapshot page content uses form 6 for sleepover enquiry, 5 for play dates and 4 for event enquiry. Form 4 contains `WrapperBegin`/`WrapperEnd` fields, establishing a functional dependency on the wrapper add-on. The `.about-event` click handler expands optional form content. No custom submission handler was found. Delivery, notifications, spam protection and marketing destinations were not exercised.

GLightbox is initialized for `.video-glightbox`; no separate theme-owned modal/accordion framework was found. ACF accordion fields organize the editor, not frontend accordions. CSS supplies marquee animations on home/sleepover content; custom JS supplies hero progress animation. Maps in the theme are links, not an embedded Maps SDK.

Reusable blocks are real reusable rendering units, but activity detail and taxonomy templates duplicate membership benefits, event cards, offers and much activity markup. Similar card structures recur across `events`, `featured-events`, `coming-events`, archives and related sections. Slider initialization and SVG pager markup are also repeated. Preserve data contracts while considering shared renderers later.

## Styling

SCSS is the source. `scss/screen.scss` imports 25 partials: shared variables/reset/header/common/footer, vendor styles and page sections. `above-the-fold.scss` is empty; its CSS contains only a map comment. Most blocks have their own SCSS/CSS; hero-slider styling lives globally. No Bootstrap, Tailwind or Foundation dependency was found.

`_variables.scss` defines Sora body typography, Helvetica Neue button typography, 1366px boxed width, 1160px content width, a 1024px desktop boundary, blue `#007bfe`, black/white/grey and pastel accent variables. `ptr()` currently returns its pixel argument unchanged. `mobile` means max-width 1023px and `desktop` min-width 1024px. Additional breakpoints include 768px, 498px and 414px; vendor styles add others. Spacing is mostly literal pixel values, not a central scale.

`_reset.scss` supplies `.wrap`, `.flex-row`, `.flex-row-wrap`, floats and group clearing. `.wrap` has 40px desktop / 20px mobile horizontal padding. `_common.scss` supplies heading/text classes, buttons, pagers and event cards. Styles use deeply nested component/page selectors, `.block-*` roots and editor-authored class names; there is no consistent BEM or utility-first scheme. `_common.scss` defines `h2` twice with different sizes, making order significant.

The 655,732-byte `css/screen.min.css` is injected in full into every page by `hook_css()`. About 555,474 characters are selector text; extensive `@extend .wrap` expansion is an evident contributor. It is not merely a large image embedded in CSS. `_taxonomy-location.scss` has 1,129 lines; `_single-activity.scss` 1,018; `_header.scss` 694 including commented alternatives. Source SCSS contains 77 literal `!important` occurrences including vendor rules and comments; this is not a count of active rendered declarations.

Inline styles include the global CSS, term/event colors, hidden tab panels and block flex layouts. Database custom CSS records add another cascade layer: IDs 577, 871, 1416, 1434, 1700, 1870 and 1899 contain mobile overrides, page-specific changes, visibility rules and form styling. A theme-only redesign must account for these.

Local font CSS defines Sora weights 300–700 using two WOFF2 resources and Helvetica Neue 500 in WOFF/WOFF2. The theme hardcodes `/wp-content/themes/playarena.in/fonts/...` imports. Google Fonts and IcoMoon references in `_variables.scss` are commented out. Most icons are local SVGs or inline SVG paths; location icons are raw markup in ACF. Font specimens and `src/screenshot.psd` are development artifacts. The disabled favicon include references missing files.

Asset concerns: `img/playarena.png` is about 4.06 MB, `academy-screen.png` 1.16 MB and theme `screenshot.png` 1.08 MB. These are potential optimization candidates, not proof of frontend transfer. Many template images request `full`. jQuery UI CSS references missing icon sprites; inline CSS also changes how relative URLs resolve. `hook_css()` blindly replaces `../`, including paths with several parent segments, so nested relative asset paths need testing.

## JavaScript and build

All authored JS is direct browser source: global `js/index.js` and per-block `js/*.js`. Most code is jQuery ready callbacks; hero and date logic also uses native Date/timers/DOM concepts. There are no authored ES module imports or a configured JS bundle task. Vendor scripts are already minified distributions; jQuery comes from WordPress. The bundled datepicker identifies itself as jQuery UI 1.13.2; exact Slick/GLightbox release versions were not established from their stripped headers.

Every vendor JS file is globally enqueued in the head, without explicit dependencies in its own registration. Global index depends on jQuery and those vendors, loads in the footer and receives a new timestamp version each request. Block scripts have empty dependencies at registration; some JSON arrays explicitly include Slick/jQuery handles, while other Slick-using blocks rely on global loading. Editor asset ordering needs validation.

Gulp compiles Sass with Dart Sass, compresses it, autoprefixes and writes source maps. **It does not compile, bundle, transpile or minify application JS**, despite imported Browserify/Babel/Uglify packages. It has no npm scripts, dedicated production task, active asset-copy task, Webpack/Vite config or separately configured PostCSS pipeline. BrowserSync points to `dev.matsio.com`, port 8000, HTTPS, with no local WordPress proxy/server configured. See [DEVELOPMENT.md](DEVELOPMENT.md) for exact commands and limitations.

## Plugins

The plugin directory inventory and snapshot active-plugin option agree on the following major dependencies; this is not a live activation check.

| Classification | Plugins | Reason |
| --- | --- | --- |
| Required by current theme/content | ACF Pro | Unguarded field calls, repeaters/options and ACF block rendering. |
| Required by content model | Custom Post Type UI | Registers all six site CPTs and three configured site taxonomies from DB options. |
| Required for current navigation | Max Mega Menu | Header/mobile selectors and structure depend on its generated markup. |
| Required for current forms | Gravity Forms; Wrap Form Fields in Gravity Forms | Existing forms/shortcodes, including wrapper fields in event enquiry. |
| Required for current appearance outside theme | Simple Custom CSS and JS (`custom-css-js`) | Database overrides and tracking snippets; removal changes behavior. |
| Required for existing commerce screens, not core theme rendering | WooCommerce | Snapshot shop, cart, checkout and account pages; no theme WooCommerce template overrides or explicit support call. Whether commerce is commercially active is unverified. |
| Optional/integrated | Yoast SEO | Explicit metabox positioning/dashboard integration; header also emits hardcoded SEO metadata. |
| Optional operational/editor dependencies | Autoptimize, Comet Cache, Wordfence, Safe SVG, Duplicate Post, Disable WP Notification, Post Type Switcher | Present and snapshot-active; no unguarded direct calls from theme. Preserve until their operational role is reviewed. |
| Optional but ordering-sensitive | Metronet Reorder Posts, Post Terms Order, Reorder Terms, Taxonomy Terms Order | Theme uses `menu_order` and term ordering; actual ordering hooks/configuration need runtime review. |
| Unknown exact integration requirements | Site Kit, PixelYourSite, Facebook for WooCommerce, WebAppick product feed, WPCode/Insert Headers and Footers, FireBox, WP Lightbox 2 | Snapshot-active; can inject tracking, feeds, snippets, popups or competing lightboxes outside theme. Inspect configuration before removing. |

No Salesforce plugin, dedicated booking plugin, theme payment gateway code or custom PlayArena plugin was identified in this inventory. This does not exclude an external system or integration injected through content/settings.

## External integrations

| Integration | Evidence and configuration location | Meaning / limit |
| --- | --- | --- |
| PlayArena booking site | Hardcoded `booking.playarena.in` in date-picker PHP; 27 activity `button_link` metadata values point there in snapshot | Outbound activity bookings. No inventory/payment/session API in theme. Preserve destination parameters privately. |
| Sleepover booking engine | Page 1801 content links to `www.secure-booking-engine.com` | External accommodation booking configured in editor content. No SDK integration verified. |
| Google Ads tag | `header.php`, remote gtag script and inline configuration | Hardcoded Ads destination; not proof of a GA4 or GTM container. Identifiers omitted. |
| Ahrefs Analytics | `header.php`, async remote analytics script | Hardcoded public client configuration; omitted here. |
| Google verification / SEO | `header.php` verification meta; Yoast plugin | Hardcoded verification and generic title/description/keywords; potential duplicate metadata. |
| Meta purchase tracking | Published custom-css-js records 2272, 2273, 2278; PixelYourSite/Facebook for WooCommerce in snapshot | Multiple purchase snippets, including fixed values and order-received checks. Potential duplicate/misvalued events; actual execution and deduplication unverified. |
| Google Maps, WhatsApp, telephone | Hardcoded footer links, menu data and content | Link-based contact/location actions; no theme Maps API key or SDK found. Contact values omitted. |
| Subscription/enquiry email | Gravity Forms and form configuration in DB | Theme embeds forms; backend notifications/delivery/provider destinations not verified. No Mailchimp or other specific marketing SDK established. |
| Production media | `header.php`, academy/event archive images and DB content | Live-domain assets remain dependencies of a local copy. |
| Developer environment | BrowserSync host; old `dev.matsio.com` links in enquiry content | Environment-specific residue, not a confirmed current API. |

No theme `fetch`, `wp_remote_*`, payment SDK, Salesforce call or custom API route was found. Vendor-internal network behavior and plugin SDKs are not equivalent to a theme integration. No private credentials were found by the theme-code marker scan; this is not a whole-site secret audit. WordPress/environment configuration and SQL exports remain sensitive and were not printed.

## Risks and technical debt

### Critical

- A SQL export is present directly in the local WordPress public root, as well as under `app/sql`. A database dump must not be shipped into a publicly served deployment. Its external accessibility and production presence were **not tested**. This is an exposure risk to investigate, not a claim of an observed leak. No file was moved or deleted.

### Important

- Preserve database-backed schema/content/configuration before redesign: the theme alone cannot reconstruct the site. ACF absence can cause fatal calls; missing CPT UI registration loses routing.
- `archive-activity.php` is deleted in the working tree; `index.php` only calls `the_content()` without an archive/results loop. Search and unhandled archives have the same fallback limitation; 404 is blank.
- Activity detail assumes at least one valid location term, chooses the last if several exist, and uses term/description/color variables even when there are none. WP_Error is not handled for term queries. Location and activity views need missing-data cases.
- `blocks/cusine/cusine.php` reads `$term->ID` rather than `term_id` and builds a post permalink for a term. Academy cards call `setup_postdata($academy)` without assigning global `$post`, then use global title/thumbnail/excerpt in fallbacks. Wrong output can result.
- Hero JS's hover-out callback references `windowWidth` declared inside the separate hover-in callback: a ReferenceError path. Event-space mobile selection calls a stray `alert()` and does not perform the desktop slider reinitialization. Location mobile arrows change selectedIndex without activating the selected activity section.
- Repeated blocks reuse global IDs/selectors, so independent instances may interfere. Offers/tab JS adds a new `beforeChange` handler every `setPosition` event, potentially accumulating listeners.
- Schema mismatches above can yield blank links/content. Event date formatting assumes a valid date. Archives query `get_posts()` without explicit page size/pagination and report a different main-query count. “Coming events” sorts by publication rather than event date and does not filter past events.
- Full global CSS is inlined, vendors load globally, fonts use CSS imports, many images use full size, and timestamp asset versions undermine persistent browser caching. Source-map/asset paths and large selector expansion deserve measurement before changes.
- Output escaping is inconsistent across field text, hrefs, styles, term SVG markup and menu walker output. Preserve intentional rich text while reviewing context-appropriate escaping; exploitability was not tested.
- Hamburger and custom pager divs lack native button keyboard semantics, some images lack alt text, focus outlines are removed in several places, autoplay/marquee motion lacks an authored reduced-motion branch, and tab semantics are incomplete. These are source findings, not a completed accessibility conformance audit.
- `pre-packed-fun.php` has an extra closing div; `single-activity.php` does not close its outer wrapper before the footer. `slider-type-1` closes a slider container only inside the rows condition. Browser recovery may hide structural errors. Native select options also attempt to include images.
- Database CSS can hide booking/offer/form sections; purchase tracking exists in multiple places. Treat visibility and analytics as functional requirements, not cosmetic cleanup.
- Gulp calls completion before its streams finish; watcher dependency coverage misses block JS and block recompilation after shared variable edits. Existing build reproducibility is unproven.

### Cleanup

- Empty `event` and `membership` blocks, sample block, blank above-the-fold source, commented navigation/story implementations and unused helper/imports are candidates for investigation.
- `event` block declares unregistered `event-desktop-css` / `event-mobile-css` handles despite a compiled file; offers version string is `1,0,1`. No published snapshot usage of the event scaffold was found.
- Duplicate event/offer/benefit PHP and large analogous SCSS sections increase maintenance work; generic headings, `#` CTAs, placeholder copy and hardcoded archive IDs need content decisions.
- `flex-wrap: no-wrap` in reset is invalid CSS. Old IE skip-link/login hooks and IE8-era browserslist targets coexist with untranspiled modern JS. Do not mistake CSS browser targets for JS compatibility.
- `.gitignore` excludes lockfiles; a lockfile is present locally but not necessarily reproducible from a clean checkout. Source maps occupy nested `css/css` and `css/blocks` paths; an extra sample CSS file sits under `scss/css`.

### Leave alone unless necessary

- Existing CPT slugs, the `cusine` spelling, field keys/return formats, menu locations, attachment IDs, serialized ACF block data and external booking links are migration contracts.
- Existing media formats, third-party plugin behavior, ordering settings and vendor files should remain until verified replacements exist. Unused-looking code does not prove unused production content.

## Preserve versus rebuild

Preserve the content models, term assignments, editor-authored core/ACF layouts, named block contracts, nested event-space/tab repeaters, centralized weekday/benefit/social options, academy age grouping, form IDs and wrappers, menu locations and booking destinations. Reuse the existing reusable card/hero blocks where their data contract works.

A visual redesign can begin in SCSS and block markup while retaining ACF field names, post IDs, slugs, form embeds and booking links. Header navigation can be reskinned around existing menu data, but Mega Menu is a real behavior dependency. Do not migrate its structure incidentally.

Good candidates for bounded rebuilding are shared card/benefit renderers, scoped tab/carousel controllers, a reliable CSS build workflow, search/archive/404 presentation and accessible controls. Restoring a clear event/offer field contract should precede any content migration. Replacing WordPress, ACF or external booking wholesale is not justified by this audit.

Next investigation and acceptance criteria: [REFACTOR-NOTES.md](REFACTOR-NOTES.md). Page/template/component and full field references: [THEME-MAP.md](THEME-MAP.md).
