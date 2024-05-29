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

$id=$_POST['id'];
$name=$_POST['itemname'];
$description=$_POST['itemdes'];
$price=$_POST['itemprice'];
$discount=$_POST['discount'];
$attribute=$_POST['attribute'];
$active=$_POST['active'];
$prevImage=$_POST['prevImage'];
if(!$active){
	$active=0;
}

if($active==0){
  $sql = "delete from cart WHERE product_id=:id";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':id',$id, PDO::PARAM_STR);
  $query -> execute();
}


		$sql = "UPDATE items SET name='$name',description='$description',price='$price',discount='$discount',attribute='$attribute', active='$active'   WHERE  id='$id' ";
    $query = $dbh->prepare($sql);
    if($query->execute())
    {

      $folder = "../assets/images/ProductImage/product/";/* Path for file upload */
      $fileCount = count($_FILES["itemimgs"]['name']);

      if(!empty(array_filter($_FILES['itemimgs']['name']))){

        $sql = "delete from product_image WHERE item_id=:item_id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':item_id',$id, PDO::PARAM_STR);
        $query -> execute();

        for($i=0; $i < $fileCount; $i++){
          $new_file = $id.date("Ymdhmsu").rand(0,9999999999999).".png";
          $file_loc = $_FILES['itemimgs']['tmp_name'][$i];
          $image="assets/images/ProductImage/product/".$new_file;
          if(move_uploaded_file($file_loc,$folder.$new_file)){
              $sql="INSERT INTO product_image(image,item_id)VALUES(:image,:item_id)";
              $query = $dbh->prepare($sql);
              $query->bindParam(':image',$image,PDO::PARAM_STR);
              $query->bindParam(':item_id',$id,PDO::PARAM_INT);
              $query->execute();
          }
          else{
            $error="Something went wrong. Please try again";
          }
        }
      }

    $msg="Item update successfully";
    }
    else
    {
    $error="Something went wrong. Please try again";
    }
  
}

