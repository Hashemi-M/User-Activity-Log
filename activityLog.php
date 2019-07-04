<?php
    require_once ("../google-api/vendor/autoload.php");


    if(isset($_POST['userData'])){
        $jsonObj = json_decode($_POST['userData']);
        
        //
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