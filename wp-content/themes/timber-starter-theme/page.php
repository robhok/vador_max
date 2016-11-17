<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
// die(Timber::get_widgets('news-widgets'));
$context['news'] = Timber::get_widgets('news-widgets');
$context['asides_blocks'] = array(
  'left' => Timber::get_widgets('home-widgets'),
  'right' => get_field('right_block')
);
$image = get_field('image_fullscreen');
if ($image !== false && $image !== '' ) $context['image_fullscreen'] = new TimberImage($image);
/*$cover_image_id = $post->cover_image;
if ($cover_image_id !== false && $cover_image_id !== '' ) $context['cover_image'] = new TimberImage($cover_image_id);*/
$context['empire'] = new TimberPost('empire');


Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );
