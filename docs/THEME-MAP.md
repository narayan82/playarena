# PlayArena theme map

Audit date: 24 September 2026. Paths are relative to this theme unless stated otherwise. Database evidence describes the existing local SQL export, not a live database query. No content values, credentials or personal data are included.

## Major pages and routes

Standard theme pages share header.php, footer.php, js/index.js and all three vendor scripts. There is no page.php: ordinary pages use index.php. Content means saved Gutenberg/core and ACF blocks.

| Page / route | WP template | Data source | Components / JS beyond global |
| --- | --- | --- | --- |
| Home, front-page ID 5 | front-page.php | Front-page content, location terms, specials and options | hero-slider, featured-events, offers-slider, date-picker, coming-events, member-benefits; block JS. No published events in snapshot, so coming-events is gated off. |
| Activities archive | index.php fallback; archive-activity.php deleted | Main query, but no listing Loop | Legacy archive CSS/load-more JS remain; working listing unverified. |
| Locations / venue groupings | taxonomy-location.php | location term fields, activity queries, event posts and options | Activity tabs, Slick images, offers/events; index.js tabs/hash. Location is an activity grouping, not a venue CPT. |
| Activity detail | single-activity.php | Activity fields/excerpt, location term, related specials/events | Sibling navigation, sliders, host links, benefits; index.js and inline select navigation. |
| Events archive | archive-event.php | get_posts(event), date/description/color; separate main-query count | Event cards; no dedicated pagination/filter. |
| Event detail | single-event.php | Post content | Authored content blocks; no published snapshot examples. |
| Named Page Events | template-events.php | Page content | Content blocks; published assignment not established. |
| Offers | No dedicated specials archive | Specials posts; options repeater on location page | offers-slider + Slick; activity/location global handlers. |
| Corporate team building, page 36 | index.php | Page content | hero-video, tab-block, event-spaces, slider-type-1. |
| Birthday/group experiences, page 834 | index.php | Page content | Same block family as corporate page. |
| Play dates, page 1495 | index.php | Page content, Gravity Form 5 | hero-video, tab-block, Gravity Forms. |
| Named Create Event | template-create-event.php | Spaces/activities/entertainment/cuisine, facilities/stories, GF 1 | Global activity/story sliders and GLightbox; template assignment unverified. |
| Academies archive | archive-academies.php | Options title, embedded block payload; actual block now queries academies | academies-tab.js, age groups/cards. Old payload no longer selects cards. |
| Academies landing, page 747 | index.php | Core content | Separate from CPT archive; no academies-tab in saved page. |
| Academy detail | single-academies.php | Post content and featured image | Hero carousel and authored blocks. |
| Restaurant archive | archive-restaurant.php | Restaurant posts, excerpts, thumbnails | Archive cards, no pagination. |
| Restaurant detail | single-restaurant.php | Post content | Hero/feature blocks as authored. |
| Food court, page 174 | index.php | Page content | hero-video, food-item-list. |
| Catering, page 212 | index.php | Page content | single-page-hero-carousel, restaurant-features. |
| Sleepover, page 1801 | index.php | Core cover/video and ACF repeaters | pre-packed-fun, bottom-image-scroll, event-scroll; hotel booking link. |
| Contact/enquiries | index.php | Page 1900/GF 4, page 1390/GF 6, options/menus | Gravity Forms, wrapper add-on, optional section toggle. No contact.php. |
| Activity booking | External site | button_link metadata or date-picker booking host | Outbound navigation; no theme inventory/payment implementation. |
| Shop/cart/checkout/account | WP fallback + WooCommerce rendering | Plugin pages 2253–2256 | Cart/checkout blocks; account shortcode; no theme overrides. |
| Privacy/terms/cancellation-refund | index.php | Pages 1872/1868/1874, core content | Database CSS supplements global styling. |
| General editorial info, page 1695 | index.php | Core content | Database page-ID styling. |
| Search / other archives | index.php fallback | WP main query without results Loop | No search.php/searchform.php; working results screen unverified. |
| Unknown URL | 404.php | None | Effectively empty file. |

## Backend contracts

All six site CPTs are registered by CPT UI from wp_options.cptui_post_types; location/sports/cusine come from cptui_taxonomies. Registration functions are in wp-content/plugins/custom-post-type-ui/custom-post-type-ui.php. None is registered in theme PHP.

| CPT | Taxonomy | Field group and consumer |
| --- | --- | --- |
| activity | location | Post Type: Activity; single-activity, taxonomy-location and related-content references. Taxonomy : Location feeds hero-slider and both location/activity headers. |
| event | None configured | Post Type: Event; archive-event, coming-events, events, related-event sections and Create Event. |
| restaurant | cusine | No dedicated group; core content, excerpt and thumbnail plus blocks. |
| academies | sports | Post Type: Academies; academies-tab cards/age grouping, content-driven single. |
| entertainment | None configured | No dedicated group; selected through Event.entertainment and Create Event. |
| specials | None configured | Post Type: Specials; offers-slider and activity related offers. |

WooCommerce supplies product/commerce models independently. public-event is a legacy ACF location reference and event-type has term records, but neither has a matching current CPT UI registration in the export.

Menus: header-menu, footer-menu, footer-menu-1, footer-menu-2, mobile-menu-icons. Options page: common-settings, capability edit_posts. Class: AWP_Menu_Walker. Helper: checkArray(), no other theme call found. No theme frontend widget areas, custom shortcodes, AJAX handlers or REST routes. Dashboard widget/removals live in inc/matsio.php.

## Reusable blocks

Every block directory contains block.json, its PHP renderer and js/name.js. Except hero-slider, each has scss/name.scss and css/name.min.css. Hero-slider styling is global scss/_hero-slider.scss. Snapshot uses below count literal instances in published posts; PHP-injected blocks are excluded. Zero does not establish safe deletion.

| Block | Purpose / data | Snapshot uses |
| --- | --- | --- |
| `academies-tab` | Query all academies by menu_order, group by age_group, render academy cards and desktop/mobile tabs. | 0 |
| `bottom-image-scroll` | Mixed image/testimonial cards, rating asset and Slick carousel. | 1 |
| `coaches` | Coach image/name/CTA carousel; description is fetched but not rendered. | 0 |
| `coming-events` | Selected or all event cards with dates; entire block gated by an event query. | 1 |
| `cusine` | Query cusine terms for menu cards; term ID/permalink handling is suspect. | 0 |
| `date-picker` | Weekday-based options content and booking link; no availability API. | 1 |
| `event` | Empty scaffold; named CSS handles are not registered by the theme. | 0 |
| `event-scroll` | Repeated icon/text strip animated with CSS keyframes; JS empty. | 1 |
| `event-spaces` | Space tabs, text/icon facts and image slides; mobile select has stray alert(). | 2 |
| `events` | Selected or all event promotional cards. | 0 |
| `featured-events` | Editor-authored promotional event cards independent of event posts. | 1 |
| `food-item-list` | Food cards with image, description and CTA. | 1 |
| `gallery-slider` | Image carousel from gallery repeater (not an ACF gallery field). | 0 |
| `hero-slider` | Location term video/image panels, timed tabs, and links to first activity per location. | 1 |
| `hero-video` | Image or autoplay/muted video chosen by select_option. | 5 |
| `member-benefits` | Reusable options-powered membership benefits and placeholder CTA. | 1 |
| `membership` | Empty scaffold. | 0 |
| `offers-slider` | Query all specials for promotional carousel and offer URL. | 1 |
| `pre-packed-fun` | Package/experience cards; price fetched but not output; Slick. | 1 |
| `restaurant-features` | Feature cards with image, rich text and CTA. | 2 |
| `sample-block` | Development scaffold with undefined $style and console message. | 0 |
| `single-page-hero-carousel` | Carousel plus current post featured image and configurable CTAs. | 5 |
| `slider-type-1` | Generic image/title/description/CTA carousel. | 2 |
| `tab-block` | Nested tab → sections → slide cards, synchronized desktop/mobile controls. | 3 |

