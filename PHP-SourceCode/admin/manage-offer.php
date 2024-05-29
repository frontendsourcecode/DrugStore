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
$file = $_FILES['image']['name'];
$file_loc = $_FILES['image']['tmp_name'];
$folder="../assets/images/OfferImage/";
$new_size = $file_size/1024;
$new_file = date("Ymdhmsu").".png";
$id=$_POST['id'];
$name=$_POST['name'];
$prevImage=$_POST['prevImage'];
if(move_uploaded_file($file_loc,$folder.$new_file))
{
$image="assets/images/OfferImage/".$new_file;
$sql = "UPDATE offers SET name='$name',image='$image' WHERE  id='$id' ";
$query = $dbh->prepare($sql);
if($query->execute())
{
unlink("../".$prevImage);
header('location:manage-offer.php');
}
else
{
$error="something went wrong ! Please try again.";
}
}else{
$sql = "UPDATE offers SET name='$name' WHERE  id='$id' ";
$query = $dbh->prepare($sql);
if($query->execute())
{
header('location:manage-offer.php');
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

$query1 = $dbh->prepare("SELECT * FROM offers WHERE id= :id LIMIT 1"); 
$query1 -> bindParam(':id',$id, PDO::PARAM_STR);
$query1 -> execute();
$record = $query1->fetch();
//get image path
$sql = "delete from offers  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);

if($query -> execute()){
  $imageUrl = "../".$record['image'];
  unlink($imageUrl);
  $msg="Data Deleted successfully";

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
              <h2 class="page-title">Manage Offer
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List Offer
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
                        <th>Name
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  offers ";
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
                          <img height="100px" src="../<?php echo htmlentities($result->image);?>" />
                        </td>
                        <td>
                          <?php echo htmlentities($result->name);?>
                        </td>
                        <td>
                         <a href="javascript: void(0)" data-toggle="modal" data-target="#editModal"
                             data-id="<?php echo $result->id; ?>"
                             data-name="<?php echo $result->name; ?>"
                             data-image="<?php echo $result->image; ?>"
                             >
                                                    <i class="fa fa-pencil" style="color:blue; margin-right:10px;">
                                                    </i>
                                                  </a>

                          <a href="manage-offer.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');">
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
  <div class="modal-dialog  modal-dialog-centered" role="document" style="height: 100%; padding-top: 10%;">
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
                                       <input type="hidden" class="form-control" name="id" id="id"  required>
                                       <div class="form-group">
                                         <label class="col-sm-4 control-label">Name
                                         </label>
                                         <div class="col-sm-8">
                                           <input type="text" class="form-control" name="name" id="name"  required>
                                         </div>
                                       </div>
                                       <div class="form-group">
                                         <label class="col-sm-4 control-label">Offer Image
                                         </label>
                                            <div class="col-sm-8">
                                           <input type="file" class="form-control" name="image" id="image">
                                           <div id="img-name"><img id="catImg" src="" alt="" width="100" height="100"></div>
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
        var name = button.data('name');
        var image = button.data('image');
         var modal = $(this)
         $('#id').val(id);
         $('#name').val(name);
         $('#catImg').attr("src","../"+image);
         $('#prevImage').val(image);
    });

    </script>
  </body>
</html>
<?php } ?>
