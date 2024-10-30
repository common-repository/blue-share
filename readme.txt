=== blue-share ===
Contributors: bluedonkey
Tags: share, twitter, delicious
Requires at least: 2.5.1
Tested up to: 2.6
Stable tag: 1.2

A simple plug-in that allows readers to share the title and permalink for a post through a number of online services.

== Description ==

The plugin adds a set of iconic links to the bottom of each post that allows a reader to
share the title and the permalink for a post with their social network.

When one of the service icons is clicked, an overlay is opened allowing the reader to enter
their username and password for the online service they have selected. In some cases, additional
parameters will also be presented in the form (e.g. tags for Del.icio.us, pre-populated with
the post's tags).

== Installation ==

1. Upload the entire `blue-share` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php if(function_exists('blue_share')) { blue_share(); } ?>` in your templates

You will most likely want to add the link code to your `index.php`, `single.php` and `archive.php` files.

== Frequently Asked Questions ==

= What services does the plugin support? =

Currently, Twitter and Del.icio.us.

== Screenshots ==

TBD

== Other Notes ==

You may customise the look of the plugin by copying the `blue-share.css` file from the plugin
directory into your theme directory and then making whatever changes you desire there. The plugin
will always use the style sheet from the current theme in preference to its default.
