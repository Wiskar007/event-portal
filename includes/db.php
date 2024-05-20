<?php 
define('db_host','localhost');
define('db_name','event_portal');
define('db_user','root');
define('db_pass','');
define('site_url','http://localhost/event-portal');

// Create connection
$db = new mysqli(db_host, db_user, db_pass, db_name); 
 
// Display error if failed to connect 
if ($db->connect_errno) { 
    printf("Connect failed: %s\n", $db->connect_error); 
    exit(); 
}
?>