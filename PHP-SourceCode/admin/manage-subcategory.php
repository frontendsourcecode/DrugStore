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
$id=$_POST['id'];
$sub_category_title=$_POST['sub_category_title'];
$category_id=$_POST['category_id'];
$prevImage=$_POST['prevImage'];

if(move_uploaded_file($file_loc,$folder.$new_file))
{
$sub_category_img="assets/images/ProductImage/category/".$new_file;
$sql = "UPDATE sub_categories SET category_id='$category_id',sub_category_title='$sub_category_title',sub_category_img='$sub_category_img' WHERE  id='$id' ";
$query = $dbh->prepare($sql);
if($query->execute())
{
  unlink("../".$prevImage);
header('location:manage-subcategory.php');
}
else
{
$error="something went wrong ! Please try again.";
}
}else{
$sql = "UPDATE sub_categories SET category_id='$category_id',sub_category_title='$sub_category_title' WHERE  id='$id' ";
$query = $dbh->prepare($sql);
if($query->execute())
{
header('location:manage-subcategory.php');
}
else
{
$error="something went wrong ! Please try again.";
}
}
}
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from sub_categories  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$msg="Data Deleted successfully";
if($query->execute())
{
   $msg="Data Deleted successfully";

header('location:manage-subcategory.php');
}
else
{
$error="something went wrong ! Please try again.";
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
    <title>GS | Manage Category
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
              <h2 class="page-title">Manage SubCategory
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List Category
                </div>
                <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap" id="msgshow">
                    <?php echo htmlentities($error); ?>
                  </div>
                  <?php }
                    else if($msg){?>
                  <div class="succWrap" id="msgshow">
                    <?php echo htmlentities($msg); ?>
                  </div>
                  <?php }?>
                  <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Image
                        </th>
                        <th>SUb-Category
                        </th>
                        <th>Category
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT sub_categories.*, categories.category, categories.id as cat_id FROM sub_categories INNER JOIN categories ON sub_categories.category_id=categories.id";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {				?>
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
					            	<td>
                          <img width="60px" src="../<?php echo htmlentities($result->sub_category_img);?>" />
                        </td>
                        <td>
                          <?php echo htmlentities($result->sub_category_title);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->category);?>
                        </td>
                        <td>
                         <a href="javascript: void(0)" data-toggle="modal" data-target="#editModal"
                             data-id="<?php echo $result->id; ?>"
                             data-category="<?php echo $result->cat_id; ?>"
                             data-subcategory="<?php echo $result->sub_category_title; ?>"
                             data-image="<?php echo $result->sub_category_img; ?>"
                             >
                                                    <i class="fa fa-pencil" style="color:blue; margin-right:10px;">
                                                    </i>
                                                  </a>

                          <a href="manage-subcategory.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');">
                            <i class="fa fa-trash" style="color:red">
                            </i>
                          </a>

                        </td>
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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="height: 100%; padding-top: 10%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

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
                                       <input type="hidden" class="form-control" name="id" id="sub-cat-id"  required>
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
                                         <label class="col-sm-4 control-label">Sub Category
                                         </label>
                                         <div class="col-sm-8">
                                           <input type="text" class="form-control" name="sub_category_title" id="cat-name"  required>
                                         </div>
                                       </div>

                                       <div class="form-group">
                                         <label class="col-sm-4 control-label">Category Image
                                         </label>
                                            <div class="col-sm-8">
                                           <input type="file" class="form-control" name="sub_category_img" id="cat-image">
                                           <div id="img-name"> <img id="catImg" src="" alt="The Pulpit Rock" width="100" height="100"></div>
                                           <input type="hidden"  name="prevImage" id="prevImage"  required>

                                         </div>
                                       </div>
                                       <div class="hr-dashed">
                                       </div>
                                       <div class="form-group">
                                         <div class="col-sm-8 col-sm-offset-4">
                   		                   <button class="btn btn-default" type="reset" data-dismiss="modal">Cancel</button>
                                           <button class="btn btn-primary" name="submit" type="submit">Update
                                           </button>
                                         </div>
                                       </div>
                                       </form>
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
    <script>

    $('#editModal').on('show.bs.modal', function(e) {
       var button =  $(e.relatedTarget);
        var id = button.data('id');
        var category = button.data('category');
        var subcategory = button.data('subcategory');
        var image = button.data('image');
         var modal = $(this)
         $('#sub-cat-id').val(id);
         $('#cat-name').val(subcategory);
         $('#category_id').val(category);
         $('#catImg').attr("src","../"+image);
         $('#prevImage').val(image);

    });

    </script>
  </body>
</html>
<?php } ?>