## ACF field definitions

Verified serialized definitions from snapshot wp_posts: 24 published groups and 204 published fields. Hierarchy, types and configured return formats are schema facts. No field values are reproduced. Group scope identifies purpose/consumer via the block and model tables above; the following call index maps actual reads to files and lines. Identically named fields in different scopes must not be merged.

Common Settings powers footer address/social/subscription, weekday information, section headings and membership benefits. Some defined fields are unused; a definition does not prove rendered output.


### Post Type: Event — group record 30

Location: (post_type == event) OR (page == 235) OR (post_type == public-event).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `activities` | post_object | return_format=object; multiple=1; post_type=activity |
| `number_of_value_add_ons` | text | Default / not explicitly configured |
| `spaces` | taxonomy | return_format=object; multiple=0; taxonomy=location |
| `event_date` | date_picker | return_format=F j, Y |
| `facilities` | repeater | Default / not explicitly configured |
| `facilities.facility` | text | Default / not explicitly configured |
| `facilities.image_for_facility` | image | return_format=id |
| `entertainment` | post_object | return_format=object; multiple=1; post_type=entertainment |
| `food_and_beverages` | taxonomy | return_format=object; multiple=0; taxonomy=cusine |
| `event_image` | image | return_format=id |
| `event_description` | wysiwyg | Default / not explicitly configured |
| `title` | text | Default / not explicitly configured |
| `event_icon` | image | return_format=id |
| `event_color` | color_picker | return_format=string |

### Block: Offers Slider — group record 45

Location: (block == acf/offers-slider AND options_page == common-settings).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `offers_at_play` | repeater | Default / not explicitly configured |
| `offers_at_play.image` | image | return_format=id |
| `offers_at_play.title` | text | Default / not explicitly configured |
| `offers_at_play.subtitle` | text | Default / not explicitly configured |
| `offers_at_play.description` | textarea | Default / not explicitly configured |
| `offers_at_play.offer_starting_date` | date_picker | return_format=d-m-y |
| `offers_at_play.offer_end_date` | date_picker | return_format=d-m-y |
| `offers_at_play.url` | url | Default / not explicitly configured |

### Common Settings — group record 56

Location: (options_page == common-settings).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `special_offers_details` | repeater | Default / not explicitly configured |
| `special_offers_details.select_day` | select | return_format=value; multiple=0 |
| `special_offers_details.add_details` | repeater | Default / not explicitly configured |
| `special_offers_details.add_details.heading` | select | return_format=value; multiple=0 |
| `special_offers_details.add_details.add_content` | repeater | Default / not explicitly configured |
| `special_offers_details.add_details.add_content.sub_title` | text | Default / not explicitly configured |
| `special_offers_details.add_details.add_content.sub_title.sub_title` | text | Default / not explicitly configured |
| `special_offers_details.add_details.add_content.sub_title.content` | text | Default / not explicitly configured |
| `special_offers_details.add_details.add_content.content` | text | Default / not explicitly configured |
| `special_offers_details.add_details.add_content.icon` | image | return_format=id |
| `special_offers_details.message` | wysiwyg | Default / not explicitly configured |
| `address` | wysiwyg | Default / not explicitly configured |
| `social_media` | repeater | Default / not explicitly configured |
| `social_media.name` | text | Default / not explicitly configured |
| `social_media.link` | url | Default / not explicitly configured |
| `social_media.icon` | image | return_format=id |
| `details_for_sending_stories` | wysiwyg | Default / not explicitly configured |
| `mail_details_for_sending_stories` | wysiwyg | Default / not explicitly configured |
| `key_benefits_of_membership` | accordion | Default / not explicitly configured |
| `title_for_member_benefits` | text | Default / not explicitly configured |
| `description_for_member_benefits` | textarea | Default / not explicitly configured |
| `benefits` | repeater | Default / not explicitly configured |
| `benefits.title` | text | Default / not explicitly configured |
| `benefits.description` | text | Default / not explicitly configured |
| `benefits.image` | image | return_format=id |
| `member_benefits_button_text` | text | Default / not explicitly configured |
| `subscribe_title` | text | Default / not explicitly configured |
| `offers_at_play` | repeater | Default / not explicitly configured |
| `offers_at_play.image` | image | return_format=id |
| `offers_at_play.title` | text | Default / not explicitly configured |
| `offers_at_play.subtitle` | text | Default / not explicitly configured |
| `offers_at_play.description` | textarea | Default / not explicitly configured |
| `offers_at_play.offer_starting_date` | date_picker | return_format=d-m-y |
| `offers_at_play.offer_end_date` | date_picker | return_format=d-m-y |
| `specials_section_title` | text | Default / not explicitly configured |
| `events_section_title` | text | Default / not explicitly configured |
| `events_section_button_text` | text | Default / not explicitly configured |
| `specials_section_image` | image | return_format=id |
| `academies_listing_page_title` | text | Default / not explicitly configured |

### Post Type: Activity — group record 92

Location: (post_type == activity).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `age_group` | text | Default / not explicitly configured |
| `price` | text | Default / not explicitly configured |
| `duration` | text | Default / not explicitly configured |
| `maximum_players` | text | Default / not explicitly configured |
| `images_for_slider` | repeater | Default / not explicitly configured |
| `images_for_slider.image` | image | return_format=id |
| `stories` | repeater | Default / not explicitly configured |
| `stories.name` | text | Default / not explicitly configured |
| `stories.story_user_name` | text | Default / not explicitly configured |
| `stories.video` | file | return_format=url |
| `activity_icon` | image | return_format=id |
| `host_` | accordion | Default / not explicitly configured |
| `title_for_host_this_activity` | text | Default / not explicitly configured |
| `description_for_host_event` | textarea | Default / not explicitly configured |
| `events_for_the_activity` | repeater | Default / not explicitly configured |
| `events_for_the_activity.event_name` | text | Default / not explicitly configured |
| `events_for_the_activity.icon` | image | return_format=id |
| `events_for_the_activity.link` | text | Default / not explicitly configured |
| `button_link` | text | Default / not explicitly configured |

### Post Type: Academies — group record 134

Location: (post_type == academies).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `age_group` | select | return_format=value; multiple=0 |
| `title` | text | Default / not explicitly configured |
| `description` | textarea | Default / not explicitly configured |
| `thumbnail_image` | image | return_format=id |
| `link` | link | return_format=url |

### Block: Coaches — group record 140

Location: (block == acf/coaches).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `coach_details` | repeater | Default / not explicitly configured |
| `coach_details.name` | text | Default / not explicitly configured |
| `coach_details.image` | image | return_format=id |
| `coach_details.button_text` | text | Default / not explicitly configured |
| `coach_details.button_link` | link | return_format=url |

### Block: Single Page Hero Carousel — group record 150

Location: (block == acf/single-page-hero-carousel).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `carousel_images` | repeater | Default / not explicitly configured |
| `carousel_images.image` | image | return_format=id |
| `hero_button_details` | repeater | Default / not explicitly configured |
| `hero_button_details.button_text` | text | Default / not explicitly configured |
| `hero_button_details.link` | link | return_format=url |
| `academy_logo_image` | image | return_format=id |

### Block: Restaurant Features — group record 206

Location: (block == acf/restaurant-features).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `features` | repeater | Default / not explicitly configured |
| `features.title` | text | Default / not explicitly configured |
| `features.description` | wysiwyg | Default / not explicitly configured |
| `features.image` | image | return_format=id |
| `features.button_text` | text | Default / not explicitly configured |
| `features.button_link` | text | Default / not explicitly configured |

### Taxonomy : Location — group record 258

