<?php

class responses {
 
 // Static methods for uniformity, because sometimes we'll pass args into messages
  
  public static function redirect($url) {
  
    return "!redirect ".$url;
  
  }  
  
  public static function error() {
  
    return "There was an error. Please try again.";
  
  }
  
  public static function emailError() {
  
    return "There was an error sending an email to your address. Please contact support";
  }
  
  public static function postModelError() {
  
    return "Please send Type, Method, and Args.";
  
  }
  
  public static function registered() {
  
    return "Registration successful! ";
  
  }
  
  public static function activationEmailSent() {
  
    return "We have sent you a confirmation email with a link to activate your account.";
  
  }
  
  public static function activationSuccess() {
  
    return "You have successfully activated your account!";
  
  }
  
  public static function alreadyActivated() {
  
    return "This account has already been activated.";
  
  }
 
  public static function loginFalse() {
  
    return "The email or password you have entered is incorrect.";
  
  }
  
  public static function userExists($email) {
  
    return "A user with email '$email' already exists. Please try a different email.";
  
  }
 
 }

?>
