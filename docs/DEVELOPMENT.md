# Working on PlayArena locally

This describes the Gulp pipeline inspected on 24 September 2026 and the subsequently configured VS Code workflow. No install, watch or build command was run during the original audit. Browser behavior has not been certified.

## VS Code Live Sass Compiler

Workspace settings in `.vscode/settings.json` configure the installed `glenn2223.live-sass` extension. Open **this theme folder** as the VS Code workspace (or add it as a workspace folder), then click **Watch Sass** if it is not already watching. Watching is configured to start on workspace launch and compile all entry files initially. Save an SCSS file to compile it; saving an underscore partial rebuilds the included entry files, including blocks that use shared variables.

The single relative output rule `~/../css` maps both source layouts correctly:

| Source | Output |
| --- | --- |
| `scss/screen.scss` | `css/screen.min.css` |
| `scss/above-the-fold.scss` | `css/above-the-fold.min.css` |
| `blocks/<name>/scss/<name>.scss` | `blocks/<name>/css/<name>.min.css` |

Output is compressed `.min.css`, with companion maps beside each CSS file. Autoprefixing uses the existing `package.json` browserslist. Underscore partials are imports rather than standalone outputs; node_modules and editor/git directories are excluded. New block SCSS files match the include pattern automatically. Settings target the installed extension's Dart Sass compiler and support the theme's `@use` directives.

Do not run the Gulp watcher and Live Sass watcher together: both write the same CSS. The Gulp commands below remain an alternative. Existing legacy Gulp maps are retained; Live Sass generates maps alongside CSS instead of in the old nested map directories. JavaScript is still edited directly and is not processed by this extension.

