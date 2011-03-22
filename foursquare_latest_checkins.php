<?php
/*
Plugin Name: Latest Foursquare Checkins
Plugin URI: http://blog.no-panic.at/projects/foursquare-latest-checkins-wordpress-widget-plugin/
Description: Widget to display the users last Foursquare checkins
Version: 0.6
Author: Florian Beer
Author URI: http://blog.no-panic.at
*/

/*
    Copyright (c) 2011 Florian Beer - 42dev e. U. - http://42dev.eu

    This program is free software.

	You are free to:
	Share — to copy, distribute and transmit the work
	Remix — to adapt the work
	
	Under the following conditions:
	Noncommercial — You may not use this work for commercial purposes.
	Attribution — You must attribute the work in the manner
		specified by the author or licensor (but not in any way
		that suggests that they endorse you or your use of the work).
	Share Alike — If you alter, transform, or build upon this 
		work, you may distribute the resulting work only under the
		same or similar license to this one.

	http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY, without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

add_option('wp_foursquare_latest_checkins_username', '');
add_option('wp_foursquare_latest_checkins_password', '');
add_option('wp_foursquare_latest_checkins_count', intval(6));
add_option('wp_foursquare_latest_checkins_widget_title', 'Latest checkins');

function wp_foursquare_latest_checkins_widget() {
	$fq_username = get_option('wp_foursquare_latest_checkins_username');
	$fq_password = get_option('wp_foursquare_latest_checkins_password');
	$fq_count = get_option('wp_foursquare_latest_checkins_count');
	$fq_request	= 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20foursquare.history%20WHERE%20username%20%3D%20%22'.urlencode($fq_username).'%22%20AND%20password%20%3D%20%22'.urlencode($fq_password).'%22&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
	$fq_object = simplexml_load_file($fq_request);
	$i = 0;
	$html = '<ul id="foursquare_latest_checkins_widget">';
	foreach($fq_object->results->checkins->checkin as $checkin) {
		$i++;
		$html .= '<li>';
		if($checkin->venue->primarycategory->iconurl){
			$html .= '<a href="http://foursquare.com/venue/'.$checkin->venue->id.'"><img src="'.$checkin->venue->primarycategory->iconurl.'"></a> ';
		} else {
			$html .= '<a href="http://foursquare.com/venue/'.$checkin->venue->id.'"><img src="http://foursquare.com/img/categories/none.png"></a> ';
		}
		$html .= '<a href="http://foursquare.com/venue/'.$checkin->venue->id.'">'.$checkin->venue->name.'</a> </li>';
		if($i == $fq_count) break;
	}
	return $html . '</ul>';
}

function show_wp_foursquare_latest_checkins_widget($args) {
	extract($args);
	$wp_foursquare_latest_checkins_widget_title = get_option('wp_foursquare_latest_checkins_widget_title');
	echo $before_widget;
	echo $before_title . $wp_foursquare_latest_checkins_widget_title . $after_title;
    echo wp_foursquare_latest_checkins_widget();
    echo $after_widget;
}

function show_wp_foursquare_latest_checkins_widget_control() {
	if (isset($_POST['info_update'])) {
		update_option('wp_foursquare_latest_checkins_username', (string)$_POST['wp_foursquare_latest_checkins_username']);
		update_option('wp_foursquare_latest_checkins_password', (string)$_POST['wp_foursquare_latest_checkins_password']);
		update_option('wp_foursquare_latest_checkins_count', intval($_POST['wp_foursquare_latest_checkins_count']));
		update_option('wp_foursquare_latest_checkins_widget_title', (string)$_POST['wp_foursquare_latest_checkins_widget_title']);
	}
	?>
	<input type="hidden" name="info_update" value="true">
	<p>
 	<label for="wp_foursquare_latest_checkins_widget_title">Widget Title:</label>
	<input class="widefat"  name="wp_foursquare_latest_checkins_widget_title" id="wp_foursquare_latest_checkins_widget_title" type="text" value="<?php echo get_option('wp_foursquare_latest_checkins_widget_title'); ?>" />
	</p>
	<p>
 	<label for="wp_foursquare_latest_checkins_username">Foursquare Username:</label>
	<input class="widefat"  name="wp_foursquare_latest_checkins_username" id="wp_foursquare_latest_checkins_username" type="text" value="<?php echo get_option('wp_foursquare_latest_checkins_username'); ?>" />
	</p>
	<p>
 	<label for="wp_foursquare_latest_checkins_password">Foursquare Password:</label>
	<input class="widefat"  name="wp_foursquare_latest_checkins_password" id="wp_foursquare_latest_checkins_password" type="password" value="<?php echo get_option('wp_foursquare_latest_checkins_password'); ?>" />
	</p>
	<p>
 	<label for="wp_foursquare_latest_checkins_count">Number of checkins to show:</label>
	<input size="2" name="wp_foursquare_latest_checkins_count" id="wp_foursquare_latest_checkins_count" type="text" value="<?php echo get_option('wp_foursquare_latest_checkins_count'); ?>" />
	<?php
}

function widget_wp_foursquare_latest_checkins_init()
{
    $widget_options = array('classname' => 'widget_wp_foursquare_latest_checkins', 'description' => __( "Display last Foursquare checkins") );
    wp_register_sidebar_widget('wp_foursquare_latest_checkins_widgets', __('Foursquare Latest Checkins'), 'show_wp_foursquare_latest_checkins_widget', $widget_options);
    wp_register_widget_control('wp_foursquare_latest_checkins_widgets', __('Foursquare Latest Checkins'), 'show_wp_foursquare_latest_checkins_widget_control' );
}

add_action('init', 'widget_wp_foursquare_latest_checkins_init');