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
else{ 

if(isset($_POST['submit']))
  {
// $file = $_FILES['itemimg']['name'];
// $file_loc = $_FILES['itemimg']['tmp_name'];
// $date = date("Ymdhmsu");
// $folder="../assets/images/ProductImage/product/";
// $new_size = $file_size/1024;  

$name=$_POST['itemname'];
$category_id=$_POST['itemcategory'];
$sub_category_id=$_POST['itemsubcategory'];
$description=$_POST['itemdes'];
$price=$_POST['itemprice'];
$discount=$_POST['discount'];
$attribute=$_POST['attribute'];
$prepareTime=$_POST['prepareTime'];
$active=$_POST['active'];
if(!$active){
	$active=0;
}

$homepage="NO";



// $new_file = date("Ymdhmsu").".png";

// if(move_uploaded_file($file_loc,$folder.$new_file))
// 	{
// 		$image="assets/images/ProductImage/product/".$new_file;
// 	}

$sql="INSERT INTO items(name,category_id, sub_category_id,description,price,discount,attribute,homepage,active) VALUES(:name,:category_id,:sub_category_id,:description,:price,:discount,:attribute,:homepage,:active)";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':category_id',$category_id,PDO::PARAM_INT);
$query->bindParam(':sub_category_id',$sub_category_id,PDO::PARAM_INT);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->bindParam(':discount',$discount,PDO::PARAM_STR);
$query->bindParam(':attribute',$attribute,PDO::PARAM_STR);
$query->bindParam(':homepage',$homepage,PDO::PARAM_STR);
$query->bindParam(':active',$active,PDO::PARAM_INT);
$query->execute();

$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

	$folder = "../assets/images/ProductImage/product/";/* Path for file upload */
	$fileCount = count($_FILES["itemimgs"]['name']);

	for($i=0; $i < $fileCount; $i++){
		$new_file = $lastInsertId.date("Ymdhmsu").rand(0,9999999999999).".png";
		$file_loc = $_FILES['itemimgs']['tmp_name'][$i];
		$image="assets/images/ProductImage/product/".$new_file;
		if(move_uploaded_file($file_loc,$folder.$new_file)){
		    $sql="INSERT INTO product_image(image,item_id)VALUES(:image,:item_id)";
			$query = $dbh->prepare($sql);
			$query->bindParam(':image',$image,PDO::PARAM_STR);
			$query->bindParam(':item_id',$lastInsertId,PDO::PARAM_INT);
			$query->execute();
		}
		else{
			$error="Something went wrong. Please try again";
		}
	}

   $msg="Item added successfully";
  
}
else 
{
$error="Something went wrong. Please try again";
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
	<title>Add Items</title>

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
	<link rel="stylesheet" href="css/summernote.min.css">

	<script type= "text/javascript" src="../vendor/countries.js"></script>

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
					
						<h2 class="page-title">Add Items</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
<?php if($error){?><div class="errorWrap"><?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Name<span style="color:red">*</span></label>
<div class="col-sm-10">
<input type="text" name="itemname" class="form-control" required>
</div>

</div>
<div class="form-group">
<label class="col-sm-2 control-label">Category<span style="color:red">*</span></label>
<div class="col-sm-4">
		<select name="itemcategory" id="category-dropdown" class="form-control" required>
		<option value="">Select</option>
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
<label class="col-sm-2 control-label">Sub Category<span style="color:red">*</span></label>
<div class="col-sm-4">
		<select name="itemsubcategory"  id="sub-category-dropdown" class="form-control" required>		
		</select>
</div>


</div>


<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Description</label>
<div class="col-sm-10">
<textarea class="form-control summernote" name="itemdes"></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Price<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="number" name="itemprice" class="form-control" required placeholder="Per strip/pack">
</div>
<label class="col-sm-2 control-label">Discount Price<span style="color:red"></span></label>
<div class="col-sm-4">
   <input type="number" name="discount" class="form-control"  placeholder="Per strip/pack">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Attributes(gm/kg/pack/strip)<span style="color:red">*</span></label>
<div class="col-sm-4">
   <input type="text" name="attribute" class="form-control" required  placeholder="Per gm/kg/pack/strip">
</div>
<label class="col-sm-2 control-label">Image<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="file" name="itemimgs[]" class="form-control" required value="Select Image File" multiple accept="image/*">
</div>
</div>
<div class="form-group">

<div class="col-sm-2"></div>
<div class="form-check col-sm-4">
  <input class="form-check-input" type="checkbox" value="1"  id="active" name="active" checked >
  <label class="form-check-label" for="flexCheckDefault">
   Active
  </label>
</div>

</div>





<div class="form-group">
	<div class="col-sm-8 col-sm-offset-2">
		<button class="btn btn-default" type="reset">Cancel</button>
		<button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
	</div>
</div>
										</form>
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
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<script src="js/summernote.min.js"></script>
    <script type="text/javascript">
				 $(document).ready(function () {          
					setTimeout(function() {
						$('.succWrap').slideUp("slow");
					}, 3000);
					});
		</script>

<script>
$(document).ready(function() {
$('.summernote').summernote({
});
$('#category-dropdown').on('change', function() {
var category_id = this.value;
$.ajax({
url: "fetch-subcategory-by-category.php",
type: "POST",
data: {
category_id: category_id
},
cache: false,
success: function(result){
$("#sub-category-dropdown").html(result);
}
});
});
});
</script>
</body>
</html>
<?php } ?>