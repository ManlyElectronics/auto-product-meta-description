=== Generate Product Meta Description ===
Contributors: dimitriaus
Tags: woocommerce, seo, meta description, product, attributes
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Dynamically generates meta description tags for WooCommerce product pages using product title and attributes.

== Description ==

Generate Product Meta Description automatically creates SEO-friendly `<meta name="description">` tags for your WooCommerce product pages. The plugin extracts product attributes (both taxonomy and custom) to build keyword-rich descriptions.

**Features:**

* Automatic meta description generation for all product pages
* Uses product title and attributes as keywords
* Supports both taxonomy and custom product attributes
* Keyword exclusion via WordPress option
* Lightweight single-file plugin
* No configuration required

**How it works:**

The plugin hooks into `wp_head` and builds the meta description through these steps:

1. **Extract Keywords** - Collects all product attribute values (both taxonomy attributes like Color/Size and custom attributes)
2. **Remove Duplicates** - Eliminates duplicate keywords
3. **Apply Exclusions** - Removes any keywords listed in the `excluded_meta_keywords` option
4. **Filter Title Words** - Removes keywords that already appear in the product title to avoid repetition
5. **Generate Description** - Combines title with up to 5 unique keywords

**Output formats:**

With keywords:
`Product Title: Find keyword1, keyword2, keyword3 and more.`

Without keywords (uses product category):
`Product Title - Discover our range of laptops.`

Without keywords or category:
`Product Title - Discover our range of products.`

**Example:**

* Title: "Blue Cotton T-Shirt"
* Attributes: Color=Blue, Material=Cotton, Size=Medium, Style=Casual
* Result: `Blue Cotton T-Shirt: Find medium, casual and more.`

(Note: "blue" and "cotton" are excluded because they appear in the title)

== Installation ==

1. Upload the `description` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin works automatically on all WooCommerce product pages

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes, this plugin requires WooCommerce to be installed and activated.

= How do I exclude certain keywords from the meta description? =

You can set the `excluded_meta_keywords` option in WordPress with a comma-separated list of keywords to exclude. Use the following code in your theme's functions.php or a custom plugin:

`update_option('excluded_meta_keywords', 'keyword1, keyword2, keyword3');`

= How many keywords are included in the description? =

The plugin includes up to 5 keywords from product attributes.

= Will this conflict with other SEO plugins? =

This plugin outputs a basic meta description tag. If you're using a comprehensive SEO plugin like Yoast or Rank Math, you may want to disable this plugin to avoid duplicate meta descriptions.

== Changelog ==

= 1.2 =
* Fixed duplicate keywords appearing in meta description
* Added filtering to exclude keywords that already appear in product title
* Improved fallback description to use product category when no keywords available
* Re-indexed keyword array after filtering for consistent output

= 1.1 =
* Added keyword exclusion support via excluded_meta_keywords option
* Improved attribute extraction for taxonomy and custom attributes
* Added fallback description when no attributes found

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.1 =
Added keyword exclusion feature and improved attribute handling.
