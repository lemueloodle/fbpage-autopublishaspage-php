# Facebook Auto-Publish On Page using PHP SDK

------------------

### What does it do?
* Auto-Publish on Facebook Page as Page(not as personal account) in Facebook using PHP SDK
* Refresh Access Token Automatically
* Checks if Access Token already exist

------------------

### Replace the following

	$app_id = 'xxxxxxxxxxx'; //APP ID
	$secret = 'xxxxxxxxxxx'; //SECRET KEY
	$redirect_uri = "https://xxxx.xxx"; //Valid OAuth Redirect URI

	$page_id = "XXXXXXXXXXXXX";

	$title = "Lorem ipsum"; //Title of Post
	$link = "http://edition.cnn.com/2016/08/08/sport/sun-yang-mack-horton-australia-china/index.html"; //Link
	$message = "New post : ".$title." and you can read it here ".$link."!"; //Message
	$picture = "https://placeholdit.imgix.net/~text?txtsize=33&txt=500%C3%97300&w=500&h=300"; //Picture

### Facebook Permissions

	array('manage_pages', 'publish_pages')

<b>manage_pages</b> - Enables your app to retrieve Page Access Tokens for the Pages and Apps that the person administrates.

<b>publish_pages</b> - When you also have the manage_pages permission, gives your app the ability to post, comment and like as any of the Pages managed by a person using your app.

*Apps need both manage_pages and publish_pages to be able to publish as a Page.*

For more Facebbok API references go to: https://developers.facebook.com/docs/facebook-login/permissions

