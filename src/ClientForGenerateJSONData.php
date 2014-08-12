<?php

include_once 'GenerateJSONData.php';
include_once 'Analytics.php';

 $objectForGenerateJSONData = new GenerateJSONData();
 $objectForAnalytics = new Analytics();

 // Creating automated user statistics which could serve as a log data
 $objectForGenerateJSONData->createMultipleProfiles();

 // Generating Analytics on the random user profiles.
 $objectForAnalytics->generateAnalytics();

 //$objectForGenerateJSONData->displayProfileData();



