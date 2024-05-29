<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('firebase/firebase.php');
include('firebase/push.php');
//   Author: Quintus Labs
//   Author URL: http://quintuslabs.com
//   date: 12/11/2019
//   Github URL: https://github.com/quintuslabs/GroceryStore-with-server/

if(strlen($_SESSION['alogin'])==0)
{
header('location:index.php');
}
else{
  
  $firebase = new Firebase();
  $push = new Push();

   // optional payload
   $payload = array();
   $payload['name'] = 'Drug Store';
   $payload['version'] = '1.6';
    $push->setTitle("Your Order Status");
    $push->setImage('');
    $push->setIsBackground(FALSE);
    $push->setPayload($payload);

    global $firebase_token;
if(isset($_REQUEST['mobile'])){
        $mobile=$_GET['mobile'];
        $sql = "SELECT firebase_token FROM users WHERE mobile=:mobile";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $stmt->execute();
        $firebase_token = $stmt->fetch(PDO::FETCH_OBJ);
        $regId = $firebase_token->firebase_token;
}

if(isset($_REQUEST['confirmid']))
	{
$eid=intval($_GET['confirmid']);
$status='Confirmed';
$sql = "UPDATE orders SET status=:status WHERE id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
 $push->setMessage("Your order has been confirmed. We will Contact you soon.");
 $json = $push->getPush();
 $response = $firebase->send($regId, $json);
$msg="Status Updated Sucessfully";

}
if(isset($_REQUEST['prepareid']))
	{
$eid=intval($_GET['prepareid']);
$status='Preparing';
$sql = "UPDATE orders SET status=:status WHERE id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
 $push->setMessage("Your order has been packed and waiting for delivery boy");
 $json = $push->getPush();
 $response = $firebase->send($regId, $json);
$msg="Status Updated Sucessfully";
}
if(isset($_REQUEST['wayid']))
	{
$eid=intval($_GET['wayid']);
$status='On Way';
$sql = "UPDATE orders SET status=:status WHERE id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
 $push->setMessage("Your order is on the way. Our delivery boy will contact you soon.");
 $json = $push->getPush();
 $response = $firebase->send($regId, $json);
$msg="Status Updated Sucessfully";
}
if(isset($_REQUEST['deliveredid']))
	{
$eid=intval($_GET['deliveredid']);
$status='Delivered';
$sql = "UPDATE orders SET status=:status WHERE id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
 $push->setMessage("Your order has been delivered SUccessfully. Thank you for shopping.");
 $json = $push->getPush();
 $response = $firebase->send($regId, $json);
$msg="Status Updated Sucessfully";
}

  
?>
<!doctype html>
<html lang="en" class="no-js">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <link rel="icon" href="img/logo.png" type="image/gif" sizes="16x16">
    <title>Drug Store | Admin Dashboard
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">Dashboard
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                          <div class="stat-panel text-center">
                            <?php
                              $sql ="SELECT id from orders";
                              $query = $dbh -> prepare($sql);
                              $query->execute();
                              $results=$query->fetchAll(PDO::FETCH_OBJ);
                              $bg=$query->rowCount();
                              ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($bg);?>
                            </div>
                            <div class="stat-panel-title text-uppercase">Orders
                            </div>
                          </div>
                        </div>
                        <a href="manage-orders.php" class="block-anchor panel-footer">Full Detail
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>
					          <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                          <div class="stat-panel text-center">
                              <?php
                                $sql1 ="SELECT id from items";
                                $query1 = $dbh -> prepare($sql1);;
                                $query1->execute();
                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                $regbd=$query1->rowCount();
                                ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($regbd);?>
                            </div>
                            <div class="stat-panel-title text-uppercase">Items
                            </div>
                          </div>
                        </div>
                         <a href="manage-items.php" class="block-anchor panel-footer text-center">Full Detail &nbsp;
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-success text-light">
                          <div class="stat-panel text-center">
                             <?php
                              $sql ="SELECT id from orders  where status='Pending' ";
                              $query = $dbh -> prepare($sql);
                              $query->execute();
                              $results=$query->fetchAll(PDO::FETCH_OBJ);
                              $regbd=$query->rowCount();
                              ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($regbd);?>
                            </div>
                            <div class="stat-panel-title text-uppercase">Pending
                            </div>
                          </div>
                        </div>
                        <a href="pending-orders.php" class="block-anchor panel-footer text-center">Full Detail &nbsp;
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-info text-light">
                          <div class="stat-panel text-center">
                            <?php
                              $sql6 ="SELECT id from users";
                              $query6 = $dbh -> prepare($sql6);;
                              $query6->execute();
                              $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                              $query=$query6->rowCount();
                              ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($query);?>
                            </div>
                            <div class="stat-panel-title text-uppercase">Users
                            </div>
                          </div>
                        </div>
                        <a href="manage-user.php" class="block-anchor panel-footer text-center">Full Detail &nbsp;
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                 <div class="col-sm-9">
                    <h3>Recent Orders</h3>
                 </div>
                 <div class="col-sm-3"><h5><a href="/drugstore/admin/manage-orders.php" class="pt-3">View All Orders</a></h5></div>
                <div class="col-sm-12">
                <div class="panel panel-default">
							<div class="panel-heading">Orders</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
									else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>OrderID</th>
										<th>Name</th>
										<th>Mobile Number</th>
										<th>email</th>
										<th>Address</th>
										<th>Status</th>
										<th>Action</th>
										<th></th>
										</tr>
									</thead>
									<tbody>

										<?php $sql = "SELECT orders.*, users.name, users.mobile, users.email,users.address from orders INNER JOIN users on orders.user_id=users.id order by id desc limit 30";
										$query = $dbh -> prepare($sql);
										$query->execute();
										$results=$query->fetchAll(PDO::FETCH_OBJ);
										$cnt=1;
										if($query->rowCount() > 0)
										{
										foreach($results as $result)
										{				?>
										<tr>
											<td><?php echo htmlentities($result->id);?></td>
											<td><?php echo htmlentities($result->name);?></td>
											<td><?php echo htmlentities($result->mobile);?></td>
											<td><?php echo htmlentities($result->email);?></td>
											<td><?php echo htmlentities($result->address);?></td>
											<td><b class="text-warning"><?php echo htmlentities($result->status);?></b></td>
											<td><a href="view-order.php?orderid=<?php echo $result->id;?>" >View Order</a></td>
											<td>
												<select onchange="location = this.value;" value=<?php echo htmlentities($result->status);?>>
												<option 	<?php if ($result->status == 'Confirmed') echo 'selected'; ?> >Pending</option>
												<option value="manage-orders.php?confirmid=<?php echo $result->id;?>&mobile=<?php echo $result->mobile;?>"
												<?php if ($result->status == 'Confirmed') echo 'selected'; ?> >Confirmed</option>
												<option value="manage-orders.php?prepareid=<?php echo $result->id;?>&mobile=<?php echo $result->mobile;?>"
												<?php if ($result->status == 'Prepared') echo 'selected'; ?>>Prepared</option>
												<option value="manage-orders.php?wayid=<?php echo $result->id;?>&mobile=<?php echo $result->mobile;?>"
												<?php if ($result->status == 'On Way') echo 'selected'; ?>>On Way</option>
												<option value="manage-orders.php?deliveredid=<?php echo $result->id;?>&mobile=<?php echo $result->mobile;?>"
												<?php if ($result->status == 'Delivered') echo ' selected'; ?>>Delivered</option>
												</select></td>
										</tr>
										<?php $cnt=$cnt+1; }} ?>

									</tbody>
								</table>
							</div>
						</div>
                 
                </div>
              
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
  </body>
</html>
<?php } ?>