Location: (taxonomy == location).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `stories` | repeater | Default / not explicitly configured |
| `stories.name` | text | Default / not explicitly configured |
| `stories.story_user_name` | text | Default / not explicitly configured |
| `stories.story_video` | file | return_format=url |
| `stories.link` | url | Default / not explicitly configured |
| `stories.thumbnail` | image | return_format=id |
| `images_for_bottom_slider` | repeater | Default / not explicitly configured |
| `images_for_bottom_slider.image` | image | return_format=id |
| `images_for_bottom_slider.title` | text | Default / not explicitly configured |
| `location_image` | image | return_format=url |
| `location_icon` | textarea | Default / not explicitly configured |
| `location_color` | color_picker | return_format=string |
| `location-video` | file | return_format=url |

### Block: Coming Events — group record 283

Location: (block == acf/coming-events).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `coming_event_title` | text | Default / not explicitly configured |
| `show_more_button` | true_false | Default / not explicitly configured |
| `display_option` | select | return_format=value; multiple=0 |
| `event_list` | repeater | Default / not explicitly configured |
| `event_list.event` | post_object | return_format=object; multiple=0; post_type=event |

### Block: Events — group record 435

Location: (block == acf/events).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `display_option` | select | return_format=value; multiple=0 |
| `event_list` | repeater | Default / not explicitly configured |
| `event_list.event` | post_object | return_format=object; multiple=0; post_type=event |

### Post Type: Specials — group record 552

Location: (post_type == specials).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `title` | text | Default / not explicitly configured |
| `sub_text` | text | Default / not explicitly configured |
| `description` | textarea | Default / not explicitly configured |
| `offer_start_date` | date_picker | return_format=d-m-y |
| `offer_end_date` | date_picker | return_format=d/m/Y |
| `thumbnail_image` | image | return_format=id |
| `activities` | post_object | return_format=object; multiple=1; post_type=activity |

### Block: Featured Events — group record 606

Location: (block == acf/featured-events).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `events_list` | repeater | Default / not explicitly configured |
| `events_list.event_name` | text | Default / not explicitly configured |
| `events_list.event_icon` | image | return_format=id |
| `events_list.event_description` | textarea | Default / not explicitly configured |
| `events_list.thumbnail_image` | image | return_format=id |
| `events_list.button_text` | text | Default / not explicitly configured |
| `events_list.button_link` | text | Default / not explicitly configured |

### Block: Hero Video — group record 622

Location: (block == acf/hero-video).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `image` | image | return_format=id |
| `video` | file | return_format=url |
| `select_option` | select | return_format=value; multiple=0 |
| `video_thumbnail` | image | return_format=url |

### Block: Tab Block — group record 632

Location: (block == acf/tab-block).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `tab_details` | repeater | Default / not explicitly configured |
| `tab_details.tab_name` | text | Default / not explicitly configured |
| `tab_details.slider_section` | repeater | Default / not explicitly configured |
| `tab_details.slider_section.slider_section_title` | text | Default / not explicitly configured |
| `tab_details.slider_section.slider_section_description` | textarea | Default / not explicitly configured |
| `tab_details.slider_section.slide` | repeater | Default / not explicitly configured |
| `tab_details.slider_section.slide.thumbnail` | image | return_format=id |
| `tab_details.slider_section.slide.slide_title` | text | Default / not explicitly configured |
| `tab_details.slider_section.slide.description` | textarea | Default / not explicitly configured |
| `tab_details.slider_section.slide.button_text` | text | Default / not explicitly configured |
| `tab_details.slider_section.slide.button_link` | text | Default / not explicitly configured |
| `label_for_tab` | text | Default / not explicitly configured |

### Block: Event Spaces — group record 659

Location: (block == acf/event-spaces).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `event_space_details` | repeater | Default / not explicitly configured |
| `event_space_details.tab_name` | text | Default / not explicitly configured |
| `event_space_details.space_title` | text | Default / not explicitly configured |
| `event_space_details.space_description` | textarea | Default / not explicitly configured |
| `event_space_details.more_details_abouts_space` | repeater | Default / not explicitly configured |
| `event_space_details.more_details_abouts_space.value_type` | select | return_format=value; multiple=0 |
| `event_space_details.more_details_abouts_space.value` | text | Default / not explicitly configured |
| `event_space_details.more_details_abouts_space.icon` | image | return_format=id |
| `event_space_details.more_details_abouts_space.info_text` | text | Default / not explicitly configured |
| `event_space_details.slider_images` | repeater | Default / not explicitly configured |
| `event_space_details.slider_images.slider_image` | image | return_format=id |

### Block: Slider Type  1 — group record 679

Location: (block == acf/slider-type-1).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `slider_content` | repeater | Default / not explicitly configured |
| `slider_content.thumbnail` | image | return_format=id |
| `slider_content.title` | text | Default / not explicitly configured |
| `slider_content.description` | textarea | Default / not explicitly configured |
| `slider_content.button_text` | text | Default / not explicitly configured |
| `slider_content.button_link` | text | Default / not explicitly configured |

### Block: Food Item List — group record 696

Location: (block == acf/food-item-list).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `food_item_list` | repeater | Default / not explicitly configured |
| `food_item_list.image` | image | return_format=id |
| `food_item_list.title` | text | Default / not explicitly configured |
| `food_item_list.description` | textarea | Default / not explicitly configured |
| `food_item_list.button_text` | text | Default / not explicitly configured |
| `food_item_list.button_link` | link | return_format=url |

### Block: Gallery Slider — group record 722

Location: (block == acf/gallery-slider).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `gallery` | repeater | Default / not explicitly configured |
| `gallery.image` | image | return_format=id |

### Block: Academies Tab — group record 749

Location: (block == acf/academies-tab).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `academy` | repeater | Default / not explicitly configured |
| `academy.tab_name` | text | Default / not explicitly configured |
| `academy.academy_list` | repeater | Default / not explicitly configured |
| `academy.academy_list.academy` | post_object | return_format=object; multiple=0; post_type=academies |
| `label_for_filter` | text | Default / not explicitly configured |

### Block: Bottom Image Scroll — group record 1802

Location: (block == acf/bottom-image-scroll).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `bottom_image_scroll` | repeater | Default / not explicitly configured |
| `bottom_image_scroll.type` | select | return_format=value; multiple=0 |
| `bottom_image_scroll.image` | image | return_format=id |
| `bottom_image_scroll.content` | text | Default / not explicitly configured |
| `bottom_image_scroll.name` | text | Default / not explicitly configured |
| `bottom_image_scroll.logo` | image | return_format=id |

### Block: Image Scroll Bottom — group record 1809

Location: (post_type == post).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `image_scroll` | repeater | Default / not explicitly configured |
| `image_scroll.type` | select | return_format=value; multiple=0 |
| `image_scroll.image` | image | return_format=id |
| `image_scroll.content` | text | Default / not explicitly configured |

### Block: Event Scroll — group record 1814

Location: (block == acf/event-scroll).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `event_scroll` | repeater | Default / not explicitly configured |
| `event_scroll.icon` | image | return_format=id |
| `event_scroll.icon_text` | text | Default / not explicitly configured |

### Block: Pre Packed Fun — group record 1818

Location: (block == acf/pre-packed-fun).

| Field path | Type | Return / selection contract |
| --- | --- | --- |
| `pre_packed_fun` | repeater | Default / not explicitly configured |
| `pre_packed_fun.heading` | wysiwyg | Default / not explicitly configured |
| `pre_packed_fun.icon` | image | return_format=id |
| `pre_packed_fun.paragraph` | text | Default / not explicitly configured |
| `pre_packed_fun.price` | text | Default / not explicitly configured |

### Unattached field records

