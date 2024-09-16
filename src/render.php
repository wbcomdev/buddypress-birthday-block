<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div <?php echo get_block_wrapper_attributes(); ?> >
	<div class="title">
		<h2><?php echo esc_html( $attributes['title'] ); ?></h2>
	</div>
</div>
<?php
