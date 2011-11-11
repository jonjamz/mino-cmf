<?php

class responses {
 
 // Static methods for uniformity, because sometimes we'll pass args into messages
 
  public static function error() {
  
    return "There was an error. Please try again.";
  
  }
  
  public static function activation() {
  
    return "Thank you for registering! We have sent you a confirmation email with a link to activate your account.";
  
  }
 
  public static function loginFalse() {
  
    return "The email or password you have entered is incorrect.";
  
  }
  
  public static function userExists($email) {
  
    return "A user with email '$email' already exists. Please try a different email.";
  
  }
 
 }

?>
