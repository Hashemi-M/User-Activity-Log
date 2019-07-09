<?php

    /*
    This code uses sleekDB which is a nosql database for php
    The link to download sleekDB: https://github.com/rakibtg/SleekDB/archive/master.zip
    */

    // calling sleekBP.php from relative path 
    require_once ("..\SleekDB-master\src\SleekDB.php");

    // path to where sleekDB will write data
    $dataDir = "..\SleekDB-master\databse";

    // craete database Store
    $userDataStore = \SleekDB\SleekDB::store('userData', $dataDir);

    // Reciving Ajax post request
    if(isset($_POST['userData'])){
        $jsonObj = json_decode($_POST['userData']);
        
        //Conterting time in millisec to mins
        $timeInMins = ($jsonObj->timeActive)/1000/60;
        
        $userData = [
            'userEmail' => $jsonObj->username,
            'activeTime' => $timeInMins,
            'date' => $jsonObj->date
        ];
        
        // inserting data into store
        $userData = $userDataStore->insert( $userData );
    }

?>