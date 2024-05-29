<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
$date = date("Ymdhmsu");
$file = $_FILES['sub_category_img']['name'];
$file_loc = $_FILES['sub_category_img']['tmp_name'];
$folder="../assets/images/ProductImage/category/";
$new_size = $file_size/1024;  
$new_file = date("Ymdhmsu").".png";
$category_id=$_POST['category_id'];
$sub_category_title=$_POST['sub_category_title'];
if(move_uploaded_file($file_loc,$folder.$new_file))
{
$sub_category_img="assets/images/ProductImage/category/".$new_file;

$sql="INSERT INTO  sub_categories(category_id ,sub_category_title, sub_category_img) VALUES(:category_id,:sub_category_title, :sub_category_img)";
$query = $dbh->prepare($sql);
$query->bindParam(':category_id',$category_id,PDO::PARAM_INT);
$query->bindParam(':sub_category_title',$sub_category_title,PDO::PARAM_STR);
$query->bindParam(':sub_category_img',$sub_category_img,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Category added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
else 
{
  $sql="INSERT INTO  sub_categories(category_id ,sub_category_title) VALUES(:category_id,:sub_category_title)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':category_id',$category_id,PDO::PARAM_INT);
  $query->bindParam(':sub_category_title',$sub_category_title,PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbh->lastInsertId();
  if($lastInsertId)
  {
  $msg="Category added successfully";
  }
  else 
  {
  $error="Something went wrong. Please try again";
  }
}
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
    <title>GS | Admin Category
    </title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">Add  SubCategory
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Form fields
                    </div>
                    <div class="panel-body">
                      <form enctype="multipart/form-data" method="post" class="form-horizontal" onSubmit="return valid();">
                        <?php if($error){?>
                        <div class="errorWrap">
                          <?php echo htmlentities($error); ?> 
                        </div>
                        <?php } 
							else if($msg){?>
                        <div class="succWrap">
                          <strong>
                            <?php echo htmlentities($msg); ?> 
                            </div>
                          <?php }?>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Category
                            </label>
                            <div class="col-sm-8">
                            <select class="form-control" id="category_id" name="category_id" required>
                              <option>Select Category</option>
                              <?php $sql = "SELECT * from categories";
                                $query = $dbh -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($query->rowCount() > 0)
                                {
                                foreach($results as $result)
                                {				?>	
                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->category);?></option>
                                <?php }} ?>
                            </select>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label">SubCategory Title
                            </label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="sub_category_title"  required>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label">SubCategory Image
                            </label>
                            <div class="col-sm-8">
                              <input type="file" class="form-control" name="sub_category_img">
                            </div>
                          </div>
                          <div class="hr-dashed">
                          </div>
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                              <button class="btn btn-primary" name="submit" type="submit">Add
                              </button>
                            </div>
                          </div>
                          </form>
                        </div>
                    </div>
                    <img src="cateImage/sample.png" />
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
      <script type="text/javascript">
        $(document).ready(function () {
          setTimeout(function() {
            $('.succWrap').slideUp("slow");
          }
                     , 3000);
        }
                         );
      </script>
      </body>
    </html>
  <?php } ?>
