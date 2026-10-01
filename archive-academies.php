<?php get_header(); ?>
<div class="archive-academy-title-sec">
	<div class="wrap">
		<?php
		$academiesArchiveTitle = get_field('academies_listing_page_title', 'options');
		if ($academiesArchiveTitle) {
			?>
		<img src="https://playarena.in/wp-content/uploads/2024/09/coaching.png" class="academy_icon">	
		<h2>Up Your Game<!--<?php echo $academiesArchiveTitle ?>--></h2>
			<?Php
		}
		?>
	</div>
</div>
<?php
$block_content = '<!-- wp:acf/academies-tab {"name":"acf/academies-tab","data":{"academy_0_tab_name":"3 – 6 Years","_academy_0_tab_name":"field_66b1dde80bf37","academy_0_academy_list_0_academy":136,"_academy_0_academy_list_0_academy":"field_66b1e6b8948c9","academy_0_academy_list":1,"_academy_0_academy_list":"field_66b1e8d76b632","academy_1_tab_name":"6 – 13 Years","_academy_1_tab_name":"field_66b1dde80bf37","academy_1_academy_list_0_academy":136,"_academy_1_academy_list_0_academy":"field_66b1e6b8948c9","academy_1_academy_list_1_academy":133,"_academy_1_academy_list_1_academy":"field_66b1e6b8948c9","academy_1_academy_list":2,"_academy_1_academy_list":"field_66b1e8d76b632","academy":2,"_academy":"field_66b1dd700bf36","label_for_filter":"Select an Age Group to filter","_label_for_filter":"field_66b1eb52c8a88"},"mode":"edit"} /-->';
$parsed_blocks = parse_blocks($block_content);
$rendered_content = '';
foreach ($parsed_blocks as $block) {
	$rendered_content .= render_block($block);
}
echo $rendered_content;
?>
<?php get_footer(); ?>