Three of the 204 published field records reference missing parent record 199. They cannot be assigned to a verified group or frontend scope. The group trees above contain the other 201 fields. These names also occur elsewhere, which does not establish that these orphan records supply those consumers.

| Field | Type | Record / parent | Verified consumer |
| --- | --- | --- | --- |
| `title` | text | 201 / missing 199 | Unknown |
| `description` | wysiwyg | 202 / missing 199 | Unknown |
| `image` | image | 203 / missing 199 | Unknown |

## Actual ACF field → consumer index

Rows group literal calls in one file; lines refer to the audited working tree. get_field/the_field without a second argument use current post/block context. option/options selects shared settings; term/post variables select that object. get_sub_field follows the active repeater: its second argument is a formatting argument, not a post ID. have_rows documents repeater scope. Purpose follows the owner in the page/block tables. Source occurrences are independently verified from schema; reads do not establish a matching field definition.

| Consumer | Field | Calls / context | Lines |
| --- | --- | --- | --- |
| `archive-academies.php` | `academies_listing_page_title` | `get_field: 'options'` | 5 |
| `archive-event.php` | `event_color` | `get_field: $id` | 47 |
| `archive-event.php` | `event_date` | `get_field: $id` | 43, 56 |
| `archive-event.php` | `event_description` | `get_field: $id` | 46, 60 |
| `blocks/academies-tab/academies-tab.php` | `age_group` | `get_field: $academy->ID` | 54, 55, 57 |
| `blocks/academies-tab/academies-tab.php` | `description` | `get_field: $postId` | 123 |
| `blocks/academies-tab/academies-tab.php` | `label_for_filter` | `get_field: current post/block` | 42 |
| `blocks/academies-tab/academies-tab.php` | `thumbnail_image` | `get_field: $postId` | 124 |
| `blocks/academies-tab/academies-tab.php` | `title` | `get_field: $postId` | 122 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `bottom_image_scroll` | `have_rows: current post/block` | 33, 36 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `content` | `get_sub_field: active repeater` | 48 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `image` | `get_sub_field: active repeater` | 40 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `logo` | `get_sub_field: active repeater` | 49 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `name` | `get_sub_field: active repeater` | 47 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | `type` | `get_sub_field: active repeater` | 38 |
| `blocks/coaches/coaches.php` | `button_link` | `get_sub_field: active repeater` | 42 |
| `blocks/coaches/coaches.php` | `button_text` | `get_sub_field: active repeater` | 41 |
| `blocks/coaches/coaches.php` | `coach_details` | `have_rows: current post/block` | 34, 35 |
| `blocks/coaches/coaches.php` | `description` | `get_sub_field: active repeater` | 38 |
| `blocks/coaches/coaches.php` | `image` | `get_sub_field: active repeater` | 40 |
| `blocks/coaches/coaches.php` | `name` | `get_sub_field: active repeater` | 37 |
| `blocks/coming-events/coming-events.php` | `coming_event_title` | `the_field: current post/block` | 43 |
| `blocks/coming-events/coming-events.php` | `display_option` | `get_field: current post/block` | 60 |
| `blocks/coming-events/coming-events.php` | `event` | `get_sub_field: active repeater` | 65 |
| `blocks/coming-events/coming-events.php` | `event_color` | `get_field: $id` | 72, 142 |
| `blocks/coming-events/coming-events.php` | `event_date` | `get_field: $id` | 68, 81, 137 |
| `blocks/coming-events/coming-events.php` | `event_description` | `get_field: $id` | 71, 85, 141 |
| `blocks/coming-events/coming-events.php` | `event_list` | `have_rows: current post/block` | 62, 63 |
| `blocks/coming-events/coming-events.php` | `show_more_button` | `get_field: current post/block` | 46 |
| `blocks/date-picker/date-picker.php` | `add_content` | `have_rows: current post/block` | 77, 78 |
| `blocks/date-picker/date-picker.php` | `add_details` | `have_rows: current post/block` | 65, 66 |
| `blocks/date-picker/date-picker.php` | `content` | `get_sub_field: active repeater` | 92 |
| `blocks/date-picker/date-picker.php` | `heading` | `get_sub_field: active repeater` | 72 |
| `blocks/date-picker/date-picker.php` | `icon` | `get_sub_field: active repeater` | 84 |
| `blocks/date-picker/date-picker.php` | `message` | `get_sub_field: 'option'; get_sub_field: active repeater` | 43, 47 |
| `blocks/date-picker/date-picker.php` | `select_day` | `get_sub_field: active repeater` | 45, 61, 62 |
| `blocks/date-picker/date-picker.php` | `special_offers_details` | `have_rows: 'option'` | 40, 41, 57, 58 |
| `blocks/date-picker/date-picker.php` | `sub_title` | `get_sub_field: active repeater` | 89, 90 |
| `blocks/event-scroll/event-scroll.php` | `event_scroll` | `have_rows: current post/block` | 33, 36, 50, 51 |
| `blocks/event-scroll/event-scroll.php` | `icon` | `get_sub_field: active repeater` | 38, 53 |
| `blocks/event-scroll/event-scroll.php` | `icon_text` | `get_sub_field: active repeater` | 39, 54 |
| `blocks/event-spaces/event-spaces.php` | `event_space_details` | `have_rows: current post/block` | 34, 36, 58, 60, 79, 81 |
| `blocks/event-spaces/event-spaces.php` | `icon` | `get_sub_field: active repeater` | 130 |
| `blocks/event-spaces/event-spaces.php` | `info_text` | `get_sub_field: active repeater` | 111 |
| `blocks/event-spaces/event-spaces.php` | `more_details_abouts_space` | `have_rows: current post/block` | 104, 108 |
| `blocks/event-spaces/event-spaces.php` | `slider_image` | `get_sub_field: active repeater` | 156 |
| `blocks/event-spaces/event-spaces.php` | `slider_images` | `have_rows: current post/block` | 153, 154 |
| `blocks/event-spaces/event-spaces.php` | `space_description` | `get_sub_field: active repeater` | 85 |
| `blocks/event-spaces/event-spaces.php` | `space_title` | `get_sub_field: active repeater` | 84 |
| `blocks/event-spaces/event-spaces.php` | `tab_name` | `get_sub_field: active repeater` | 38, 62 |
| `blocks/event-spaces/event-spaces.php` | `value` | `get_sub_field: active repeater` | 116 |
| `blocks/event-spaces/event-spaces.php` | `value_type` | `get_sub_field: active repeater` | 110 |
| `blocks/events/events.php` | `display_option` | `get_field: current post/block` | 35 |
| `blocks/events/events.php` | `event` | `get_sub_field: active repeater` | 40 |
| `blocks/events/events.php` | `event_icon` | `get_field: $id` | 44, 98 |
| `blocks/events/events.php` | `event_list` | `have_rows: current post/block` | 37, 38 |
| `blocks/events/events.php` | `title` | `get_field: $id` | 43, 97 |
| `blocks/featured-events/featured-events.php` | `button_link` | `get_sub_field: active repeater` | 40 |
| `blocks/featured-events/featured-events.php` | `button_text` | `get_sub_field: active repeater` | 39 |
| `blocks/featured-events/featured-events.php` | `event_description` | `get_sub_field: active repeater` | 42 |
| `blocks/featured-events/featured-events.php` | `event_icon` | `get_sub_field: active repeater` | 38 |
| `blocks/featured-events/featured-events.php` | `event_name` | `get_sub_field: active repeater` | 37 |
| `blocks/featured-events/featured-events.php` | `events_list` | `have_rows: current post/block` | 34, 35 |
| `blocks/featured-events/featured-events.php` | `thumbnail_image` | `get_sub_field: active repeater` | 41 |
| `blocks/food-item-list/food-item-list.php` | `button_link` | `get_sub_field: active repeater` | 41 |
| `blocks/food-item-list/food-item-list.php` | `button_text` | `get_sub_field: active repeater` | 40 |
| `blocks/food-item-list/food-item-list.php` | `description` | `get_sub_field: active repeater` | 43 |
| `blocks/food-item-list/food-item-list.php` | `food_item_list` | `have_rows: current post/block` | 34, 37 |
| `blocks/food-item-list/food-item-list.php` | `image` | `get_sub_field: active repeater` | 42 |
| `blocks/food-item-list/food-item-list.php` | `title` | `get_sub_field: active repeater` | 39 |
| `blocks/gallery-slider/gallery-slider.php` | `gallery` | `have_rows: current post/block` | 35, 38 |
| `blocks/gallery-slider/gallery-slider.php` | `image` | `get_sub_field: active repeater` | 40 |
| `blocks/hero-slider/hero-slider.php` | `location-video` | `get_field: $term` | 67 |
| `blocks/hero-slider/hero-slider.php` | `location_color` | `get_field: $term` | 62, 88, 122 |
| `blocks/hero-slider/hero-slider.php` | `location_icon` | `get_field: $term` | 92, 128 |
| `blocks/hero-slider/hero-slider.php` | `location_image` | `get_field: $term` | 68 |
| `blocks/hero-video/hero-video.php` | `image` | `get_field: current post/block` | 36 |
| `blocks/hero-video/hero-video.php` | `select_option` | `get_field: current post/block` | 34 |
| `blocks/hero-video/hero-video.php` | `video` | `get_field: current post/block` | 42 |
| `blocks/hero-video/hero-video.php` | `video_thumbnail` | `get_field: current post/block` | 43 |
| `blocks/member-benefits/member-benefits.php` | `benefits` | `have_rows: 'option'` | 55, 56 |
| `blocks/member-benefits/member-benefits.php` | `description` | `get_sub_field: active repeater` | 59 |
| `blocks/member-benefits/member-benefits.php` | `description_for_member_benefits` | `get_field: 'option'` | 36 |
| `blocks/member-benefits/member-benefits.php` | `image` | `get_sub_field: active repeater` | 60 |
| `blocks/member-benefits/member-benefits.php` | `member_benefits_button_text` | `get_field: 'option'` | 37 |
| `blocks/member-benefits/member-benefits.php` | `title` | `get_sub_field: active repeater` | 58 |
| `blocks/member-benefits/member-benefits.php` | `title_for_member_benefits` | `get_field: 'option'` | 35 |
| `blocks/offers-slider/offers-slider.php` | `description` | `get_field: $specialId` | 48 |
| `blocks/offers-slider/offers-slider.php` | `offer_end_date` | `get_field: $specialId` | 51 |
| `blocks/offers-slider/offers-slider.php` | `offer_start_date` | `get_field: $specialId` | 50 |
| `blocks/offers-slider/offers-slider.php` | `subtitle` | `get_field: $specialId` | 47 |
| `blocks/offers-slider/offers-slider.php` | `thumbnail_image` | `get_field: $specialId` | 45 |
| `blocks/offers-slider/offers-slider.php` | `title` | `get_field: $specialId` | 46 |
| `blocks/offers-slider/offers-slider.php` | `url` | `get_field: $specialId` | 78 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | `heading` | `get_sub_field: active repeater` | 37 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | `icon` | `get_sub_field: active repeater` | 38 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | `paragraph` | `get_sub_field: active repeater` | 39 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | `pre_packed_fun` | `have_rows: current post/block` | 33, 35 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | `price` | `get_sub_field: active repeater` | 40 |
| `blocks/restaurant-features/restaurant-features.php` | `button_link` | `get_sub_field: active repeater` | 42 |
| `blocks/restaurant-features/restaurant-features.php` | `button_text` | `get_sub_field: active repeater` | 41 |
| `blocks/restaurant-features/restaurant-features.php` | `description` | `get_sub_field: active repeater` | 39 |
| `blocks/restaurant-features/restaurant-features.php` | `features` | `have_rows: current post/block` | 34, 36 |
| `blocks/restaurant-features/restaurant-features.php` | `image` | `get_sub_field: active repeater` | 40 |
| `blocks/restaurant-features/restaurant-features.php` | `title` | `get_sub_field: active repeater` | 38 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | `button_text` | `get_sub_field: active repeater` | 89 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | `carousel_images` | `have_rows: current post/block` | 36, 37 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | `hero_button_details` | `have_rows: current post/block` | 85, 86 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | `image` | `get_sub_field: active repeater` | 39 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | `link` | `get_sub_field: active repeater` | 90 |
| `blocks/slider-type-1/slider-type-1.php` | `button_link` | `get_sub_field: active repeater` | 43 |
| `blocks/slider-type-1/slider-type-1.php` | `button_text` | `get_sub_field: active repeater` | 42 |
| `blocks/slider-type-1/slider-type-1.php` | `description` | `get_sub_field: active repeater` | 45 |
| `blocks/slider-type-1/slider-type-1.php` | `slider_content` | `have_rows: current post/block` | 36, 39 |
| `blocks/slider-type-1/slider-type-1.php` | `thumbnail` | `get_sub_field: active repeater` | 44 |
| `blocks/slider-type-1/slider-type-1.php` | `title` | `get_sub_field: active repeater` | 41 |
| `blocks/tab-block/tab-block.php` | `button_link` | `get_sub_field: active repeater` | 130 |
| `blocks/tab-block/tab-block.php` | `button_text` | `get_sub_field: active repeater` | 129 |
| `blocks/tab-block/tab-block.php` | `description` | `get_sub_field: active repeater` | 132 |
| `blocks/tab-block/tab-block.php` | `label_for_tab` | `get_field: current post/block` | 37 |
| `blocks/tab-block/tab-block.php` | `slide` | `have_rows: current post/block` | 120, 126 |
| `blocks/tab-block/tab-block.php` | `slide_title` | `get_sub_field: active repeater` | 128 |
| `blocks/tab-block/tab-block.php` | `slider_section` | `have_rows: current post/block` | 98, 99 |
| `blocks/tab-block/tab-block.php` | `slider_section_description` | `get_sub_field: active repeater` | 102 |
| `blocks/tab-block/tab-block.php` | `slider_section_title` | `get_sub_field: active repeater` | 101 |
| `blocks/tab-block/tab-block.php` | `tab_details` | `have_rows: current post/block` | 46, 48, 71, 73, 94, 96 |
| `blocks/tab-block/tab-block.php` | `tab_name` | `get_sub_field: active repeater` | 50, 75 |
| `blocks/tab-block/tab-block.php` | `thumbnail` | `get_sub_field: active repeater` | 131 |
| `footer.php` | `address` | `the_field: 'options'` | 35 |
| `footer.php` | `icon` | `get_sub_field: active repeater` | 42 |
| `footer.php` | `link` | `get_sub_field: active repeater` | 45 |
| `footer.php` | `social_media` | `have_rows: 'options'` | 37, 40 |
| `footer.php` | `subscribe_title` | `get_field: 'option'` | 13 |
| `single-activity.php` | `activity_icon` | `get_field: current post/block` | 114 |
| `single-activity.php` | `age_group` | `get_field: $activity_id` | 152 |
| `single-activity.php` | `benefits` | `have_rows: 'option'` | 498, 499 |
| `single-activity.php` | `button_link` | `get_field: current post/block` | 126 |
| `single-activity.php` | `description` | `get_field: $specialId; get_sub_field: active repeater` | 278, 502 |
| `single-activity.php` | `description_for_host_event` | `get_field: current post/block` | 194 |
| `single-activity.php` | `description_for_member_benefits` | `get_field: 'option'` | 479 |
| `single-activity.php` | `duration` | `get_field: $activity_id` | 149 |
| `single-activity.php` | `event_color` | `get_field: $id` | 416 |
| `single-activity.php` | `event_date` | `get_field: $id` | 411 |
| `single-activity.php` | `event_description` | `get_field: $id` | 415 |
| `single-activity.php` | `event_name` | `get_sub_field: active repeater` | 211 |
| `single-activity.php` | `events_for_the_activity` | `have_rows: current post/block` | 187, 209 |
| `single-activity.php` | `events_section_button_text` | `get_field: 'options'` | 371 |
| `single-activity.php` | `events_section_title` | `get_field: 'options'` | 370 |
| `single-activity.php` | `icon` | `get_sub_field: active repeater` | 212 |
| `single-activity.php` | `image` | `get_field: $term; get_sub_field: active repeater` | 11, 168, 503 |
| `single-activity.php` | `images_for_slider` | `have_rows: current post/block` | 165, 166 |
| `single-activity.php` | `link` | `get_sub_field: active repeater` | 213 |
| `single-activity.php` | `location_color` | `get_field: $term` | 12 |
| `single-activity.php` | `location_icon` | `the_field: $term` | 24, 31 |
| `single-activity.php` | `maximum_players` | `get_field: $activity_id` | 155 |
| `single-activity.php` | `member_benefits_button_text` | `get_field: 'option'` | 480 |
| `single-activity.php` | `offer_end_date` | `get_field: $specialId` | 281 |
| `single-activity.php` | `offer_start_date` | `get_field: $specialId` | 280 |
| `single-activity.php` | `price` | `get_field: $activity_id` | 146 |
| `single-activity.php` | `specials_section_image` | `get_field: 'options'` | 255 |
| `single-activity.php` | `specials_section_title` | `get_field: 'options'` | 254 |
| `single-activity.php` | `subtitle` | `get_field: $specialId` | 277 |
| `single-activity.php` | `tab_icon` | `get_field: current post/block` | 85 |
| `single-activity.php` | `thumbnail_image` | `get_field: $specialId` | 275 |
| `single-activity.php` | `title` | `get_field: $specialId; get_sub_field: active repeater` | 276, 501 |
| `single-activity.php` | `title_for_host_this_activity` | `get_field: current post/block` | 193 |
| `single-activity.php` | `title_for_member_benefits` | `get_field: 'option'` | 478 |
| `taxonomy-location.php` | `activity_icon` | `get_field: current post/block` | 144 |
| `taxonomy-location.php` | `age_group` | `get_field: $id` | 176 |
| `taxonomy-location.php` | `benefits` | `have_rows: 'option'` | 455, 456 |
| `taxonomy-location.php` | `description` | `get_sub_field: active repeater` | 273, 459 |
| `taxonomy-location.php` | `description_for_member_benefits` | `get_field: 'option'` | 436 |
| `taxonomy-location.php` | `duration` | `get_field: $id` | 172 |
| `taxonomy-location.php` | `event_color` | `get_field: $id` | 377 |
| `taxonomy-location.php` | `event_date` | `get_field: $id` | 372 |
| `taxonomy-location.php` | `event_description` | `get_field: $id` | 376 |
| `taxonomy-location.php` | `event_icon` | `get_field: $event->ID` | 237 |
| `taxonomy-location.php` | `image` | `get_sub_field: active repeater` | 194, 270, 460 |
| `taxonomy-location.php` | `images_for_slider` | `have_rows: current post/block` | 191, 192 |
| `taxonomy-location.php` | `location_color` | `get_field: $term` | 4 |
| `taxonomy-location.php` | `location_icon` | `the_field: $term` | 13, 24 |
| `taxonomy-location.php` | `maximum_players` | `get_field: $id` | 181 |
| `taxonomy-location.php` | `member_benefits_button_text` | `get_field: 'option'` | 437 |
| `taxonomy-location.php` | `offer_end_date` | `get_sub_field: active repeater` | 276 |
| `taxonomy-location.php` | `offer_starting_date` | `get_sub_field: active repeater` | 275 |
| `taxonomy-location.php` | `offers_at_play` | `have_rows: 'option'` | 267, 268 |
| `taxonomy-location.php` | `price` | `get_field: $id` | 169 |
| `taxonomy-location.php` | `subtitle` | `get_sub_field: active repeater` | 272 |
| `taxonomy-location.php` | `tab_icon` | `get_field: current post/block` | 91 |
| `taxonomy-location.php` | `title` | `get_field: $event->ID; get_sub_field: active repeater` | 242, 271, 458 |
| `taxonomy-location.php` | `title_for_member_benefits` | `get_field: 'option'` | 435 |
| `template-create-event.php` | `activities` | `get_field: $id` | 49 |
| `template-create-event.php` | `entertainment` | `get_field: $id` | 77 |
| `template-create-event.php` | `facilities` | `have_rows: current post/block` | 137, 138 |
| `template-create-event.php` | `facility` | `get_sub_field: active repeater` | 142 |
| `template-create-event.php` | `food_and_beverages` | `get_field: $id` | 110 |
| `template-create-event.php` | `image_for_facility` | `get_sub_field: active repeater` | 144 |
| `template-create-event.php` | `name` | `get_sub_field: active repeater` | 175 |
| `template-create-event.php` | `select_an_age_group` | `get_field: current post/block` | 51 |
| `template-create-event.php` | `spaces` | `get_field: $id` | 27 |
| `template-create-event.php` | `stories` | `have_rows: current post/block` | 169, 170 |
| `template-create-event.php` | `story_user_name` | `get_sub_field: active repeater` | 178 |
| `template-create-event.php` | `story_video` | `get_sub_field: active repeater` | 181 |

