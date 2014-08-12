<?php

/*
This code will is an attempt for real time data retrieval and fetching.

All the functionality is already is implemented. I just need to program it
based on time durations.

ALGORITHM : Calling the auto data generating function.
            Generate Analytics as the next step.
            Asking the client to refresh itself in every 2 seconds.

*/

include_once 'GenerateJSONData.php';
include_once 'Analytics.php';

class TimeBasedData {

   function __construct() {

        $this->objectForData = new GenerateJSONData();
        $this->objectForAnalytics = new Analytics();

   }

    // Method which has the list of operations which has to be performed on each real time call.
    public function performRealTimeOperations() {

        set_time_limit(120);
        for($i=0; $i<120;$i++) {

            $this->objectForData->createMultipleProfiles();
            $this->objectForAnalytics->generateAnalytics();

            // Refreshing the analytics every two seconds.
            sleep(2);
        }
    }

    // Method for showing an introductory message before the analytics is shown on the console.
    public function introductoryMessage() {

        echo "Welcome to BlissFit Solutions\n==============================";
        sleep(1);
        echo "\n\n";
        echo "Initializing Setup . . . .";
        echo "\n\n";
        sleep(4);
        echo "MongoDB ready . .\n";
        sleep(1);
        echo "Preparing DB with random profiles.\n";
        sleep(3);
        echo "\nDB Ready. Waiting for Analytics to respond.";
    }
}


