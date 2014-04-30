<?php
error_reporting(E_ALL);
$docroot = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR;
include($docroot.'/api/modules/metricslogger/classes/metricslogger.php');


//ENV
$env = "LOCAL";
if($_SERVER['SERVER_NAME'] == 'local.northsocial.com')
    $env = "development";
if($_SERVER['SERVER_NAME'] == 'localrkm.northsocial.com')
    $env = "developmentrkm";
if($_SERVER['SERVER_NAME'] == 'dev.northsocial.com')
    $env = "development";
if($_SERVER['SERVER_NAME'] == 'qa.northsocial.com')
    $env = "qa";
if($_SERVER['SERVER_NAME'] == 'northsocial.com')
    $env = "production";
if($_SERVER['SERVER_NAME'] == 'new.northsocial.com')
    $env = "production";

//LOG
$ml = new Metricslogger();
$ml->setEnv("web.".$env);
$logmsg =  array(
        "page"=>$_SERVER['REQUEST_URI']
    );
$ml->event("PageLoad","Website", $logmsg);

?>

<!DOCTYPE HTML>
<html xmlns:ng="http://angularjs.org"  lang="en" id="ng-app" ng-app="nsweb">
<?php header('X-Frame-Options: GOFORIT'); ?>
<?php include('_head.php') ?>
<body>
<?php include('_header.php') ?>
<!-- full content section starts-->
	<div class="container">
		<div class="row-fluid">
		
		<div ng-view></div ng-view>