### Interpretation notes

- No local ACF JSON/PHP definitions. No flexible_content, relationship or native gallery types in the snapshot. Gallery is a repeater; related posts use post_object.
- Accordion fields organize the editor, not frontend components.
- THEME-AUDIT explains the verified sub_text/subtitle/url, tab_icon, location image, coach description, academy selection/link/logo, story-video and select_an_age_group mismatches.
- Hero queries activity_order directly as term meta; it is not defined in the location ACF group.
- Common Settings contains children under a text sub_title record; validate in the editor before treating that as a legitimate nested repeater.


## Theme hooks and filters

Theme registrations only; standard wp_head/wp_footer template calls and plugin hooks are separate.

| File | Registration | Line |
| --- | --- | --- |
| `functions.php` | `add_action('wp_head', 'hook_css');` | 21 |
| `functions.php` | `add_action('wp_enqueue_scripts', 'matsio_front_end');` | 43 |
| `functions.php` | `add_action('init', 'register_menus');` | 68 |
| `functions.php` | `add_action('wp_enqueue_scripts', 'dequeue_dashicons');` | 120 |
| `functions.php` | `add_filter('the_content', 'add_lazy_loading_attribute');` | 125 |
| `functions.php` | `add_filter('post_thumbnail_html', 'add_lazy_loading_attribute');` | 126 |
| `functions.php` | `add_filter('get_avatar', 'add_lazy_loading_attribute');` | 127 |
| `inc/block-management.php` | `add_action('init', 'register_acf_blocks');` | 3 |
| `inc/block-management.php` | `add_filter('should_load_separate_core_block_assets', '__return_true');` | 27 |
| `inc/matsio.php` | `add_action('after_setup_theme', 'matsio_thumbnail_support');` | 3 |
| `inc/matsio.php` | `add_action('login_head', 'matsio_login_branding');` | 12 |
| `inc/matsio.php` | `add_action('wp_print_footer_scripts', 'matsio_skip_link_focus_fix');` | 70 |
| `inc/matsio.php` | `add_filter('wpseo_metabox_prio', 'matsio_yoasttobottom');` | 85 |
| `inc/matsio.php` | `add_filter('admin_footer_text', 'matsio_footer_branding');` | 92 |
| `inc/matsio.php` | `add_action('wp_dashboard_setup', 'matsio_wpc_add_dashboard_widgets');` | 108 |
| `inc/matsio.php` | `add_filter('login_headertitle', 'matsio_change_title_on_logo');` | 115 |
| `inc/matsio.php` | `add_action('admin_init', 'matsio_remove_dashboard_meta');` | 131 |
| `inc/matsio.php` | `add_action('widgets_init', 'matsio_remove_default_widgets', 11);` | 147 |
| `inc/matsio.php` | `add_filter('login_headerurl', 'matsio_loginpage_custom_link');` | 154 |
| `inc/matsio.php` | `add_action('after_switch_theme', 'matsio_update_default_image_size', 10, 2);` | 166 |

## Queries and interactions

| Owner | Query / behavior |
| --- | --- |
| single-activity.php | Two sibling activity WP_Query calls by location/menu_order; all matching specials/events via serialized activities meta LIKE. |
| taxonomy-location.php | Repeated term activity queries for tabs/select/content; latest three host-event cards; all-event carousel; options offers/benefits. |
| hero-slider.php | All locations ordered through activity_order meta, then one activity query per term for View All. |
| academies-tab.php | All academies by menu_order, grouped in PHP by age_group. |
| archive-event / archive-restaurant | get_posts by publication date; default post limit, no explicit pagination; displayed count from main query. |
| coming-events.php | Existence WP_Query uses numberposts rather than WP_Query posts_per_page; selected post objects or all events inside. No upcoming date filter. |
| events.php / offers-slider.php | Selected/all events; all specials respectively. |
| cusine.php | get_terms(cusine), hide_empty false; term/post identity issue. |
| js/index.js | Slick activity/story/offer/event carousels; GLightbox; legacy GET load-more; age checkboxes; legacy event filter; mobile Mega Menu; location tabs/hash; sibling mobile navigation; optional form section. |
| hero-slider.js | Timed panels, hover/mobile controls and progress animation; hover-out scope defect. |
| date-picker.js | jQuery UI datepicker + native Date weekday matching, no availability API. |
| academies-tab.js | Age tabs/select and wraparound prev/next. |
| event-spaces.js / tab-block.js | Tab/select synchronization + Slick; global IDs constrain repeated instances. |
| offers-slider.js | Slick and dynamic padding/listeners. |
| coaches / gallery-slider / single-page-hero-carousel / slider-type-1 / pre-packed-fun / bottom-image-scroll JS | Slick setup; arrows/width/autoplay vary by block and viewport. |
| event-scroll / home SCSS | CSS marquees; event-scroll JS has no behavior. |

