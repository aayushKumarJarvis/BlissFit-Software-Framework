<?php
include_once 'GenerateJSONData.php';

$objectForGenerateJSONData = new GenerateJSONData();

// Creating automated user statistics which could serve as a log data
$objectForGenerateJSONData->createMultipleProfiles();

// Generating Analytics on the random user profiles.
$objectForGenerateJSONData->generateAnalytics();

//$objectForGenerateJSONData->displayProfileData();
