<?php
    // PHP Code to generate JSON Structure and replicating it for multiple
    // user profiles.

    // Using MongoDB for storage of user profiles.

    // Generating some basic Analytics and rendering that on the App

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
            $meanPosture += $document['mode'];
            $meanHeartRate += $document['heartRate'];
            $meanBloodPressure += $document['bloodPressure'];
            $countDocuments += 1;
        }
        $resultantPosture = $meanPosture/$countDocuments;
        $resultantHeartRate = $meanHeartRate/$countDocuments;
        $resultantBloodPressure = $meanBloodPressure/$countDocuments;

        if($resultantPosture>100 && $resultantPosture<200)
            echo "You did not move much today. Do some exercise dude !!";
        else if($resultantPosture>200 && $resultantPosture<300)
            echo "A balanced day for you dude !!";
        else
            echo "Too much for a day. Chill out dude !!";


        // Heart Rate Analytics
        if($resultantHeartRate>50)
            echo "Easy man ! Your heart is at whooping heights.";
        else if($resultantHeartRate>20 && $resultantHeartRate<50)
            echo "Seems you kept your cool today !!";
        else
            echo "Dude !! Is something wrong ? Your heart rate is pathetic";

        // Blood Pressure Analytics
        if($resultantBloodPressure>80)
            echo "High BP Alert !!";
        else if($resultantBloodPressure>40 && $resultantBloodPressure<80)
            echo "BP Normal !!";
        else
            echo "Dude, your BP is LOW !!";
    }

    function displayProfileData() {

        echo "Creating Random User Profiles . . .";
        createMultipleProfiles();

        //establishing new connection with database.
        echo "\nEstablishing Connection with Mongo";
        $connection = new MongoClient();
        $db = $connection->selectDB("userProfile");
        //echo $db;
        $collection = $db->selectCollection("profileData");
        //echo $collection;
        $cursor = $collection->find();

        foreach ($cursor as $document) {
            print_r($document)."\n";
        }
    }

    // method to create multiple profiles and then generate analytics out of them
    





