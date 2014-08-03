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








