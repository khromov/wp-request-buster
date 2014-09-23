<?php
/*
Plugin Name: Request Buster
Plugin URI:
Description: Find naughty plugins using wp_remote_ functions to slow your site down
Version: 2014.09.23
Author: khromov
Author URI: https://profiles.wordpress.org/khromov
License: GPL2
*/

$request_buster_requests = array();

/** Save the requests **/
add_filter('pre_http_request', function($false, $args, $url)
{
	//Useful thread: http://wordpress.stackexchange.com/questions/72529/filter-any-http-request-uri
	global $request_buster_requests;
	$request_buster_requests[] = array('args' => $args, 'url' => $url);

	return $false;
}, 10, 3);

add_action('wp_head', 'request_buster_head');
add_action('admin_head', 'request_buster_head');
function request_buster_head()
{
	?>
	<style type="text/css">
		#wp-admin-bar-admin-request-buster-main strong
		{
			font-weight: bold !important;
			color: red !important;
		}
	</style>
	<?php
};

add_action('admin_bar_menu', function($wp_admin_bar)
{
	global $request_buster_requests;
	$requests = sizeof($request_buster_requests);

	//Add main menu
	$main_bar = array(
		'id' => 'admin-request-buster-main',
		'title' => ('Request Buster' . (($requests > 0) ? " <strong>({$requests})</strong>" : "")),
		'href' => '#',
		'meta' => array(
			'class' => 'admin-request-buster'
		)
	);

	$wp_admin_bar->add_node($main_bar);

	foreach($request_buster_requests as $key => $request)
	{
		//Add sub menu
		$main_bar_sub = array(
			'id' => 'admin-request-buster-submenu-'.$key,
			'title' => $request['url'] . ' (' . $request['args']['method'] . ')',
			'href' => '#',
			'parent' => 'admin-request-buster-main'
		);

		$wp_admin_bar->add_node($main_bar_sub);
	}
}, 33);