## Styling source map

Global screen.scss imports 25 partials. ptr() returns pixels unchanged; mobile max-width 1023px, desktop min-width 1024px. Counts include comments/vendor text.

| SCSS | Lines | Literal !important | Role |
| --- | --- | --- | --- |
| `scss/_archive-academies.scss` | 16 | 0 | Page styles: archive-academies |
| `scss/_archive-activity.scss` | 66 | 0 | Page styles: archive-activity |
| `scss/_archive-event.scss` | 30 | 0 | Page styles: archive-event |
| `scss/_archive-restaurant.scss` | 54 | 0 | Page styles: archive-restaurant |
| `scss/_catering-page.scss` | 19 | 0 | Page styles: catering-page |
| `scss/_common.scss` | 284 | 3 | Typography, CTAs, pagers/event cards |
| `scss/_enquiry-form.scss` | 299 | 2 | Gravity Form wrappers/inputs/errors/optional section |
| `scss/_food-court-page.scss` | 14 | 0 | Page styles: food-court-page |
| `scss/_food-court.scss` | 87 | 0 | Page styles: food-court |
| `scss/_footer.scss` | 325 | 1 | Subscription/GF, expanded footer, lower footer |
| `scss/_glightbox.scss` | 1 | 25 | Bundled minified lightbox CSS |
| `scss/_hamburger-mobile.scss` | 66 | 0 | Mobile helper and hamburger |
| `scss/_header.scss` | 694 | 4 | Fixed header, Mega Menu desktop/mobile |
| `scss/_hero-slider.scss` | 171 | 0 | Location hero block |
| `scss/_home-new.scss` | 247 | 8 | Sleepover editor sections |
| `scss/_home.scss` | 413 | 3 | Home editor sections and marquee |
| `scss/_jquery-ui.scss` | 7 | 1 | Bundled datepicker CSS |
| `scss/_reset.scss` | 180 | 0 | Reset, body typography, containers/utilities |
| `scss/_single-academies.scss` | 71 | 0 | Page styles: single-academies |
| `scss/_single-activity.scss` | 1018 | 8 | Page styles: single-activity |
| `scss/_single-event.scss` | 135 | 0 | Page styles: single-event |
| `scss/_single-restaurant.scss` | 61 | 0 | Page styles: single-restaurant |
| `scss/_slick.scss` | 100 | 0 | Slick styling |
| `scss/_taxonomy-location.scss` | 1129 | 8 | Page styles: taxonomy-location |
| `scss/_variables.scss` | 45 | 0 | Tokens, fonts, ptr(), mobile/desktop |
| `scss/above-the-fold.scss` | 0 | 0 | Empty entry |
| `scss/screen.scss` | 25 | 0 | Global import entry |

Block SCSS is colocated as described in the inventory. Most use @import variables; newer sleepover blocks use @use. Generated CSS/maps must not be edited directly. event names CSS handles that are not registered by this theme.

Fonts: fonts/stylesheet.css (Helvetica Neue 500) and fonts/google.css (local Sora 300–700). Icons: local/inline SVG and term-field markup; no active icon-font import. Media content mainly lives in uploads outside the theme.

Large assets: img/playarena.png ≈4.06 MB, img/academy-screen.png ≈1.16 MB, screenshot.png ≈1.08 MB, src/screenshot.psd ≈1.99 MB. Not all are proven frontend transfers.


## Dependencies and storage

| Location | Responsibility |
| --- | --- |
| functions.php / inc/block-management.php | Enqueues and directory-driven block registration. |
| package.json | Gulp 4, Dart Sass/gulp-sass, Autoprefixer, sourcemaps, BrowserSync; unused JS build dependencies. No npm scripts. |
| gulpfile.js | css/blocks/default/watch; no JS build or production task; historical BrowserSync host without Local proxy. |
| package-lock.json / node_modules | Existing artifacts; lockfileVersion 3, lockfile gitignored. |
| wp_options.cptui_post_types / cptui_taxonomies | Six CPTs, three site taxonomies. |
| wp_posts acf-field-group / acf-field | Schema not exported in theme. |
| wp_posts / wp_postmeta | Core/block content, post relationships, booking URLs, templates, menu items. |
| wp_options / term metadata | Shared fields, menus/plugin configuration, location fields. |
| wp_gf_form / wp_gf_form_meta | Forms/configuration. Entry tables not needed for mapping. |
| wp_posts custom-css-js | Layout overrides and Meta purchase tracking outside versioned theme. |
| Plugin settings | WooCommerce, Site Kit, PixelYourSite, WPCode, FireBox and other behavior outside theme; audit classifies dependencies. |

## Source coverage

Custom executable/configuration source inspected; generated assets, fonts and images inventoried separately. node_modules treated as third-party dependencies.

