<?php

include 'growl.gntp.php';

$growl = new Growl('127.0.0.1','password');
$growl->setApplication('Application Name','Notification Name');
$growl->registerApplication('http://dummyimage.com/100/');

// Basic Notification
$growl->notify('Title','Content goes here!');
    
// Notification with Image
$growl->notify('Title','Content goes here!','http://dummyimage.com/100/');
    
// Notification with Image and Link
$growl->notify('Title','Content goes here!','http://dummyimage.com/100/','http://google.com');

?>