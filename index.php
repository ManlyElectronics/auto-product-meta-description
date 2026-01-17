<?php
/**
 * Plugin Name: Generate Product Meta Description
 * Description: Dynamically generates a <meta name="description"> tag for WooCommerce product pages, using the product title and attributes.
 * Version: 1.2
 * Author: Manly Electronics
 * Author URI: https://manlyelectronics.com.au
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: auto-product-meta-description
 * Requires Plugins: woocommerce
 *
 * @package Auto_Product_Meta_Description
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_head', 'add_product_meta_description' );

/**
 * Add meta description to the head for WooCommerce product pages.
 */
function add_product_meta_description() {
	if ( is_singular( 'product' ) ) {
		global $post;

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$product = wc_get_product( $post->ID );
		if ( ! $product ) {
			return;
		}

		// Generate keywords (used for description building).
		$attributes = $product->get_attributes();

		$keywords = array();
		foreach ( $attributes as $attribute_name => $attribute ) {
			if ( $attribute->is_taxonomy() ) {
				$terms    = wp_get_post_terms( $post->ID, $attribute->get_name(), array( 'fields' => 'names' ) );
				$keywords = array_merge( $keywords, $terms );
			} else {
				$keywords = array_merge( $keywords, $attribute->get_options() );
			}
		}

		// Attempt to get the excluded keywords, fallback to empty array if not defined.
		$excluded_keywords = get_option( 'excluded_meta_keywords', '' );
		if ( ! is_string( $excluded_keywords ) ) {
			$excluded_keywords = ''; // Fallback if option is not set or invalid.
		}
		$excluded_keywords = array_map( 'trim', explode( ',', strtolower( $excluded_keywords ) ) );

		// Filter out excluded keywords and sanitize.
		$keywords = array_map( 'strtolower', array_map( 'esc_attr', $keywords ) );
		$keywords = array_unique( $keywords );
		$keywords = array_diff( $keywords, $excluded_keywords );
		$keywords = array_values( $keywords ); // Re-index array after filtering.

		// Generate title.
		$title = get_the_title( $post->ID );

		// Filter out keywords that appear anywhere in the title.
		$keywords = array_filter(
			$keywords,
			function ( $keyword ) use ( $title ) {
				return stripos( $title, $keyword ) === false;
			}
		);
		$keywords = array_values( $keywords );

		// Generate description using title and filtered keywords.
		$description = $title;
		if ( ! empty( $keywords ) ) {
			$description .= ': Find ' . implode( ', ', array_slice( $keywords, 0, 5 ) ) . ' and more.';
		} else {
			// Get product category for fallback description.
			$categories = wp_get_post_terms( $post->ID, 'product_cat', array( 'fields' => 'names' ) );
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				$category     = $categories[0];
				$description .= ' - Discover our range of ' . strtolower( $category ) . '.';
			} else {
				$description .= ' - Discover our range of products.';
			}
		}

		// Output meta description tag.
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . PHP_EOL;
	}
}
