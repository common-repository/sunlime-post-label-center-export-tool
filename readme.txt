=== Post Label Center (PLC) Manager for WooCommerce ===
Contributors: sunlime
Donate link: https://www.sunlime.at/
Tags: plc, post, plc manager, post label center, woocommerce
Requires at least: 4.7
Tested up to: 6.3
Stable tag: 1.1.6
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin extends WooCommerce and allows exporting orders to the PLC-portal of the Austrian Post.

== Description ==

This plugin extends the basic WooCommerce features and adds a support for the PLC-Portal of Austrain Post. If an order is ready for delivery and the status is changed to PLC all data is submitted to the PLC manager.

The communication is done through a SOAP interface automatically and therefore no import export is required.

Important notice: Before the plugin can do its job a WSDL-endpoint, clientID, orgUnitId and orgUnitGUID is required, which can be retreived by the Austrian Post.

== Frequently Asked Questions ==

= In which countries does the plugin work? =

This plugin is best suited for customers of the Austrian Post, who use the PLC manger.

= Which prerequisites are necessary for using our plugin? =

WooCommerce has to be installed and also an account at the Austrian Post has to be there. You will get all required data like WSDL-endpoint, clientID, orgUnitId or orgUnitGUID from the Austrian Post directly. You will find more information on www.post.at

== Screenshots ==
1. It is possible to change sender address and all post label center related data through the options page. Additionally it is possible to select for each country a standard package type and standard customs options.
2. The customs options can be set also for each product individually.

== Changelog ==

= 1.1.6 =
* checked version & minor updates

= 1.1.5 =
* added translations

= 1.1.4 =
* PHP 8.1 compatibility check and added option to automatically move order to completed, when sent to plc successfully.

= 1.1.3 =
* Bug fix if one of the customs options is not set

= 1.1.2 =
* Made it possible to set packet type on product layer

= 1.1.1 =
* Removing whitespaces before and after PLC settings

= 1.1.0 =
* Made it possible to communicate with PLC without entering customs options

= 1.0.2 =
* Changed readme.txt a bit and added austrian translation

= 1.0.1 =
* Added new languages

= 1.0.0 =
* Initial release

