<?php
session_start();
error_reporting(0);
include('includes/config.php');

/*
Author: Quintus Labs
Author URL: http://quintuslabs.com
date: 12/11/2019
Github URL: https://github.com/quintuslabs/GroceryStore-with-server/
*/

if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
    $item_id = $_POST["item_id"];

    $sql = "SELECT image FROM product_image where item_id=".$item_id;
    $query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ); 

    echo json_encode($results);

?>