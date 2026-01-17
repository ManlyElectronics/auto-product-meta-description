# Generate Product Meta Description

[![WordPress Plugin Version](https://img.shields.io/badge/version-1.2-blue.svg)](https://github.com/ManlyElectronics/auto-product-meta-description)
[![License: GPL v2](https://img.shields.io/badge/License-GPL_v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-Required-96588a.svg)](https://woocommerce.com/)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-8892BF.svg)](https://php.net/)

A lightweight WordPress/WooCommerce plugin that dynamically generates SEO-friendly `<meta name="description">` tags for product pages using product title and attributes.

## Features

- **Automatic Setup** - Works after activation without configuration
- **Keyword Extraction** - Uses taxonomy and custom product attributes
- **Keyword Filtering** - Removes duplicates and keywords already in title
- **Keyword Exclusion** - Exclude specific keywords via WordPress option
- **Single-File Architecture** - Minimal code footprint
- **Category Fallback** - Uses product category when no keywords available

## Requirements

- WordPress 5.0+
- WooCommerce (active)
- PHP 7.4+

## Installation

### Manual Installation

1. Download the plugin files
2. Upload the `auto-product-meta-description` folder to `/wp-content/plugins/`
3. Activate the plugin through the **Plugins** menu in WordPress

### From GitHub

```bash
cd wp-content/plugins/
git clone https://github.com/ManlyElectronics/auto-product-meta-description.git
```

Then activate via WordPress admin.

## How It Works

The plugin hooks into `wp_head` and generates meta descriptions through these steps:

1. **Extract Keywords** - Collects all product attribute values (taxonomy + custom)
2. **Remove Duplicates** - Eliminates duplicate keywords via `array_unique()`
3. **Apply Exclusions** - Removes keywords from the `excluded_meta_keywords` option
4. **Filter Title Words** - Removes keywords already present in the product title
5. **Generate Description** - Combines title with up to 5 unique keywords

## Output Examples

### With Keywords (Normal)

| Field | Value |
|-------|-------|
| Title | Blue Cotton T-Shirt |
| Attributes | Color=Blue, Material=Cotton, Size=Medium, Style=Casual |
| **Output** | `Blue Cotton T-Shirt: Find medium, casual and more.` |

> Note: "blue" and "cotton" are filtered out because they appear in the title.

### Category Fallback (No Usable Keywords)

| Field | Value |
|-------|-------|
| Title | Premium Laptop Stand |
| Attributes | None or all filtered out |
| Category | Computer Accessories |
| **Output** | `Premium Laptop Stand - Discover our range of computer accessories.` |

### Generic Fallback (No Keywords or Category)

| Field | Value |
|-------|-------|
| Title | Mystery Product |
| **Output** | `Mystery Product - Discover our range of products.` |

## Configuration

### Excluding Keywords

To exclude specific keywords from meta descriptions, set the `excluded_meta_keywords` option:

```php
// In your theme's functions.php or a custom plugin
update_option( 'excluded_meta_keywords', 'keyword1, keyword2, keyword3' );
```

Or via WP-CLI:

```bash
wp option update excluded_meta_keywords "keyword1, keyword2, keyword3"
```

## FAQ

### Does this plugin require WooCommerce?

Yes, WooCommerce must be installed and activated. The plugin checks for `class_exists('WooCommerce')` before processing.

### How many keywords are included?

Up to 5 keywords after filtering.

### Will this conflict with other SEO plugins?

This plugin outputs a standard meta description tag. If you're using Yoast, Rank Math, or similar SEO plugins that also generate meta descriptions, you may want to disable this plugin to avoid duplicates.

### Does it work on non-product pages?

No, the plugin only targets WooCommerce product pages (`is_singular('product')`).

## Changelog

### 1.2
- Fixed duplicate keywords appearing in meta description
- Added filtering to exclude keywords already in product title
- Improved fallback description using product category
- Re-indexed keyword array after filtering

### 1.1
- Added keyword exclusion support via `excluded_meta_keywords` option
- Improved attribute extraction for taxonomy and custom attributes
- Added fallback description when no attributes found

### 1.0
- Initial release

## Contributing

Contributions are welcome! Please follow WordPress Coding Standards:

```bash
# Check coding standards
phpcs --standard=WordPress index.php
```

### Naming Conventions

- Use `product_meta_` or `add_product_meta_` prefix for new functions/options
- Follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)

## License

This project is licensed under the GPL v2 or later - see the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) file for details.

## Author

**Manly Electronics**  
[https://manlyelectronics.com.au](https://manlyelectronics.com.au)
