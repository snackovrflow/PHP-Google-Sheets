<?php

require("quickstart.php");

// customer
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];

// simple email validation (built in php filter)
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  try {
    // see quickstart.php
    insertIntoGoogleSheet($lastName, $firstName, $email);
  } catch (Exception $e) {
    echo 'Error inserting into Google Sheet: ', $e->getMessage();
    return http_response_code(400);
  }
} else {
  echo "invalid parameters";
  return http_response_code(400);
}

?>
