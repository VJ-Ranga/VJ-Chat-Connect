=== VJ Chat Connect ===
Contributors: vjranga
Donate link: https://www.buymeacoffee.com/vjranga
Tags: woocommerce, whatsapp, order, button, chat
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://github.com/VJ-Ranga/VJ-Chat-Connect

Adds a "Order via WhatsApp" button to WooCommerce products, allowing customers to send order details directly to your WhatsApp number.

== Description ==

VJ Chat Connect adds beautiful, customizable chat and order buttons to your site, letting customers contact you quickly with pre-filled details.

= Key Features =

* **One-Click Ordering:** Customers can order instantly without a complex checkout process
* **Fully Customizable Message:** Change every label (Product, Price, Quantity, Total, Link)
* **Custom Icons:** Use any emoji or text for message lines (🛒, 💰, 🔗, etc.)
* **Smart Data Capture:** Automatically captures product name, price, selected variations, and product URL
* **Live Preview:** Real-time preview in the admin dashboard
* **Modern Admin UI:** Clean tabbed interface with responsive sidebar preview
* **Mobile Optimized:** Fully responsive on all devices
* **Design Customization:** Customize colors, padding, border radius, and more
* **Separate Compact Mode Settings:** Independent design options for Standard and Compact button styles
* **Floating Button:** Fixed position button option with customizable placement
* **Shortcode Support:** Use `[vj_chat_order_button]` to place button anywhere

= Example Message =

When customers click the button, they'll send a message like this:

`
Hello, I'd like to place an order:

🛒 Product: Men's Classic T-Shirt
🔢 Quantity: 2
💰 Price: $25.00
💵 Total: $50.00
🔗 Link: https://yourstore.com/product/t-shirt
`

= Perfect For =

* WooCommerce stores looking to increase conversions
* Businesses that prefer direct communication with customers
* Stores selling custom or high-value products
* International stores using WhatsApp as primary communication

= Requirements =

* WordPress 5.8 or higher
* WooCommerce 5.0 or higher
* PHP 7.4 or higher

== Installation ==

1. Upload the `vj-chat-order` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **Settings > Chat Connect** to configure your number and customize the button
4. The button will automatically appear on all WooCommerce product pages

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes, this plugin requires WooCommerce to be installed and activated.

= What format should I use for the phone number? =

Enter your WhatsApp number with country code, without the + sign or spaces. Example: 947000000000 (Sri Lanka number)

= Can I customize the button design? =

Yes! You can customize colors, size, padding, border radius, and more from the Design tab in settings.

= Can I change the message text and icons? =

Absolutely! Go to the Message tab to customize labels and add emojis or custom icons for each field.

= Does this work with variable products? =

Yes! The plugin automatically detects and includes selected variations (like size, color) in the WhatsApp message.

= Will this work with my theme? =

Yes, the plugin is designed to work with any WordPress theme. It includes special support for sticky add-to-cart bars (like Astra theme).

= Can I use custom icons? =

Yes, you can upload your own icon or use emojis. Use Win + . (Windows) or Cmd + Ctrl + Space (Mac) to insert emojis.

== Screenshots ==

1. Standard button on product page (frontend)
2. Live Preview in admin sidebar
3. General settings tab
4. Placement Configuration - Floating mode
5. Message customization tab
6. Design settings - Standard button
7. Design settings - Compact button
8. Example WhatsApp message output
9. Compact button on product page (frontend)

== Changelog ==

= 2.1.0 =
* NEW: Improved button position setting with reliable theme-specific WooCommerce hooks
* NEW: "After Add to Cart Button" position now works correctly with Astra and all themes
* NEW: CSS fixes for "Before Category" position to display button on its own line
* Enhancement: Changed hook registration from plugins_loaded to init for better compatibility
* Fix: Button no longer appears inline with category text in Astra theme

= 2.0.0 =
* NEW: Completely separated design settings for Standard and Compact button modes
* NEW: Independent color customization for Compact mode (Background, Icon, Hover)
* NEW: Customizable Compact button size and icon size
* NEW: Floating button placement with position and offset controls
* NEW: Shortcode support `[vj_chat_order_button]`
* Enhancement: Improved admin UI with grouped design settings
* Enhancement: Live preview updates for all design changes
* Enhancement: Better code organization and cleanup
* Fix: Removed stray code artifacts from admin settings

= 1.4.0 =
* Rename: Plugin officially renamed to "VJ Chat Connect".
* Performance: Optimized uninstall process with direct SQL deletion.

= 1.3.0 =
* Feature: Added helpful "Pro Tip" box for using emojis in message labels
* Enhancement: Added direct link to Emojipedia for finding icons
* Enhancement: UI improvements for labels section
* Improvement: Better user experience with emoji suggestions

= 1.2.0 =
* Fix: Solved double "Settings saved" notification issue
* Fix: Corrected settings link slug mismatch
* Enhancement: Added icon uploader validation and preview improvements
* Enhancement: Added frontend data validation for stability
* Enhancement: Optimized performance with lazy loading for admin images

= 1.0.0 =
* Initial release
* Basic WhatsApp order functionality
* Customizable button and message
* Design customization options
* Live preview feature

== Upgrade Notice ==

= 2.0.0 =
Major update with separated design settings for Standard and Compact modes. Adds floating button support and shortcode placement.

= 1.4.0 =
Plugin renamed to "VJ Chat Connect". Includes performance optimization.

= 1.3.0 =
This version adds helpful emoji tips and improves the user interface. Safe to update.

= 1.2.0 =
Important bug fixes for admin notifications and improved stability. Recommended update.

== Privacy Policy ==

VJ Chat Connect does not collect, store, or transmit any user data. All order information is sent directly from the customer's device to the selected chat app.

== Support ==

For support, please visit the plugin's support forum on WordPress.org or contact us through our website.

== Credits ==

Developed by VJ Ranga
WhatsApp icon by Font Awesome (CC BY 4.0)
