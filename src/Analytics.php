<?php

class Analytics {

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
}