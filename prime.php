<?php

use google\appengine\api\users\UserService;
$user = UserService::getCurrentUser();

if (isset($user)) {
    echo sprintf('Welcome, %s! (<a href="%s">sign out</a>)',
        $user->getNickname(),
        UserService::createLogoutUrl('/'));
        showCode();
} else {
    echo sprintf('<a href="%s">Sign in or register</a>',
        UserService::createLoginUrl('/'));
}

function showCode(){
include ('html_form.html');

$obj = new Memcached();
$obj->addServer('localhost', 11211);
/* OLD
if (!isset($obj)){
	for ($i=1; $i<=1000; $i++){
		if (IsPrime($i) )
		$obj->set($i, $i);
	}
}
*/
if ($obj->get(1) == false){
	for ($i=1; $i<=1000; $i++){
		if (IsPrime($i) )
		$obj->set($i, $i);
	}
}


// Hey if you want to flush memcach, please uncomment this
//memcache_flush($obj);

$input = '';
if (isset ($_GET['input'] ) )
	$input = $_GET['input'];
else{
echo "welcome";
}

if (  $obj->get($input) != false ){
	echo $input." Prime stored IN Cache";
}
else{
	// is it in our range? if yes, then it's NOT prime bc it passed the prime test
	if ($input >= 1 && $input <=1000){ 
		echo $input." NOT a prime";
	}
	else{
		if (!$input){
			echo "<br>Please enter a number";
		}
		else if (IsPrime($input)){
			echo $input." Is prime Not in cache";
			$obj->set($input, $input);
		}
		else{
			echo $input." Is NOT prime";
		}
	}
}

}

function IsPrime($n)  {  
 for($x=2; $x<$n; $x++)  
   {  
      if($n %$x ==0){  
           return 0;  
          }  
    }  
  return 1;  
   }
?>
