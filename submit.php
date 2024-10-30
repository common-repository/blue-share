<?php
function header_string($code) {

	$s = array(100 => "Continue",
		   101 => "Switching Protocols",
		   200 => "OK",
		   201 => "Created",
		   202 => "Accepted",
		   203 => "Non-Authoritative Information",
		   204 => "No Content",
		   205 => "Reset Content",
		   206 => "Partial Content",
		   300 => "Multiple Choices",
		   301 => "Moved Permanently",
		   302 => "Found",
		   303 => "Moved Temporarily",
		   304 => "Not Modified",
		   305 => "Use Proxy",
		   306 => "(Unused)",
		   307 => "Temporary Redirect",
		   400 => "Bad Request",
		   401 => "Unauthorized",
		   402 => "Payment Required",
		   403 => "Forbidden",
		   404 => "Not Found",
		   405 => "Method Not Allowed",
		   406 => "Not Acceptable",
		   407 => "Proxy Authentication Required",
		   408 => "Request Timeout",
		   409 => "Conflict",
		   410 => "Gone",
		   411 => "Length Required",
		   412 => "Precondition Failed",
		   413 => "Request Entity Too Large",
		   414 => "Request-URI Too Long",
		   415 => "Unsupported Media Type",
		   416 => "Requested Range Not Satisfiable",
		   417 => "Expectation Failed",
		   500 => "Internal Server Error",
		   501 => "Not Implemented",
		   502 => "Bad Gateway",
		   503 => "Service Unavailable",
		   504 => "Gateway Timeout",
		   505 => "HTTP Version Not Supported");
	return isset($s[$code]) ? "HTTP/1.1 $code ".$s[$code] : "HTTP/1.1 $code Unknown";
}

function delicious($un, $pw, $title, $link, $tags) {

	$title = urlencode(stripslashes(urldecode($title)));
	$link = urlencode(stripslashes(urldecode($link)));
	$tags = urlencode(stripslashes(urldecode($tags)));

	$hst = "https://api.del.icio.us/v1/posts/add/?url=$link&description=$title&tags=$tags&replace=yes";
	$agn = "BlueShare/1.2 (http://www.bluedonkey.org/blueshare)";

	$crl = curl_init();
	curl_setopt($crl, CURLOPT_URL, $hst);
	curl_setopt($crl, CURLOPT_VERBOSE, false);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($crl, CURLOPT_USERAGENT, $agn);
	curl_setopt($crl, CURLOPT_USERPWD, "$un:$pw");
	curl_setopt($crl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($crl, CURLOPT_POST, false);
	$res = curl_exec($crl);
	$resinfo = curl_getinfo($crl);
	curl_close($crl);

	$code = $resinfo['http_code'];

	if($code == "200") {
		$r = array();
		if (preg_match('/<result code="([^"]*)"/', $res, $r) > 0) {
			$msg = $r[1];
		} else {
			$msg = "unknown problem";
		}
		if ($msg == 'done') {
			echo "<h2>Bookmark Added</h2><div class='bs-result'>" .
			     "<p>Bookmark successfully added to " .
			     "<a href='http://del.icio.us/$un'>$un's del.icio.us " .
			     "account</a></p></div>" .
			     "<div class='bs-close'><input type='button' " .
			     "onclick='Dialog.closeInfo();' value='Close'/><div>";
		} else {
			header(header_string(400));
			echo "Error adding bookmark to <a href='http://del.icio.us/$un'>$un's " .
			     "del.icio.us account</a>: $msg";
		}
	} else {
		header(header_string($code));
		echo "Error adding bookmark to <a href='http://del.icio.us/$un'>$un's " .
		     "del.icio.us account</a>.";
	}
}

function twitter($un, $pw, $title, $link) {

	$msg = urlencode(stripslashes(urldecode("$title - $link")));
	$src = "blueshare";
	$hst = "http://twitter.com/statuses/update.xml?status=$msg&source=$src";
	$agn = "BlueShare/1.0 (http://www.bluedonkey.org/blueshare)";

	$hdr = array('X-Twitter-Client' => 'Blue Share',
		     'X-Twitter-Client-Version' =>  '1.0',
		     'X-Twitter-Client-URL' => 'http://www.bluedonkey.org/blueshare');

	$crl = curl_init();
	curl_setopt($crl, CURLOPT_URL, $hst);
	curl_setopt($crl, CURLOPT_VERBOSE, false);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($crl, CURLOPT_USERAGENT, $agn);
	curl_setopt($crl, CURLOPT_HTTPHEADER, $hdr);
	curl_setopt($crl, CURLOPT_USERPWD, "$un:$pw");
	curl_setopt($crl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($crl, CURLOPT_POST, true);
	$res = curl_exec($crl);
	$resinfo = curl_getinfo($crl);
	curl_close($crl);

	$code = $resinfo['http_code'];

	if($code == "200") {
		echo "<h2>Update Posted</h2><div class='bs-result'>" .
		     "<p>Update successfully posted to <a href='http://twitter.com/" . $un .
		     "'>http://twitter.com/$un</a></p></div>" .
		     "<div class='bs-close'><input type='button' " .
		     "onclick='Dialog.closeInfo();' value='Close'/><div>";
	} else {
		header(header_string($code));
		echo "Error posting update to <a href='http://twitter.com/".$un."'>http://twitter.com/$un</a>";
	}
}

// Main script here

if (!isset($_GET['s'])) {
	header(header_string(400));
	echo "Something went badly wrong, sorry";
	return;
}

$title = isset($_POST['title']) ? $_POST['title'] : '';
$link = isset($_POST['permalink']) ? $_POST['permalink'] : '';
$user = isset($_POST['username']) ? $_POST['username'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';
$tags = isset($_POST['tags']) ? $_POST['tags'] : '';

// Some validation
if ((strpos($link, 'http://') !== 0) || ($title == '')) {
	header(header_string(400));
	echo "Something went badly wrong, sorry";
	return;
}
if (($user == '') || ($pass == '')) {
	header(header_string(400));
	echo "You must specify a username & password";
	return;
}

switch($_GET['s']) {
  case 'delicious':
	delicious($user, $pass, $title, $link, $tags);
	break;
  case 'twitter':
	twitter($user, $pass, $title, $link);
	break;
  default:
	header(header_string(400));
	echo "Unknown service " . $_GET['s'];
	break;
}
?>
