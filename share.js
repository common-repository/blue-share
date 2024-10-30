function blue_share_twitter(id, url, title) {
	Dialog.info({ url:'/wp-content/plugins/blue-share/form.php?s=twitter',
		      options: { method:'get', parameters: {id: id, permalink: url, title: title}}},
		    { className:"alphacube",
		      width:400 });
}

function blue_share_twitter_post(id) {
	new Ajax.Updater({ success: 'bs-twitter-inner-' + id,
			   failure: 'bs-twitter-error-' + id },
			   '/wp-content/plugins/blue-share/submit.php?s=twitter',
			   { parameters: $('bs-twitter-form-'+id).serialize() });
}

function blue_share_delicious(id, url, title, tags) {
	Dialog.info({ url:'/wp-content/plugins/blue-share/form.php?s=delicious',
		      options: { method:'get',
				 parameters: {id: id, permalink: url, title: title, tags: tags}}},
		    { className:"alphacube",
		      width:400 });
}

function blue_share_delicious_post(id) {
	new Ajax.Updater({ success: 'bs-delicious-inner-' + id,
			   failure: 'bs-delicious-error-' + id },
			   '/wp-content/plugins/blue-share/submit.php?s=delicious',
			   { parameters: $('bs-delicious-form-'+id).serialize() });
}
