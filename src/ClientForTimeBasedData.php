<?php

// Client for TimeBasedData class.

include_once 'TimeBasedData.php';

$realTimeData = new TimeBasedData();

// Display some cool messages.
$realTimeData->introductoryMessage();

// Compute and display the analytics data;
$realTimeData->performRealTimeOperations();