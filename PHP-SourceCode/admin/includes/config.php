<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','u624665963_drugstore');
define('DB_PASS','!Password@123');
define('DB_NAME','u624665963_drugstore');


// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