Configuration reference: [Live Sass Compiler settings](https://github.com/glenn2223/vscode-live-sass-compiler/blob/master/docs/settings.md). If VS Code was already watching when settings changed, stop and restart **Watch Sass** once to apply them. The Output panel's **Live Sass Compiler** channel shows compilation results.

## Start safely

Use the existing Local site. The theme is at:

```text
/Users/narayan/Local Sites/play-arena/app/public/wp-content/themes/playarena.in
```

Inspect `git status --short` before work: the audit began with many modified/untracked files and a deleted activity archive. Do not reset or overwrite that baseline. Preserve a database backup outside the public web root; schema, forms, menus, editor content and custom CSS/JS are database-backed. Do not switch themes casually: `inc/matsio.php` changes WordPress image-size settings on theme activation.

ACF Pro, CPT UI, Max Mega Menu, Gravity Forms, its wrapper add-on and database custom CSS/JS underpin the current site. WooCommerce owns the commerce/account pages. The snapshot's plugin state is not proof of the running site's state; verify in a later runtime pass before disabling anything.

Existing `node_modules` and a lockfile are present. Node available during audit was v24.18.0; the project does not pin a supported Node version. The older Gulp dependency set has not been executed with it. Do not infer compatibility from `node --check` alone. There is no `package.json.scripts`, `.nvmrc`, yarn lockfile or defined npm build/dev script in the inspected root. The lockfile is version 3 and `.gitignore` excludes lockfiles. Agree on dependency/version reproducibility before a clean install; no installation was needed for this audit.

## Command reference

Run these from the theme root, when development/build writes are authorized:

| Command | Actual configured behavior |
| --- | --- |
| `./node_modules/.bin/gulp css` | Compile global SCSS and all block SCSS, compressed and autoprefixed, with source maps. |
| `./node_modules/.bin/gulp blocks` | Compile block SCSS only. |
| `./node_modules/.bin/gulp` | Default task: compile global CSS only. Does **not** build all blocks. |
| `./node_modules/.bin/gulp watch` | Start BrowserSync plus watchers. Does **not** run an initial full build. |

These direct local-binary commands avoid an implicit package download. Conventional `npx gulp css` / `npx gulp watch` equivalents assume Gulp is installed locally. There is **no distinct production build command**: `gulp css` is the closest existing complete CSS build, already compressed, and still writes source maps. No `--production` handling is implemented, despite an imported options package. No production JS bundle is created.

## SCSS workflow

1. Edit `scss/_*.scss` for global/component/page styles. `scss/screen.scss` loads `_screen-base.scss` (the existing theme imports) followed by `_custom-overrides.scss` (the two previously migrated Custom CSS plugin snippets) and `_plugin-customizations.scss` (the five remaining CSS entries). These are separate Sass modules so legacy `@extend .wrap` rules cannot broaden the migrated selectors. Keep overrides last, with mobile rules after general rules. `scss/_variables.scss` contains colors, fonts, widths, `ptr()` and responsive mixins. The `ptr()` function does not convert pixels to rems today.
2. Edit `blocks/<name>/scss/<name>.scss` for an individual block. Hero-slider is the exception: its styles are in `scss/_hero-slider.scss` and included globally.
3. Run `./node_modules/.bin/gulp css` to rebuild both global and block outputs. Shared variable changes must rebuild blocks too; the current global watcher only rebuilds globals for that change.
4. Inspect generated diffs and wait for actual output completion. The tasks invoke `done()` immediately instead of returning their streams, so reported task completion is not a reliable signal that writes are finished.
5. Refresh the real Local URL, verify changed styles and inspect any plugin/cache interference. The theme inlines global CSS in `wp_head`; block CSS loads via block metadata. Database custom CSS can override both.

Pipeline: SCSS → Dart Sass compressed output → Autoprefixer → `.min.css` rename → external source map → output directory. Autoprefixer uses the legacy `browserslist` in `package.json`. No separate PostCSS configuration exists.

Outputs currently present:

```text
scss/screen.scss                         → css/screen.min.css
scss/above-the-fold.scss                 → css/above-the-fold.min.css
blocks/<name>/scss/<name>.scss           → blocks/<name>/css/<name>.min.css
global maps                             → css/css/*.min.css.map
block maps                              → css/blocks/<name>/css/*.min.css.map
```

The map directory nesting follows the existing Gulp path operations; some map comments resolve to paths different from the files actually present. Verify those before relying on browser source mapping. `above-the-fold.scss` is empty. An extra `blocks/sample-block/scss/css/sample-block.min.css` is not the canonical metadata-referenced output.

## JavaScript workflow

Edit `js/index.js` for global interactions or `blocks/<name>/js/<name>.js` for a block. Those files are served directly. There is **no JS compile/bundle/transpile step**. Modern language features therefore reach the browser unchanged, regardless of Babel configuration in package.json.

`functions.php` enqueues WordPress jQuery, all `js/vendor/*.js`, and index.js. `inc/block-management.php` registers block script handles; each block's JSON selects scripts. Preserve dependencies and selectors when changing behavior. A block script may run on multiple instances, but much current code assumes a single instance; changing that requires explicit testing.

The watcher observes `./js/**/*.js`, so global/vendor edits reload. It does **not** observe `blocks/**/js/*.js`; block JS edits need a manual refresh. Browserify, Babelify, Uglify, strip-debug, plumber and other imported helpers do not constitute an active JS build. `triggerPlumber()` is unused. No automated image optimization, font copying or asset copying task is wired in.

## BrowserSync limitation

The watch task configures HTTPS, port 8000 and host `dev.matsio.com`, but no WordPress proxy or static server. It is not configured to preview this Local installation. Its browser integration may not work as-is. Until a separately authorized setup change, use the actual Local site URL and manual reload; one-shot CSS compilation is the unambiguous existing workflow. Do not substitute a guessed local domain into configuration during discovery.

## Files to edit and preserve

| Category | Guidance |
| --- | --- |
| PHP templates, `inc`, block renderers | Authored source. Preserve field names/return shapes, queries and shortcode IDs unless deliberately migrating. |
| `scss`, block `scss` | Authored styling source. Check database overrides and editor classes before diagnosing specificity. |
| `js/index.js`, block `js` | Authored application source. Edit directly; no generated JS counterpart. |
| `block.json` | Block identity and asset contracts. Renaming `acf/*` names breaks saved content unless migrated. |
| `css/*.min.css`, block `css/*.min.css`, all `.map` files | Generated outputs. Do not patch manually as the source of a fix. Rebuild and review. |
| `js/vendor/*.min.js` | Third-party distributions; do not hand-edit. Version replacement is separate work. |
| `fonts/stylesheet.css`, `fonts/google.css`, font files | Static supplied assets, outside the Gulp transform. Preserve licensing and paths; generator/specimen files are not site entry points. |
| `img`, screenshots, PSD | Static assets; no active copying/optimization pipeline. Determine actual usage before deleting. |
| `node_modules`, lockfile | Dependency artifacts; do not edit individual package files. |
| ACF groups, CPT UI options, menus, forms, custom CSS/JS | Database configuration, not theme source. Export/migrate deliberately in later work. Never commit a complete sensitive DB dump. |

## Verification after an authorized change

Use focused checks: PHP syntax for changed renderers, `node --check` for changed JS, block JSON parsing, and the relevant Local pages at mobile/tablet/desktop widths. Syntax checks do not catch missing ACF fields, unassigned locations, duplicate IDs, script ordering, keyboard issues or broken booking URLs.

For styling, compare the actual generated outputs, not only SCSS. For shared components, include Home, activity detail, location taxonomy, corporate/birthday pages, academy detail, sleepover and enquiry forms. Empty data and repeated block instances are meaningful edge cases. Do not submit forms, purchases or external bookings as part of a visual check without a defined test flow.

The audit did not run a build, install, Sass compilation or browser test. Existing CSS/source parity and production reproducibility remain open. See [REFACTOR-NOTES.md](REFACTOR-NOTES.md) for the prioritized investigation list.

## Migrated custom code

See [CUSTOM-CODE-MIGRATION.md](CUSTOM-CODE-MIGRATION.md) for the complete plugin-entry inventory, duplicate-output suppression and rollback procedure. The consolidated purchase event is in `js/index.js`, with server-validated order data supplied by `inc/custom-code.php`. Edit these theme sources rather than the retained plugin entries.
