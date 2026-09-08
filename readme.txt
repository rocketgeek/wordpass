=== WordPass ===
Contributors: cbutlerjr
Donate link: http://devbitz.com/plugins/
Tags: password, users, user, registration, security
Requires at least: 4.6.0
Tested up to: 7.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates word-based passwords for WordPress.

== Description ==

This plugin is a password generator that creates random passwords with using words, numbers, and special characters.

Default random passwords can be difficult to for users to use (and remember – if they don’t change it). WordPass simplifies this process by using words to create passwords.  Passwords will be generated in the style of 2*Kayak29, 2Bigcranium2#, or %36POTATOE6.

This plugin works with WordPress as well as with any plugin that uses the WordPress password generation function.

WordPass allows you to create a custom list of words to be used in password generation.

The plugin will create random passwords from your word list and apply numbers as well as capitalization.  How these settings are applied can be set in the plugin's settings.  The recommended setting is "random" for best security.

Note: this plugin is great for membership sites where subscribers or low level users need easy to remember passwords.  But you should use secure (and possibly more complex) passwords for higher level users, especially administrators.  Use common sense in the application of this plugin!

== Installation ==

To install the plugin manually:

1. Download the plugin zip package and upzip it.
2. Upload the `/wordpass/` to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

= Set up =

Once the plugin is installed and activated, it will begin working automatically with its default settings.

It is __highly__ recommended that you create a custom word list rather than rely on the defaults. Using a custom word list makes it much more difficult to crack passwords since the word list is not known.

Additionally, when choosing words for your word list, remember that "more is better."  More words and words of longer length are preferred.  Using words like "car," or "boat" are much less secure than words like "physiological."

Use common sense when developing your word list.  Don't use commonly used passwords in the word list.  Even though letter case can be randomized and numbers and special characters randomly added, it is still a bad idea to use commonly used passwords in your word list.

* http://www.passwordrandom.com/most-popular-passwords
* http://www.computerworld.com/article/3024404/security/worst-most-common-passwords-for-the-last-5-years.html

== Frequently Asked Questions ==

= Where are the settings? =

The plugin settings are under the Settings > WordPass menu in the WordPress admin.  You can choose the letter case for the word so that it will be all lowercase, all uppercase, first letter uppercase, or a random selection.

You are encouraged to enter your own custom word list.  But use common sense!  Don't use words that are common (see: http://www.passwordrandom.com/most-popular-passwords).

= What kind of passwords will be generated? =

The plugin uses the words in your word list to generate a random password consisting of one word, between one and three numbers, and possibly a special character.  These elements will be shuffled at random so that all the elements are randomly mixed.  Passwords will be generated like $kayak9, 22Cranium!, or 3#4POTATO6.

== Screenshots ==

1. Settings page.

== Changelog ==

= 1.0.2 =

* Replace use of `mt_rand()` with `wp_rand()`.
* Disallow direct file access in plugin files.
* Update uninstall to not use a direct db call (use `get_sites()` instead).
* Prefix nonglobal variables (in uninstall).
* Better escaping of output in admin.
* Required WP version is now 4.6.0.

= 1.0.1 =

* Replace invalid index.php.
* Sanitize input and escape echoed variable(s).

= 1.0 =

* Initial version.