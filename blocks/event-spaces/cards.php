<?php
/** Event-space cards, using the existing Gutenberg/ACF content. */
// ACF returns false for empty repeaters, including nested image and fact rows.
$repeater_rows = static function ($value) {
    return is_array($value) ? array_filter($value, 'is_array') : array();
};
$spaces = $repeater_rows(get_field('event_space_details'));
$card_set = wp_unique_id('event-spaces-');
$attachment_id = static function ($image) {
    return is_array($image) ? (int) ($image['ID'] ?? $image['id'] ?? 0) : (int) $image;
};
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?> event-space-cards">
  <div class="space-card-controls">
    <button type="button" class="space-card-prev" aria-label="Previous event spaces" aria-controls="<?php echo esc_attr($card_set); ?>">&#8592;</button>
    <button type="button" class="space-card-next" aria-label="Next event spaces" aria-controls="<?php echo esc_attr($card_set); ?>">&#8594;</button>
  </div>
  <div class="space-card-row" id="<?php echo esc_attr($card_set); ?>" role="region" aria-label="Event spaces" tabindex="0">
    <?php foreach ($spaces as $index => $space):
      $title = ($space['space_title'] ?? '') ?: ($space['tab_name'] ?? '');
      $stats = $repeater_rows($space['more_details_abouts_space'] ?? null);
      $photos = array();
      foreach ($repeater_rows($space['slider_images'] ?? null) as $photo) {
          $id = $attachment_id($photo['slider_image'] ?? 0);
          $url = $id ? wp_get_attachment_image_url($id, 'full') : false;
          if ($url) {
              $photos[] = array('id' => $id, 'url' => $url);
          }
      }
      $gallery = $card_set . '-gallery-' . $index;
      ?>
      <article class="space-card">
        <div class="space-card-visual">
        <?php if ($photos): ?>
          <?php echo wp_get_attachment_image($photos[0]['id'], 'large', false, array('class' => 'space-card-image', 'loading' => 'lazy')); ?>
        <?php endif; ?>
          <h3 class="space-card-title"><?php echo esc_html($title); ?></h3>
        </div>
        <div class="space-card-body">
          <dl class="space-card-stats">
            <?php foreach (array_slice($stats, 0, 4) as $stat): ?>
              <div class="space-card-stat">
                <dt><?php echo esc_html($stat['info_text'] ?? ''); ?></dt>
                <dd<?php echo strlen((string) ($stat['value'] ?? '')) > 8 ? ' class="space-stat-long"' : ''; ?>>
                  <?php if (($stat['value_type'] ?? '') === 'image'):
                    echo wp_get_attachment_image($attachment_id($stat['icon'] ?? 0), 'thumbnail', false, array('alt' => ''));
                  else:
                    echo esc_html($stat['value'] ?? '');
                  endif; ?>
                </dd>
              </div>
            <?php endforeach; ?>
          </dl>
          <div class="space-card-description"><?php echo wp_kses_post(wpautop($space['space_description'] ?? '')); ?></div>
          <?php if ($photos): ?>
            <a class="space-photo-link" href="<?php echo esc_url($photos[0]['url']); ?>" data-gallery="<?php echo esc_attr($gallery); ?>" data-title="<?php echo esc_attr($title); ?>" aria-label="<?php echo esc_attr('View photos of ' . $title); ?>">View Photos <span aria-hidden="true">&#8599;</span></a>
            <?php foreach (array_slice($photos, 1) as $photo): ?>
              <a class="space-photo-link" href="<?php echo esc_url($photo['url']); ?>" data-gallery="<?php echo esc_attr($gallery); ?>" data-title="<?php echo esc_attr($title); ?>" hidden tabindex="-1" aria-hidden="true"></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>
