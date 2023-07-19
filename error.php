<?php

// require_once('class/Errors.php');


// function vai_dar_erro() {
//     throw new Errors();
// }

// try {
//     vai_dar_erro();
// } catch (Errors $e) {
//     echo $e->get_error_msg();
// }


require_once('class/Errors.php');

$email = "someone@example...com";

try {
  //check if
  if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
    //throw exception if email is not valid
    throw new Exception("deu erro");
  }
}

catch (Exception $e) {
  echo $e->getMessage();
}
?>