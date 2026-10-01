<?php
/* Register Blocks */
add_action('init', 'register_acf_blocks');
function register_acf_blocks() {
  /* Scan blocks directory */
  foreach (scandir(__DIR__ . '/../blocks') as $file) {
    if ($file !== '.' && $file !== '..') {
      /* Scan js directory within the block directory */
      if (is_dir(__DIR__ . '/../blocks/' . $file . '/js/')) {
        foreach (glob(__DIR__ . '/../blocks/' . $file . '/js/*.js') as $js) {
          /* Scan and register js files within the js directory */
          wp_register_script(
            basename($file) . '.js',
            get_stylesheet_directory_uri() . '/blocks/' . basename($file) . '/js/' . basename($js),
            [],
            DEP_VERSION,
            true
          );
        }
      }
      register_block_type(__DIR__ . '/../blocks/' . $file);
    }
  }
}

/* This allows the block scripts and styles to be isolated */
add_filter('should_load_separate_core_block_assets', '__return_true');