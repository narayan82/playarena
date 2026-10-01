# Custom CSS and JS migration

Inspected the local WordPress database and the Simple Custom CSS and JS plugin's runtime tree on 24 September 2026. The admin URL's HTTPS certificate was rejected by the browser, so inspection used the local database and plugin files. No database records were changed.

## Entry inventory

| ID | Title | Database status | Theme destination |
| --- | --- | --- | --- |
| 577 | Mobile CSS | Trash | `scss/_custom-overrides.scss` (previous migration) |
| 871 | Desktop CSS | Trash | `scss/_custom-overrides.scss` (previous migration) |
| 1416 | Custom Select | Published | `scss/_plugin-customizations.scss` |
| 1434 | Untitled: special button and short viewport hero | Published | `scss/_plugin-customizations.scss` |
| 1700 | About Us Page | Published | `scss/_plugin-customizations.scss` |
| 1870 | Terms | Published | `scss/_plugin-customizations.scss` |
| 1899 | sleepover | Published | `scss/_plugin-customizations.scss` |
| 2272 | Meta Purchase Event | Published | Consolidated in `js/index.js` and `inc/custom-code.php` |
| 2273 | Meta Purchase Trigger | Published | Consolidated in `js/index.js` and `inc/custom-code.php` |
| 2274 | Untitled | Published, blank | No code to migrate |
| 2275 | Meta Purchase Trigger | Published, blank | No code to migrate |
| 2278 | Untitled: HTML-wrapped purchase script | Published | Consolidated in `js/index.js` and `inc/custom-code.php` |

## Styles

The five active CSS bodies are preserved, in the plugin's runtime order: 1899, 1870, 1700, 1434, 1416. `screen.scss` loads the base, previously migrated overrides, then these customizations. Separate Sass modules prevent legacy `@extend` rules from expanding the migrated selectors. The generated `css/screen.min.css` and adjacent source map are updated; Live Sass recompiles them on future SCSS edits. Global CSS is still inlined by the existing `hook_css()` function.

## Purchase tracking

The user approved consolidating the three overlapping scripts. The old scripts fired a fixed INR 490 purchase globally or on URL matches, or inferred an amount from the first price in the DOM (defaulting to 1). These behaviors and the hardcoded product ID are removed.

The theme now supplies data only on WooCommerce order-received pages with a matching order key and a paid order. It uses the actual order total and currency. Preparation runs before footer scripts, after confirmation-page rendering. It defers when native Meta browser/server tracking has already marked the order, or when PixelYourSite's configured Facebook purchase tracking owns the event. It does not change either plugin's configuration or deduplicate those plugins against each other.

The independent JS callback waits for DOM readiness and up to roughly 10 seconds for the existing `fbq`; it does not initialize a pixel. A stable hashed event ID, per-page guard and localStorage marker reduce duplicate events on repeat loads. Storage restrictions prevent cross-refresh deduplication, but the page guard and stable event ID remain. No order key or customer data is sent in the payload. An absent/blocked pixel produces no event. Payment confirmation arriving only after the visitor leaves the page requires the existing server integration; this is a browser fallback, not a new server tracker.

## Plugin coexistence and removal

`functions.php` loads `inc/custom-code.php`. Its `after_setup_theme` callback removes only the listed IDs from the plugin's in-memory frontend output tree. This prevents the original inline snippets from running alongside the theme. Other IDs and admin/login scopes remain untouched. Published originals still appear enabled in wp-admin because their database state is retained for rollback; edits to these migrated entries no longer affect frontend output. Edit the theme sources instead.

All currently active entries are covered, so the Custom CSS and JS plugin can be deactivated after local visual/checkout review. Keep any separate pixel-provider plugin needed to supply `fbq`. This migration does not require deleting the original records. The suppression uses the installed plugin's public runtime tree; review it if that plugin's internals or snippet linking modes change.

Rollback must restore the previous theme CSS/JS **and** remove the `inc/custom-code.php` include together, then restore the two trashed CSS entries if needed. Removing suppression alone would allow duplicate purchase scripts to execute. Keep a copy of the current theme before rollback so unrelated theme edits are preserved.

## Verification

- Sass compilation and Autoprefixer succeeded. Compiled modules concatenate exactly in the intended order, with no selector expansion across modules.
- PHP syntax checks passed for `functions.php` and `inc/custom-code.php`; `node --check js/index.js` passed.
- `node tests/custom-code-js.cjs` checks ordinary pages, invalid values, actual totals, refresh and initialization deduplication, delayed/unavailable pixel, DOM readiness and denied storage.
- `php -n tests/custom-code-php.php` checks scoped suppression, invalid/missing orders, invalid keys, unpaid orders, native tracker deferral, payload and script placement using stubs.
- No live purchase or analytics event was sent. Browser visual and end-to-end checkout verification remain unperformed because the local HTTPS certificate is untrusted.
