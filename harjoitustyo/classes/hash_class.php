<?php
class PasswordCrypt{
	function __construct(){}

	function BlowFishHash($input, $rounds = 7)
 	{
 		try{
	    $salt = "";
	    $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	    for($i=0; $i < 22; $i++) {
	      $salt .= $salt_chars[array_rand($salt_chars)];
    	}
    	return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
   		 }
   		 catch (Exception $e) {
			echo "tapahtui virhe".$e->getMessage();
		}
  	}
  	function EncryptBlowFish($password_entered, $password_hash){
  		try{
	  		if(crypt($password_entered, $password_hash) == $password_hash) {
	   			 return true;
	  		}
	  		else{
	  			return false;
	  		}
	  	}
	  	catch (Exception $e) {
			echo "tapahtui virhe".$e->getMessage();
		}
  	}
}
?>