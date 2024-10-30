=== LCS HTTPS ===
Plugin URI: http://www.latcomsystems.com/index.cfm?SheetIndex=wp_lcs_https
Contributors: latcomsystems
Tags: https,ssl,http,redirect,page,pages,specific,individual,secure
Requires at least: 3.0
Tested up to: 5.2
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/agpl-2.0.html

This plugin redirects specific pages to HTTPS. All other pages will remain HTTP.

== Description ==

This plugin allows specific pages to be forced to HTTPS.  All other pages will be redirected to HTTP.  

All unsecure local content (http://) on the redirected page will be changed to secure (https://) automatically.

== Installation ==

1. Download the latest zip file and extract the `lcs-image-nolink` directory.
2. Upload this directory inside your `/wp-content/plugins/` directory.
3. Activate 'LCS HTTPS' on the 'Plugins' menu in WordPress.
4. Specify pages that should be redirected to HTTPS in the Dashboard / Settings / LCS HTTPS options page.

== Frequently Asked Questions ==
= Will this slow down my site like some other HTTPS/SSL plugins (i.e. Wordpress HTTPS plugin)? =

No.  This plugin is extremely light and fast and the most it will do is issue a simple redirect if necessary, otherwise it adds virtually zero overhead processing.

= Can this plugin co-exist with other HTTPS plugins? =

We strongly suggest using only one HTTPS/SSL redirecting plugin, othersise you run the risk of endless redirects.

= I tried a different HTTPS plugin, and the styling of my HTTPS page(s) is completely messed up.  What about this plugin? =

This plugin automatically changes all local site HTTP references to HTTPS for stylesheets, scripts, and links and will preserve correct styling for the secure page.

== Screenshots ==

1. Options page.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
* Initial release.

== Support ==
* [sysdev@latcomsystems.com](mailto:sysdev@latcomsystems.com)
