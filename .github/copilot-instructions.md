# Generate Product Meta Description Plugin

WordPress/WooCommerce plugin that dynamically generates `<meta name="description">` tags for product pages using product title and attributes. Single-file architecture (`index.php`), minimal settings via `get_option()`.

**Plugin Slug:** `auto-product-meta-description`

## Architecture

- Hooks into `wp_head` via `add_product_meta_description()` function
- Requires WooCommerce (`wc_get_product()`, checks `class_exists('WooCommerce')`)
- Extracts product attributes (taxonomy and custom) as keywords
- Filters keywords that already appear in title to avoid repetition
- Falls back to product category when no keywords available

### Core Flow (see `index.php`)
1. Check `is_singular('product')` to target only product pages
2. Verify WooCommerce class exists
3. Get product attributes → build keywords array
4. Remove duplicates, apply exclusions, filter title words
5. Generate description with up to 5 keywords: `{title}: Find {keywords} and more.`
6. Fallback: `{title} - Discover our range of {category}.`
7. Output sanitized `<meta name="description">` tag

### Output Examples

**Case 1: With keywords (normal)**
- Title: `Blue Cotton T-Shirt`
- Attributes: Color=Blue, Material=Cotton, Size=Medium, Style=Casual
- Output: `Blue Cotton T-Shirt: Find medium, casual and more.`
- Note: "blue" and "cotton" filtered out (appear in title)

**Case 2: Category fallback (no usable keywords)**
- Title: `Premium Laptop Stand`
- Attributes: none or all filtered out
- Category: `Computer Accessories`
- Output: `Premium Laptop Stand - Discover our range of computer accessories.`

**Case 3: Generic fallback (no keywords or category)**
- Title: `Mystery Product`
- Attributes: none
- Category: none
- Output: `Mystery Product - Discover our range of products.`

### Edge Cases
- **All keywords in title**: Falls back to category description
- **Excluded keywords**: Removed before title filtering (via `excluded_meta_keywords` option)
- **More than 5 keywords**: Only first 5 are used after filtering
- **Duplicate attributes**: Deduplicated via `array_unique()`
- **WooCommerce inactive**: Function returns early, no output
- **Non-product pages**: Function returns early, no output

## Code Conventions

### Security Header (Required)
Every PHP file must start with ABSPATH check after plugin header:
```php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
```

### WordPress Coding Standards
- Use tabs for indentation, spaces around parentheses: `if ( $condition )`
- Run `phpcs --standard=WordPress index.php` before committing

### Naming
Use `product_meta_` or `add_product_meta_` prefix for any new functions/options.

### Existing Option
- `excluded_meta_keywords` - comma-separated string of keywords to exclude

## Version Updates

**Always update both files together:**
- `index.php` header: `Version: X.X.X`
- `readme.txt`: `Stable tag: X.X.X` and add changelog entry

Current version: `1.2`

## Potential Enhancements

Not yet implemented - add if requested:
- Admin settings page for `excluded_meta_keywords` option
- Character limit truncation (150-160 chars recommended for SEO)
- Product short description as alternative fallback
- Open Graph meta tags for social sharing
- Transient caching for generated descriptions
