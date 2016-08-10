<?php
session_start();

// include required files form Facebook SDK 
require_once( 'libs/Facebook/Entities/AccessToken.php' );

// added in v4.0.5
require_once( 'libs/Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'libs/Facebook/HttpClients/FacebookCurl.php' );
require_once( 'libs/Facebook/HttpClients/FacebookCurlHttpClient.php' );
 
// added in v4.0.0
require_once( 'libs/Facebook/FacebookSession.php' );
require_once( 'libs/Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'libs/Facebook/FacebookRequest.php' );
require_once( 'libs/Facebook/FacebookResponse.php' );
require_once( 'libs/Facebook/FacebookSDKException.php' );
require_once( 'libs/Facebook/FacebookRequestException.php' );
require_once( 'libs/Facebook/FacebookPermissionException.php' );
require_once( 'libs/Facebook/FacebookOtherException.php' );
require_once( 'libs/Facebook/FacebookAuthorizationException.php' );
require_once( 'libs/Facebook/GraphObject.php' );
require_once( 'libs/Facebook/GraphSessionInfo.php' );
 
// added in v4.0.5
use Facebook\FacebookHttpable;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
 
// added in v4.0.0
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookPermissionException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;

//FACEBOOK
$app_id = 'xxxxxxxxxxx'; //APP ID
$secret = 'xxxxxxxxxxx'; //SECRET KEY
$redirect_uri = "https://xxxx.xxx"; //Valid OAuth Redirect URI

// init app with app id and secret
FacebookSession::setDefaultApplication($app_id, $secret);
 
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper($redirect_uri); //Replace the Valid OAuth redirect URIs
 
// see if a existing session exists
if(isset($_SESSION) && isset($_SESSION['fb_token'])){
  // create new session from saved access_token
  $session = new FacebookSession($_SESSION['fb_token']);
  // validate the access_token to make sure it's still valid
  try{
    if(!$session->validate()){
      $session = new FacebookSession($_SESSION['fb_token']);
    }
  }catch(Exception $e){
    // catch any exceptions
    $session = new FacebookSession($_SESSION['fb_token']);
  }
}
 
if(!isset( $session) || $session === null){
  // no session exists
  try{
    $session = $helper->getSessionFromRedirect();
  }catch(FacebookRequestException $ex) {
    // When Facebook returns an error
    // handle this better in production code
    print_r($ex);
  }catch(Exception $ex) {
    // When validation fails or other local issues
    // handle this better in production code
    print_r($ex);
  }
}

//IF FACEBOOK TOKEN ALREADY EXIST
if (isset($session)){

  	$_SESSION['fb_token'] = $session->getToken(); //Refresh New Token

  	//Page ID
  	$page_id = "XXXXXXXXXXXXX";

  	//GET ACCESS FROM FACEBOOK TO MANAGE FAN PAGE
  	$access_token = (new FacebookRequest($session, 'GET', '/'.$page_id, array('fields' => 'access_token')))->execute()->getGraphObject()->asArray();
	
  	// Save access token in variable for later use  
  	$access_token = $access_token['access_token'];

    //POST CONTENT
    $title = "Lorem ipsum"; //Title of Post
    $link = "http://edition.cnn.com/2016/08/08/sport/sun-yang-mack-horton-australia-china/index.html"; //Link
  	$message = "New post : ".$title." and you can read it here ".$link."!"; //Message
  	$picture = "https://placeholdit.imgix.net/~text?txtsize=33&txt=500%C3%97300&w=500&h=300"; //Picture

  	//PUBLISH TO FAN PAGE
  	$page_post = (new FacebookRequest($session, 'POST', '/'.$page_id.'/feed', 
      array('access_token' => $access_token,
      'name' => $title,
      'link' => $link,
      'picture' => $picture,
      'message' => $message,
    	)))->execute()->getGraphObject()->asArray();
}
 
//Generate Facebook Login Link with permission to post in fan page
$loginUrl = $helper->getLoginUrl(array('manage_pages', 'publish_pages'));
?>


<center>
<h1>Auto Facebook Publish as Page</h1>
<a type="button" class="btn btn-lg btn-block lgbtn" href="<?php echo $loginUrl; ?>">Refresh Token</a>
</center>
 
