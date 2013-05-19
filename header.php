<?php
	include("config.php");
	//define('IN_PHPBB', true);
	
	if(!defined("ROOT_PATH"))
	{
		$location = split("/", dirname($_SERVER['PHP_SELF']));
		$path = "";
		foreach($location as $loc)
			if($loc != "")
				$path .= "../";
        define('ROOT_PATH', $path . "phpBB");
	}
   	$phpEx = "php";
    $phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
    require_once($phpbb_root_path . 'common.' . $phpEx);
	global $user, $auth;
        
	$loggedIn = false;
	$user->session_begin();
	$auth->acl($user->data);
	if(!empty($_POST['naa_loginname']))
	{
	    $auth->login($_POST["naa_loginname"], $_POST["naa_password"], true, 1, 1);
	    print("<script type='text/javascript'>window.location.reload(true);</script>");
	    exit();
	}
	else
	{
	    $user->setup();
	}
	if ($user->data['user_id'] != ANONYMOUS)
	{
	    $loggedIn = true;
	    //logon wiki
	}
	$uri = (explode("?", $_SERVER['REQUEST_URI']));
	if($uri[0] == "/phpBB/ucp.php" && !empty($_GET["mode"]) && $_GET["mode"] == "logout")
	{
	    $user->session_kill();
	    $user->session_begin();
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
        	$parts = explode('=', $cookie);
	        $name = trim($parts[0]);
        	setcookie($name, '', time()-1000);
	        setcookie($name, '', time()-1000, '/');
	    }
	    print("<script type='text/javascript'>window.location='/';</script>");
            exit();
	}
?>
<link rel="stylesheet" tyle="text/css" href="/header.css" />
<div class="forumbg">
    <div class="inner"><span class="corners-top"><span></span></span>
    <div class="solidblockmenu">
        <ul>
            <li><a href="/phpBB" title="Forums">Forums</a></li>
            <li><a href="/wiki" title="Wiki">Wiki</a></li>
            <?php
                if($loggedIn)
				{
					if($user->data['loginname'] =="waterfoul" || $user->data['loginname'] == "MrWacko" || $user->data['loginname'] == "themastercheif92")
						print('<li><a href="/industry/index.php">Industry Calc</a></li>');
				}
			?>
	    	<?php global $extra; print($extra); ?>
            <?php
                if($loggedIn)
                {
                	print('<li><a href="/phpBB/ucp.php">Logged in as ' . $user->data['username'] . '</a></li>');
                    print('<li><a href="/phpBB/ucp.php?mode=logout" title="Logoff">Logoff</a></li>'); 
                }
                else
                {
                    print('<li><form method="post" action="">
                        <fieldset class="quick-login">
                            <div><label for="naa_loginname">Username:</label>&nbsp;<input type="text" name="naa_loginname" id="naa_loginname" size="10" class="inputbox" title="Username"></div>
                            <div><label for="naa_password">Password:</label>&nbsp;<input type="password" name="naa_password" id="naa_password" size="10" class="inputbox" title="Password"></div>
                            <input type="submit" name="login" value="Login" class="button2">
                            <input type="hidden" name="redirect" value="./index.php?">
                        </fieldset>
                    </form></li>');
                }
            ?>
        </ul>
    </div>
    <span class="corners-bottom"><span></span></span></div>
</div>