if(isset($_GET['del']))
{
$id=$_GET['del'];

$sql = "delete from items WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();


$msg="Data Deleted successfully";
}
if(isset($_REQUEST['unhomepage']))
{
$aeid=intval($_GET['unhomepage']);
$status='YES';
$sql = "UPDATE items SET homepage=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_REQUEST['homepage']))
{
$aeid=intval($_GET['homepage']);
$status='NO';
$sql = "UPDATE items SET homepage=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
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
    <title>GS | Manage Items
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
    <link rel="stylesheet" href="css/summernote.min.css">

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
              <h2 class="page-title">Manage Items
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List Items
                </div>
                <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap" id="msgshow">
                    <?php echo htmlentities($error); ?>
                  </div>
                  <?php }else if($msg){?>
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
                        <th>Category
                        </th>
                        <th>SubCategory
                        </th>
                        <th>Description
                        </th>

                        <th>Price
                        </th>
                        <th>Discount Price
                        </th>
                        
                        <th>Homepage
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT items.*, categories.category,sub_categories.sub_category_title FROM items INNER JOIN categories ON items.category_id=categories.id INNER JOIN sub_categories ON items.sub_category_id=sub_categories.id";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;

                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {	
                          
                          
                          $item_id = $result->id;

                          $sql = "SELECT image FROM product_image where item_id =".$item_id;
                          $query = $dbh -> prepare($sql);
                          $query->execute();
                          $results1=$query->fetchAll(PDO::FETCH_OBJ); 
                          ?>
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                        <td>                       
                          <img src="../<?php echo htmlentities($results1[0]->image);?>" style="width:50px;"/>
                        </td>
                        <td>
                          <?php echo htmlentities($result->name);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->category);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->sub_category_title);?>
                        </td>
                        <td>
                          <?php echo ($result->description);?>
                        </td>

                        <td>
                          <?php echo "₹".htmlentities($result->price);?> 
                          
                        </td>

                        <td>
                          <?php echo "₹".htmlentities($result->discount);?> 
                          
                        </td>
                        
                        <td>
                          <?php if($result->homepage == 'YES')
                        {?>
                          <a href="manage-items.php?homepage=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Remove item from Homepage')">YES
                          </a>
                          <?php } else {?>
                          <a href="manage-items.php?unhomepage=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Make item on Homepage')">NO
                          </a>
                          <?php } ?>
                        </td>
                        <td>
                         <a href="javascript: void(0)" data-toggle="modal" data-target="#editModal"
                                                     data-id="<?php echo $result->id; ?>"
                                                     data-category="<?php echo $result->category; ?>"
                                                     data-name="<?php echo $result->name; ?>"
                                                     data-description="<?php echo htmlentities ($result->description); ?>"
                                                     data-price="<?php echo $result->price; ?>"
                                                     data-discount="<?php echo $result->discount; ?>"
                                                     data-attribute="<?php echo $result->attribute; ?>"
                                                     data-prepare_time="<?php echo $result->prepareTime; ?>"
                                                     data-active="<?php echo $result->active; ?>"
                                                     >
                                                                            <i class="fa fa-pencil" style="color:blue; margin-right:10px;">
                                                                            </i>
                                                                          </a>
                          <a href="manage-items.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');" class="disabled">
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
        <div class="modal-dialog  modal-lg" role="document" style="height: 100%; padding-top: 10%;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Update Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                   <form method="post" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="id" class="form-control" id="id" required>

                   <div class="form-group">
                   <label class="col-sm-2 control-label">Name<span style="color:red">*</span></label>
                   <div class="col-sm-10">
                   <input type="text" name="itemname" class="form-control" id="itemname" required>
                   </div>

                   </div>

                   <div class="hr-dashed"></div>
                   <div class="form-group">
                   <label class="col-sm-2 control-label">Description</label>
                   <div class="col-sm-10">
                   <textarea class="form-control summernote" name="itemdes" id="itemdes" ></textarea>
                   </div>
                   </div>

                   <div class="form-group">
                   <label class="col-sm-2 control-label">Price<span style="color:red">*</span></label>
                   <div class="col-sm-4">
                   <input type="number" name="itemprice" class="form-control" id="itemprice" required placeholder="Per plate/person/bounch/piece">
                   </div>
                   <label class="col-sm-2 control-label">Discount Price<span style="color:red"></span></label>
                   <div class="col-sm-4">
                      <input type="number" name="discount" class="form-control" id="discount"  placeholder="Per plate/person/bounch/piece">
                   </div>
                   </div>

                   <div class="form-group">
                   <label class="col-sm-2 control-label" style="word-break: break-all;">Attributes(plate/person)<span style="color:red">*</span></label>
                   <div class="col-sm-4">
                      <input type="text" name="attribute" class="form-control" id="attribute" required  placeholder="plate/person/bounch/piece">
                   </div>
                   <label class="col-sm-2 control-label">Image<span style="color:red">*</span></label>
                   <div class="col-sm-4">
                   <input type="file" name="itemimgs[]" class="form-control"  multiple accept="image/*">
                   <div id="itemimg"><img id="catImg" src="" alt="" width="100" height="100"></div>
                   <input type="hidden"  name="prevImage" id="prevImage"  required>

                   </div>
                   </div>
                   <div class="form-group">
                   
                    <div class="col-sm-2"></div>
                    <div class="form-check col-sm-4">
                      <input class="form-check-input" type="checkbox" value="" onclick="$(this).attr('value', this.checked ? 1 : 0)"  id="active" name="active"  >
                      <label class="form-check-label" for="flexCheckDefault">
                      Active
                      </label>
                    </div>
                    </div>

                   <div class="form-group">
                   	<div class="col-sm-8 col-sm-offset-2">
                   		<button class="btn btn-default" type="reset" data-dismiss="modal">Cancel</button>
                   		<button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
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
    	<script src="js/summernote.min.js"></script>

    <script src="js/main.js">
    </script>
    <script type="text/javascript">
      $(document).ready(function () {

        $('.summernote').summernote({
       });
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
            var description = button.data('description');
            var price = button.data('price');
            var discount = button.data('discount');
            var attribute = button.data('attribute');
            var prepareTime = button.data('prepare_time');
            var active = button.data('active');
             var modal = $(this)
             $('#id').val(id);
             $('#itemname').val(name);
             $(".summernote").summernote("code", description);
             $('#itemprice').val(price);
             $('#discount').val(discount);
             $('#attribute').val(attribute);
             $('#prepareTime').val(prepareTime);
             $('#active').val(active);
             if(active===1){
              $('#active').attr('checked','checked')
             }

            //  $('#catImg').attr("src","../"+image);

            $.ajax({
              url: "fetch-product-image.php",
              type: "POST",
              data: {
              item_id: id
              },
              cache: false,
              success: function(result){
                var obj = jQuery.parseJSON(result);
                $('#catImg').attr("src","../"+obj[0].image);
              }
            });


        });

        </script>
  </body>
</html>
<?php } ?>
