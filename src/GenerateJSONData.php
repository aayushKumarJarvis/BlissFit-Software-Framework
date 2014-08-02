<?php
    // PHP Code to generate JSON Structure and replicating it for multiple
    // user profiles.

    // Using MongoDB for storage of user profiles.

    // Generating some basic Analytics and rendering that on the App
class GenerateJSONData {

    function createMultipleProfiles() {

        $sensorData =
            array(
                "lastDeviceAccessedTime"=> rand(1,86400),
                "pedometer" => array (
                    "stepCount" => rand(0,100),
                    "speed" => rand(0,10),
                    "distance" => rand(0,1000)
                ),
                "heartSensor" => array (
                    "heartRate" => rand(1,80),
                    "bloodOxygenLevel" => rand(1,90),
                    "bloodPressure" => rand(1,100)
                ),
                "classifier" => array (
                    "mode" => rand(1,1000)
                )
            );

        $mongoClient = new Mongo();
        $db = $mongoClient->userProfile;
        $collection = $db->createCollection("profileData",false);

        // creating 100k random profiles
        for($loopCounter = 1;$loopCounter <= 100000;$loopCounter++) {
            $collection->insert($sensorData);

        }
    }


    function generateAnalytics() {

         $connection = new MongoClient();
         $db = $connection->selectDB("userProfile");
         $collection = $db->selectCollection("profileData");
         $cursor = $collection->find();

        /* Posture Analytics.
        Determining which posture the guy used most during the whole day */
        $meanPosture = 0;
        $countDocuments = 0;
        $meanHeartRate = 0;
        $meanBloodPressure = 0;

        foreach($cursor as $document) {
            $meanPosture += $document['classifier']['mode'];
            $meanHeartRate += $document['heartSensor']['heartRate'];
            $meanBloodPressure += $document['heartSensor']['bloodPressure'];
            $countDocuments += 1;
        }
        $resultantPosture = $meanPosture/$countDocuments;
        $resultantHeartRate = $meanHeartRate/$countDocuments;
        $resultantBloodPressure = $meanBloodPressure/$countDocuments;

        if($resultantPosture>100 && $resultantPosture<200)
            echo "\n\nYou did not move much today. Do some exercise dude !!".$resultantPosture;
        else if($resultantPosture>200 && $resultantPosture<300)
            echo "\n\nA balanced day for you dude !! All body postures covered ".$resultantPosture;
        else
            echo "\n\nToo much running for a day. Chill out dude !!".$resultantPosture;


        // Heart Rate Analytics
        if($resultantHeartRate>50)
            echo "\n\nEasy man ! Your heart is at whooping heights.".$resultantHeartRate;
        else if($resultantHeartRate>20 && $resultantHeartRate<50)
            echo "\n\nSeems you kept your cool today !! Heart Rate is normal ".$resultantHeartRate;
        else
            echo "\n\nDude !! Is something wrong ? Your heart rate is pathetic ".$resultantHeartRate;

        // Blood Pressure Analytics
        if($resultantBloodPressure>80)
            echo "\n\nHigh BP Alert !! ".$resultantBloodPressure;
        else if($resultantBloodPressure>40 && $resultantBloodPressure<80)
            echo "\n\nBP Normal !!".$resultantBloodPressure;
        else
            echo "\n\nDude, your BP is LOW !!".$resultantBloodPressure;
    }

    function displayProfileData() {

        echo "Creating Random User Profiles . . .";
        $this->createMultipleProfiles();

        //establishing new connection with database.
        echo "\nEstablishing Connection with Mongo";
        $connection = new MongoClient();
        $db = $connection->selectDB("userProfile");
        //echo $db;
        $collection = $db->selectCollection("profileData");
        //echo $collection;
        $cursor = $collection->find();

        foreach ($cursor as $document) {
            print_r($document['classifier']['mode']."\n");
        }
    }
}








