<?php
$host     = "localhost"; // Database Host
$user     = "root"; // Database Username
$password = ""; // Database's user Password
$database = "security"; // Database Name
$prefix   = "security_"; // Database Prefix for the script tables

$mysqli = new mysqli($host, $user, $password, $database);

// Checking Connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$mysqli->set_charset("utf8mb4");

$site_url             = "http://localhost/vpn";
$projectsecurity_path = "http://localhost/codecanyon-Z3ZWBXZm-project-security-website-security-antivirus-firewall/Source";
?>