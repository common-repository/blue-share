<?php
function twitter_form() {
	ob_start();
	?>
    	<div class="bs-form" id="bs-twitter-inner-[+id+]">
    	  <form id="bs-twitter-form-[+id+]" method="post">
	    <input type="hidden" name="title" value="[+title+]" />
	    <input type="hidden" name="permalink" value="[+permalink+]" />
	    <h2>Post to Twitter</h2>
            <p>
               <span class="bs-label">Twitter Username</span>
               <span class="bs-input"><input type="text" name="username"/></span>
            </p>
	    <div class="bs-clear"></div>
            <p>
               <span class="bs-label">Twitter Password</span>
               <span class="bs-input"><input type="password" name="password"/></span>
            </p>
	    <div class="bs-clear"></div>
            <p><span id='bs-twitter-error-[+id+]' class="bs-error">&nbsp;</span></p>
	    <div class="bs-buttons">
              <input type="button"
	             value="Post" onclick="blue_share_twitter_post('[+id+]');" />
              <input type="button"
	             value="Cancel" onclick="Dialog.closeInfo();" />
	    </div>
    	  <form>
	</div>
	<?php
	$t = ob_get_contents();
	ob_end_clean();
	return $t;
}

function delicious_form() {
	ob_start();
	?>
    	<div class="bs-form" id="bs-delicious-inner-[+id+]">
    	  <form id="bs-delicious-form-[+id+]" method="post">
	    <input type="hidden" name="title" value="[+title+]" />
	    <input type="hidden" name="permalink" value="[+permalink+]" />
	    <h2>Add to Del.icio.us</h2>
            <p>
               <span class="bs-label">Del.icio.us Username:</span>
               <span class="bs-input"><input type="text" name="username"/></span>
            </p>
	    <div class="bs-clear"></div>
            <p>
               <span class="bs-label">Del.icio.us Password:</span>
               <span class="bs-input"><input type="password" name="password"/></span>
            </p>
	    <div class="bs-clear"></div>
            <p>
               <span class="bs-label">Tags:</span>
               <span class="bs-input"><input type="text" name="tags" value='[+tags+]'/></span>
            </p>
	    <div class="bs-clear"></div>
            <p><span id='bs-delicious-error-[+id+]' class="bs-error">&nbsp;</span></p>
	    <div class="bs-buttons">
              <input type="button"
	             value="Post" onclick="blue_share_delicious_post('[+id+]');" />
              <input type="button"
	             value="Cancel" onclick="Dialog.closeInfo();" />
	    </div>
    	  <form>
	</div>
	<?php
	$t = ob_get_contents();
	ob_end_clean();
	return $t;
}

// Main script here
if (!isset($_GET['s'])) {
	header(header_string(400));
	echo "Something went badly wrong, sorry";
	return;
}
$id = isset($_GET['id']) ? $_GET['id'] : '';
$title = isset($_GET['title']) ? $_GET['title'] : '';
$permalink = isset($_GET['permalink']) ? $_GET['permalink'] : '';
$tags = isset($_GET['tags']) ? $_GET['tags'] : '';

// Some simple validation
if ((strpos($permalink, 'http://') !== 0) || ($title == '') || !is_numeric($id)) {
	header(header_string(400));
	echo "Something went badly wrong, sorry";
	return;
}

switch($_GET['s']) {
  case 'delicious':
	$html = delicious_form();
	break;
  case 'twitter':
	$html = twitter_form();
	break;
  default:
	header(header_string(400));
	echo "Unknown service " . $_GET['s'];
	break;
}

// Fill in the macros in the template form for this post
$html = str_replace('[+id+]', $id, $html);
$html = str_replace('[+title+]', $title, $html);
$html = str_replace('[+permalink+]', $permalink, $html);
$html = str_replace('[+tags+]', $tags, $html);
echo $html;
?>