| File | Lines | Bytes |
| --- | --- | --- |
| `404.php` | 1 | 1 |
| `archive-academies.php` | 24 | 1461 |
| `archive-event.php` | 97 | 3210 |
| `archive-restaurant.php` | 60 | 1593 |
| `blocks/academies-tab/academies-tab.php` | 184 | 7247 |
| `blocks/bottom-image-scroll/bottom-image-scroll.php` | 64 | 2529 |
| `blocks/coaches/coaches.php` | 100 | 3571 |
| `blocks/coming-events/coming-events.php` | 200 | 6634 |
| `blocks/cusine/cusine.php` | 72 | 2190 |
| `blocks/date-picker/date-picker.php` | 114 | 3298 |
| `blocks/event/event.php` | 34 | 1175 |
| `blocks/event-scroll/event-scroll.php` | 70 | 2649 |
| `blocks/event-spaces/event-spaces.php` | 175 | 5720 |
| `blocks/events/events.php` | 138 | 4138 |
| `blocks/featured-events/featured-events.php` | 90 | 3124 |
| `blocks/food-item-list/food-item-list.php` | 81 | 2747 |
| `blocks/gallery-slider/gallery-slider.php` | 75 | 2620 |
| `blocks/hero-slider/hero-slider.php` | 202 | 6007 |
| `blocks/hero-video/hero-video.php` | 53 | 1782 |
| `blocks/member-benefits/member-benefits.php` | 89 | 2851 |
| `blocks/membership/membership.php` | 34 | 1195 |
| `blocks/offers-slider/offers-slider.php` | 113 | 3929 |
| `blocks/pre-packed-fun/pre-packed-fun.php` | 61 | 1994 |
| `blocks/restaurant-features/restaurant-features.php` | 91 | 2896 |
| `blocks/sample-block/sample-block.php` | 33 | 1200 |
| `blocks/single-page-hero-carousel/single-page-hero-carousel.php` | 108 | 3662 |
| `blocks/slider-type-1/slider-type-1.php` | 106 | 3874 |
| `blocks/tab-block/tab-block.php` | 198 | 7892 |
| `footer.php` | 108 | 3088 |
| `front-page.php` | 3 | 71 |
| `functions.php` | 127 | 3358 |
| `header.php` | 69 | 2596 |
| `inc/block-management.php` | 27 | 983 |
| `inc/matsio.php` | 166 | 6070 |
| `index.php` | 3 | 71 |
| `parts/favicon.php` | 18 | 2131 |
| `single-academies.php` | 13 | 299 |
| `single-activity.php` | 533 | 18785 |
| `single-event.php` | 3 | 71 |
| `single-restaurant.php` | 12 | 298 |
| `taxonomy-location.php` | 490 | 13615 |
| `template-create-event.php` | 200 | 5610 |
| `template-events.php` | 7 | 111 |
| `style.css` | 8 | 195 |
| `gulpfile.js` | 131 | 3473 |
| `package.json` | 73 | 1707 |
| `js/index.js` | 387 | 10916 |
| `blocks/academies-tab/block.json` | 21 | 552 |
| `blocks/bottom-image-scroll/block.json` | 26 | 622 |
| `blocks/coaches/block.json` | 20 | 480 |
| `blocks/coming-events/block.json` | 21 | 552 |
| `blocks/cusine/block.json` | 20 | 472 |
| `blocks/date-picker/block.json` | 21 | 536 |
| `blocks/event/block.json` | 20 | 473 |
| `blocks/event-scroll/block.json` | 20 | 518 |
| `blocks/event-spaces/block.json` | 20 | 520 |
| `blocks/events/block.json` | 20 | 472 |
| `blocks/featured-events/block.json` | 21 | 568 |
| `blocks/food-item-list/block.json` | 20 | 536 |
| `blocks/gallery-slider/block.json` | 20 | 536 |
| `blocks/hero-slider/block.json` | 21 | 509 |
| `blocks/hero-video/block.json` | 20 | 504 |
| `blocks/member-benefits/block.json` | 21 | 568 |
| `blocks/membership/block.json` | 20 | 504 |
| `blocks/offers-slider/block.json` | 21 | 568 |
| `blocks/pre-packed-fun/block.json` | 21 | 557 |
| `blocks/restaurant-features/block.json` | 20 | 576 |
| `blocks/sample-block/block.json` | 16 | 420 |
| `blocks/single-page-hero-carousel/block.json` | 25 | 666 |
| `blocks/slider-type-1/block.json` | 20 | 528 |
| `blocks/tab-block/block.json` | 20 | 496 |
| `blocks/academies-tab/js/academies-tab.js` | 52 | 1708 |
| `blocks/bottom-image-scroll/js/bottom-image-scroll.js` | 9 | 204 |
| `blocks/coaches/js/coaches.js` | 27 | 687 |
| `blocks/coming-events/js/coming-events.js` | 27 | 695 |
| `blocks/cusine/js/cusine.js` | 3 | 48 |
| `blocks/date-picker/js/date-picker.js` | 37 | 1716 |
| `blocks/event/js/event.js` | 3 | 48 |
| `blocks/event-scroll/js/event-scroll.js` | 3 | 48 |
| `blocks/event-spaces/js/event-spaces.js` | 86 | 3025 |
| `blocks/events/js/events.js` | 3 | 48 |
| `blocks/featured-events/js/featured-events.js` | 3 | 48 |
| `blocks/food-item-list/js/food-item-list.js` | 3 | 48 |
| `blocks/gallery-slider/js/gallery-slider.js` | 27 | 698 |
| `blocks/hero-slider/js/hero-slider.js` | 70 | 2303 |
| `blocks/hero-video/js/hero-video.js` | 3 | 48 |
| `blocks/member-benefits/js/member-benefits.js` | 3 | 48 |
| `blocks/membership/js/membership.js` | 3 | 48 |
| `blocks/offers-slider/js/offers-slider.js` | 46 | 1405 |
| `blocks/pre-packed-fun/js/pre-packed-fun.js` | 17 | 329 |
| `blocks/restaurant-features/js/restaurant-features.js` | 3 | 48 |
| `blocks/sample-block/js/sample-block.js` | 3 | 78 |
| `blocks/single-page-hero-carousel/js/single-page-hero-carousel.js` | 29 | 729 |
| `blocks/slider-type-1/js/slider-type-1.js` | 27 | 698 |
| `blocks/tab-block/js/tab-block.js` | 111 | 4169 |
| `blocks/academies-tab/scss/academies-tab.scss` | 177 | 4517 |
| `blocks/bottom-image-scroll/scss/bottom-image-scroll.scss` | 109 | 2514 |
| `blocks/coaches/scss/coaches.scss` | 52 | 1257 |
| `blocks/coming-events/scss/coming-events.scss` | 117 | 2450 |
| `blocks/cusine/scss/cusine.scss` | 26 | 558 |
| `blocks/date-picker/scss/date-picker.scss` | 187 | 4457 |
| `blocks/event/scss/event.scss` | 9 | 122 |
| `blocks/event-scroll/scss/event-scroll.scss` | 63 | 1349 |
| `blocks/event-spaces/scss/event-spaces.scss` | 203 | 5073 |
| `blocks/events/scss/events.scss` | 139 | 3341 |
| `blocks/featured-events/scss/featured-events.scss` | 137 | 3073 |
| `blocks/food-item-list/scss/food-item-list.scss` | 68 | 1594 |
| `blocks/gallery-slider/scss/gallery-slider.scss` | 93 | 2035 |
| `blocks/hero-video/scss/hero-video.scss` | 12 | 200 |
| `blocks/member-benefits/scss/member-benefits.scss` | 128 | 3179 |
| `blocks/membership/scss/membership.scss` | 5 | 68 |
| `blocks/offers-slider/scss/offers-slider.scss` | 170 | 3701 |
| `blocks/pre-packed-fun/scss/pre-packed-fun.scss` | 239 | 5996 |
| `blocks/restaurant-features/scss/restaurant-features.scss` | 71 | 1686 |
| `blocks/sample-block/scss/sample-block.scss` | 11 | 119 |
| `blocks/single-page-hero-carousel/scss/single-page-hero-carousel.scss` | 64 | 1441 |
| `blocks/slider-type-1/scss/slider-type-1.scss` | 63 | 1518 |
| `blocks/tab-block/scss/tab-block.scss` | 173 | 4588 |
