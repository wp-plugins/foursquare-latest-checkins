=== Foursquare Latest Checkins ===
Contributors: beerf
Tags: foursquare, checkins, widget, sidebar
Requires at least: 3.0
Tested up to: 3.1
Donate Link: -
Stable Tag: trunk

Displays the users latest Foursquare checkins including venue icons as a sidebar widget.

== Description ==

Displays venue names and icons of the latest Foursquare checkins.
Requires Foursquare Username and Password filled out in the widget's settings.

== Installation ==

1. Upload `foursquare_latest_checkins.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Select where you would like the widget to be displayed under 'Widgets'

== Frequently Asked Questions ==

= How many checkins can I display? =

From what I found out, currently the API returns 18 checkins, but your number may vary.

= How do I style the widget using CSS? =

The widget spits out an unstylerd unorderd list with the id "foursquare_latest_checkins_widget"

== Screenshots ==

1. Example of the Widget in the Sidebar
2. Configuration

== Changelog ==

= 1.0 =
* Changed input field in Settings for item count to select tag
* Error handling if there is no Foursquare data or the history has no elements
* Show checkin time (selectable)

= 0.6 =
* First public release.

== Upgrade Notice ==
Upgrade through WordPress backend