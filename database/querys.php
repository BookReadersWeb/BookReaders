<?php

require_once '../app/config/Database.php';

$database = new \config\Database();

$database->createDatabase();

$database->createUsersTable();

$database->createDefaultAdminUser();

$database->closeConnection();

?>
