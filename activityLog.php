<?php

    /*
    This code uses google-api-php-client v2.2.3 which is a a PHP client library for accessing Google APIs.
    The link to download this libary is : https://github.com/googleapis/google-api-php-client/releases/tag/v2.2.3
    */

    // calling the google-api-php-client from relative path 
    require_once ("../google-api/vendor/autoload.php");

    // Reciving Ajax post request
    if(isset($_POST['userData'])){
        $jsonObj = json_decode($_POST['userData']);
        
        //Conterting time in millisec to mins
        $timeInMins = ($jsonObj->timeActive)/1000/60;


        // Required to connect to google spreadsheet
        $client = new \Google_Client();
        $client->setApplicationName('ActivityLog');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('Activity Log-3e83023cd238.json');
        $service = new Google_Service_Sheets($client);
        // google sheets id
        $sheet = "1RWd_gf8CM-Ad3zmUBZzd7DIMKuZBpIyfXX13_pZKh8k";

        // What sheet is data is being appended to
        $range = 'Sheet1';
        $valueRange= new Google_Service_Sheets_ValueRange();
        // Array of values
        $valueRange->setValues(["values" => [$jsonObj->username, $timeInMins,$jsonObj->date]]); 
        $conf = ["valueInputOption" => "RAW"];
        $ins = ["insertDataOption" => "INSERT_ROWS"];
        $service->spreadsheets_values->append($sheet, $range, $valueRange, $conf, $ins);
       }

?>