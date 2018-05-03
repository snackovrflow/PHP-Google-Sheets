<?php
require_once __DIR__ . '/vendor/autoload.php';
date_default_timezone_set('America/Los_Angeles');


define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(
  'https://www.googleapis.com/auth/spreadsheets'
)));

// commented this out so it could be run beyond command line. 
// if (php_sapi_name() != 'cli') {
//   throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setDeveloperKey('AIzaSyBcYn98-h6ILI5CyAR4m3gyqEO9KCxg7pk');
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}



function insertIntoGoogleSheet($lastName, $firstName, $email) {
  // Get the API client and construct the service object.
  $client = getClient();
  $service = new Google_Service_Sheets($client);

  $spreadsheetId = '1odLv8MBMWYqyffBel4iDfFXG_3aEk9wM9Qq0yRykHV0';
  $range = '2018 Q1!A2:J';

  $valueRange= new Google_Service_Sheets_ValueRange();

  // You need to specify the values you insert
  $valueRange->setValues(["values" => [$lastName, $firstName, $email]]);

  // Then you need to add some configuration
  $conf = ["valueInputOption" => "RAW"];

  // Update the spreadsheet
  $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);
}
