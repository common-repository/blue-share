<?php
/*
Plugin Name: Blue Share
Plugin URI: http://www.bluedonkey.org/
Description: Share a post to Twitter (and other similar sites)
Version: 1.2
Author: John Gordon
Author URI: http://www.bluedonkey.org/
*/

// Partly based on:
// Twitter This
// Copyright (c) 2007 Andres Scheffer
// http://www.artux.com.ar/

function blue_share_template() {
	ob_start();
	?>
	<span id="bs-[+id+]" class="blue-share">
    	    [+intro+]
	    <span class="bs-active" 
	      onclick="blue_share_twitter([+id+], '[+permalink+]', '[+title+]');">
              <img src="/wp-content/plugins/blue-share/images/twitter.gif" alt="Twitter" />
            </span>
	    <span class="bs-active"
	      onclick="blue_share_delicious([+id+], '[+permalink+]', '[+title+]', '[+tags+]');">
              <img src="/wp-content/plugins/blue-share/images/delicious.gif" alt="Delicious" />
            </span>
        </span>
	<?php
	$t = ob_get_contents();
	ob_end_clean();
	return $t;
}

function blue_share($intro='Share this:') {
    	global $wp_query;

    	$post = $wp_query->post;
    	$id = $post->ID;
    	$permalink = get_permalink($id);
    	$title = $post->post_title;
	$tags = wp_get_post_tags($id);

	if (is_array($tags)) {
		$t = array();
		foreach ($tags as $tag) {
			$t[] = str_replace(' ', '_', $tag->name);
		}
		$tags = implode(" ", $t);
	} else {
		$tags = '';
	}

	$html = blue_share_template();
	$html = str_replace('[+id+]', $id, $html);
	$html = str_replace('[+title+]', str_replace("'", "\'", $title), $html);
	$html = str_replace('[+permalink+]', $permalink, $html);
	$html = str_replace('[+tags+]', str_replace("'", "\'", $tags), $html);
	$html = str_replace('[+intro+]', $intro, $html);
    	echo $html;
}

function blue_share_header() {
?>
<!-- Added by Blue Share -->
<link type="text/css" href="/wp-content/plugins/blue-share/windows/default.css" rel="stylesheet" />
<link type="text/css" href="/wp-content/plugins/blue-share/windows/alphacube.css" rel="stylesheet" />
<?php
if (@file_exists(TEMPLATEPATH .'/blue-share.css')) {
	echo '<link type="text/css" href="'.get_stylesheet_directory_uri().'/blue-share.css" rel="stylesheet" />'."\n";
} else {
	echo '<link type="text/css" href="/wp-content/plugins/blue-share/blue-share.css" rel="stylesheet" />'."\n";
}
echo "<!-- End of Blue Share additions -->\n";
}

// Add the header lines to each page
add_action('wp_head', 'blue_share_header');

// Register the scripts we need
wp_enqueue_script('window', '/wp-content/plugins/blue-share/windows/window.js', array('prototype'), '1.3');
wp_enqueue_script('blue-share', '/wp-content/plugins/blue-share/share.js', array('window'), '1.0');
?>
