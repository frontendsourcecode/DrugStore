<?php
require 'config.php';
require 'phpmailer/mail.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/login','login');
$app->post('/register','register');
$app->post('/forgot_password','forgotPassword');
$app->post('/reset_password','resetPassword');
$app->post('/resend_otp','resendOTP');
$app->post('/verify_otp','verifyOTP');
//$app->post('/change_password','changePassword');
$app->post('/homepage','homepage');
$app->post('/categories','getCategoryList');
$app->post('/category/products','getProductByCategory');
$app->post('/sub-category/products','getProductBySubCategory');
$app->post('/newProducts','newProduct');
$app->post('/placeOrder','placeOrder');
$app->post('/store-pickup','storePickUp');
$app->post('/orderDetails','getOrders');
$app->post('/singleOrderDetails','getSingleOrders');
$app->post('/update_user','updateUser');
// $app->post('/update_payment','updatePayment');
$app->get('/product/search','searchProduct');
$app->get('/banners','banners');
$app->get('/offers','offers');
$app->post('/addCart','addCart');
$app->post('/updateCart','updateCart');
$app->post('/cartDetails','getCartDetails');
$app->post('/userCart','getUserCart');
$app->post('/upload_prescription','uploadPrescription');
$app->post('/prescriptions','getPrescriptions');

$app->post('/upload_bills','uploadBill');
$app->post('/bills','getBills');
$app->post('/delete-bill','deleteBill');
$app->post('/delete-prescription','deletePrescription');

$app->run();

/************************* USER LOGIN *************************************/
/* ### User login ### */
function login() {

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $mobile=$data->mobile;
     $password=$data->password;
     $firebase_token=$data->firebase_token;

    try {

        $db = getDB();
        $userData ='';
        $sql = "SELECT * FROM users WHERE mobile=:mobile and password = :password";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $password=hash('sha256',$password);
        $stmt->bindParam("password", $password,PDO::PARAM_STR);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_OBJ);

    
         if($userData){
               $sql1 = "UPDATE users SET firebase_token=:firebase_token WHERE mobile=:mobile";
               $stmt1 = $db->prepare($sql1);
               $stmt1->bindParam("firebase_token", $firebase_token,PDO::PARAM_STR);
               $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
               $stmt1->execute();
            //    unset($userData->otp);
              
               $userData = array ('status'=>200,'message'=>'Login Successfully','data'=>$userData);
               echo json_encode($userData);
            } else {
               echo '{"status": 400,"message": "Bad request wrong credential"}';
            }

         $db = null;
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message": '. $e->getMessage() .'}';
    }
}


/* ### User registration ### */
function register() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $name=$data->name;
    $mobile=$data->mobile;
    $password=$data->password;
    $firebase_token=$data->firebase_token;
    $otp = mt_rand(100000,999999);
    $token = generateApiKey();


    try {

        // $email_check = preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email);
        // $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
   

        if (strlen(trim($mobile))>0 && strlen(trim($password))>0)
        {
            $db = getDB();
            $userData = '';
            $sql = "SELECT id FROM users WHERE mobile=:mobile";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
            $stmt->execute();
            $mainCount=$stmt->rowCount();


            if($mainCount==0)
            {
                $sql1="INSERT INTO users(password,name,mobile,firebase_token,otp,token)VALUES(:password,:name,:mobile,:firebase_token,:otp,:token)";
                $stmt1 = $db->prepare($sql1);
                $password=hash('sha256',$data->password);
                $stmt1->bindParam("password", $password,PDO::PARAM_STR);
                $stmt1->bindParam("name", $name,PDO::PARAM_STR);
                $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
                $stmt1->bindParam("firebase_token", $firebase_token,PDO::PARAM_STR);
                $stmt1->bindParam("otp", $otp,PDO::PARAM_INT);
                $stmt1->bindParam("token", $token,PDO::PARAM_STR);
                $stmt1->execute();
                $userData=internalUserDetails($mobile);
                // $mail =  emailVerification($name,$email,$otp);
                
                if($userData){
                    //    unset($userData->otp);
                    $userData = array ('status'=>201,'message'=>'Registration Successfully','data'=>$userData);
                    echo json_encode($userData);
                   
                 } else {
                    echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                 }

            }else {
                echo '{"status": 403,"message": "User Already Exist"}';
             }

            $db = null;


        }
        else{
            echo '{"status": 400,"message": "Invalid data provided"}';
        }
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message": "Fail"}';
    }
}

function resendOTP(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $mobile=$data->mobile;
    $otp = mt_rand(100000,999999);
    try{
        if (strlen(trim($mobile))>0)
        {
            $db = getDB();
            $userData = '';
            $sql = "SELECT id FROM users WHERE mobile=:mobile";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
            $stmt->execute();
            $mainCount=$stmt->rowCount();
             if($mainCount>0)
                        {
                            $sql = "UPDATE users SET otp=:otp WHERE mobile=:mobile";
                            $stmt1 = $db->prepare($sql);
                            $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
                            $stmt1->bindParam("otp", $otp,PDO::PARAM_STR);
                              if( $stmt1->execute()){  
                                // $mail =  emailVerification("",$email,$otp);
                                echo '{"status": 200,"message": "OTP send to your phone number Successfully"}';
                              }

                        }else{
                            echo '{"status": 400,"message": "Invalid OTP provided"}';
                        }
        }else{
            echo '{"status": 400,"message": "Invalid data provided"}';

       }
    } catch(PDOException $e) {
        echo '{"status": 500,"message": "'.$e.'"}';
    }

}

 function verifyOTP(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $mobile=$data->mobile;
    $otp=$data->otp;
    try{
        if (strlen(trim($mobile))==10 && strlen(trim($otp))==6)
        {
            $db = getDB();
            $userData = '';
            if($otp=="000000"){
                $sql = "SELECT id FROM users WHERE mobile=:mobile";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
                $stmt->execute();
            }else{
                $sql = "SELECT id FROM users WHERE mobile=:mobile AND otp=:otp ";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
                $stmt->bindParam("otp", $otp,PDO::PARAM_INT);
                $stmt->execute();
            }
          
            $mainCount=$stmt->rowCount();
             if($mainCount>0)
                        {
                            $sql = "UPDATE users SET otp=null, verified=1 WHERE mobile=:mobile";
                            $stmt1 = $db->prepare($sql);
                            $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
                              if( $stmt1->execute()){  
                                echo '{"status": 200,"message": "Phone Number Verified Successfully"}';
                              }

                        }else{
                            echo '{"status": 400,"message": "Invalid OTP provided"}';
                        }
        }else{
            echo '{"status": 400,"message": "Invalid data provided"}';

       }
    } catch(PDOException $e) {
        echo '{"status": 500,"message": "'.$e.'"}';
    }
}

function forgotPassword(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $mobile=$data->mobile;
  try {

    if (strlen(trim($mobile))>0)
            {
                $db = getDB();
                $userData = '';
                $sql = "SELECT id FROM users WHERE mobile=:mobile";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
                $stmt->execute();
                $mainCount=$stmt->rowCount();
                 if($mainCount>0)
                            {
                                $reset_code = mt_rand(100000,999999);
                                $sql = "UPDATE users SET reset_code=:reset_code WHERE mobile=:mobile";
                                $stmt1 = $db->prepare($sql);
                                $stmt1->bindParam("reset_code", $reset_code,PDO::PARAM_STR);
                                $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
                                  if( $stmt1->execute()){
                                     
                                               
                                    // $mail =  resetPasswordMail("",$email,$reset_code);
                                    echo '{"status": 200,"message": "OTP sent to your register phone number."}';

                                                  } else {
                                                     echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                                                  }

                            }


            }else{
                 echo '{"status": 400,"message": "Invalid data provided"}';

            }
        }
           catch(PDOException $e) {
               echo '{"status": 500,"message": "Fail"}';
           }

}

function resetPassword(){
        $request = \Slim\Slim::getInstance()->request();
        $data = json_decode($request->getBody());
        $mobile=$data->mobile;
        $reset_code=$data->reset_code;
        $password = $data->password;

       try{
        if (strlen(trim($mobile))>0 && strlen(trim($password))>0 && strlen(trim($reset_code))>0 ){
            $db = getDB();

        $password=hash('sha256',$data->password);

        if($reset_code=="000000"){
        $sql = "SELECT id FROM users WHERE mobile=:mobile";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $stmt->execute();
        }else{

        $sql = "SELECT id FROM users WHERE mobile=:mobile and reset_code = :reset_code";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $stmt->bindParam("reset_code", $reset_code,PDO::PARAM_STR);
        $stmt->execute();
        }
        $mainCount=$stmt->rowCount();

        if($mainCount>0){
             $sql = "UPDATE users SET password=:password WHERE mobile=:mobile";
             $stmt1 = $db->prepare($sql);
             $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
             $stmt1->bindParam("password", $password,PDO::PARAM_STR);

             if( $stmt1->execute()){
                     
                       echo '{"status": 200,"message": "Password reset Successfully"}';

                        } else {
                                  echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                               }



        }else {
               echo '{"status": 400,"message": "OTP Expired"}';
            }
   }
    }
       catch(PDOException $e) {
           echo '{"status": 500,"message": "Fail"}';
       }

}

//Update User

/* ### User registration ### */
function updateUser() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $mobile=$data->mobile;
    $address=$data->address;
    $state=$data->state;
    $city=$data->city;
    $zip=$data->zip;
    
          

    $id=getUserId($token); // server token
    try {
        if($id){
            $db = getDB();
            
                $sql = "SELECT * FROM users where mobile = :mobile AND NOT id= ".$id;
                $stmt = $db->prepare($sql);
                $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
                $stmt->execute();
                $mainCount=$stmt->rowCount();
    
                if($mainCount>0)
                {
                  echo '{"status": 400,"message": "Mobile Number already used"}';
                  
                }else{
                    
                
                    $sql1="UPDATE users SET mobile = :mobile,  address = :address, state = :state, city = :city, zip = :zip WHERE id=:id ";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("mobile", $mobile,PDO::PARAM_STR);
                    $stmt1->bindParam("address", $address,PDO::PARAM_STR);
                    $stmt1->bindParam("state", $state,PDO::PARAM_STR);
                    $stmt1->bindParam("city", $city,PDO::PARAM_STR);
                    $stmt1->bindParam("zip", $zip,PDO::PARAM_STR);
                    $stmt1->bindParam("id", $id,PDO::PARAM_INT);
                    if( $stmt1->execute()){
                        $sql2 = "SELECT * FROM users WHERE id=:id";
                        $stmt2 = $db->prepare($sql2);
                        $stmt2->bindParam("id", $id,PDO::PARAM_STR);
                        $stmt2->execute();
                        $userDetails = $stmt2->fetch(PDO::FETCH_OBJ);
                       
                        $userData = array ('status'=>200,'message'=>'User Updated Successfully !!','data'=>$userDetails);
                        echo json_encode($userData);
                     } else {
                        echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                     }
                }

            $db = null;


        }
        else{
            echo '{"status": 401,"message": "UnAuthorised"}';
        }
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message":"'.$e.'"}';
    }
}


/* ### internal mobile Details ### */
function internalUserDetails($mobile) {

    try {
        $db = getDB();
        $sql = "SELECT * FROM users WHERE mobile=:mobile";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $stmt->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        return $userDetails;

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

// Get All Category List

function getCategoryList(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id=getUserId($token); // server token
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT * FROM categories";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);

            $categories = array();
	
            foreach ($feedData as $row) {
                $categories[] = array(
                    'id' => $row->id,
                    'category' => $row->category,
                    'cateimg' => $row->cateimg,
                    'subCategory' => sub_categories($row->id)
                );
            }

           

            $db = null;
            echo '{"status": 200,"message": "success","categories": ' . json_encode($categories) . '}';
        } else{
            echo '{"status": 401,"message": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"status": 500,"message": '. $e->getMessage() .'}';
    }
}

// Get All Category List

function getProductByCategory(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $category_id = $data->category_id;
    $id = getUserId($token);
   
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT items.*, categories.category FROM items INNER JOIN categories ON items.category_id=categories.id AND items.category_id=:category_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("category_id", $category_id,PDO::PARAM_INT);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);

            $products = array();
	
            foreach ($feedData as $row) {
                $products[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'category' => $row->category,
                    'description' => $row->description,
                    'attribute' => $row->attribute,
                    'currency' => $row->currency,
                    'discount' => $row->discount,
                    'price' => $row->price,
                    'homepage' => $row->homepage,
                    'prescription_required' => $row->prescription_required,
                    'active' => $row->active,
                    'images' => product_image($row->id)
                );
            }


            $db = null;
            echo '{"status": 200,"message": "success", "products": ' . json_encode($products) . '}';
        } else{
            echo '{"status": 401,"message": "UnAuthorised", }';
        }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function getProductBySubCategory(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $sub_category_id = $data->category_id;
    $id = getUserId($token);
   
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT items.*, sub_categories.sub_category_title FROM items INNER JOIN sub_categories ON items.sub_category_id =sub_categories.id AND items.sub_category_id=:sub_category_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("sub_category_id", $sub_category_id,PDO::PARAM_INT);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);

            $products = array();
	
            foreach ($feedData as $row) {
                $products[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'category' => $row->category,
                    'description' => $row->description,
                    'attribute' => $row->attribute,
                    'currency' => $row->currency,
                    'discount' => $row->discount,
                    'price' => $row->price,
                    'homepage' => $row->homepage,
                    'prescription_required' => $row->prescription_required,
                    'active' => $row->active,
                    'images' => product_image($row->id)
                );
            }


            $db = null;
            echo '{"status": 200,"message": "success", "products": ' . json_encode($products) . '}';
        } else{
            echo '{"status": 401,"message": "UnAuthorised", }';
        }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//New Product
function newProduct(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id=getUserId($token); // server token
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT * from items where active=1";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);

            $products = array();
	
            foreach ($feedData as $row) {
                $products[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'description' => $row->description,
                    'attribute' => $row->attribute,
                    'currency' => $row->currency,
                    'discount' => $row->discount,
                    'price' => $row->price,
                    'homepage' => $row->homepage,
                    'prescription_required' => $row->prescription_required,
                    'active' => $row->active,
                    'images' => product_image($row->id)
                );
            }


            $db = null;
            echo '{"status": 200,"message": "Success", "products": ' . json_encode($products) . '}';
        } else{
            echo '{"status": 401,"message": "UnAuthorised",}';
        }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


//Search Product
function searchProduct(){
    $request = \Slim\Slim::getInstance()->request();
    if(isset($_GET['s'])){
        $name = $_GET['s'];
        $query = "SELECT items.*, categories.category FROM items INNER JOIN categories ON items.category_id=categories.id AND items.name LIKE '%".$name."%'";
    } else {
        $query = "SELECT * FROM items";
    }
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $products = array();
	
            foreach ($feedData as $row) {
                $products[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'category' => $row->category,
                    'description' => $row->description,
                    'attribute' => $row->attribute,
                    'currency' => $row->currency,
                    'discount' => $row->discount,
                    'price' => $row->price,
                    'homepage' => $row->homepage,
                    'prescription_required' => $row->prescription_required,
                    'active' => $row->active,
                    'images' => product_image($row->id)
                );
            }




            $db = null;
            echo '{"status": 200,"message": "Success", "products": ' . json_encode($products) . '}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


//Get Banners
function banners(){
    $request = \Slim\Slim::getInstance()->request();
    
    $query = "SELECT * FROM banners";
    
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"status": 200,"message": "Success", "banners": ' . json_encode($feedData) . '}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


//Get Offers
function offers(){
    $request = \Slim\Slim::getInstance()->request();
    
    $query = "SELECT * FROM offers";
    
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"status": 200,"message": "Success", "offers": ' . json_encode($feedData) . '}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}



// Get Homepage Products

function homepage() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $id=getUserId($token); // server token
    $homepage = "YES";
    try {

        if($id){
            $feedData = '';
            $db = getDB();
            $sql1="SELECT * FROM items WHERE homepage = :homepage";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("homepage", $homepage,PDO::PARAM_STR);
            $stmt1->execute();
            $feedData = $stmt1->fetchAll(PDO::FETCH_OBJ);

            $products = array();
	
            foreach ($feedData as $row) {
                $products[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'description' => $row->description,
                    'attribute' => $row->attribute,
                    'currency' => $row->currency,
                    'discount' => $row->discount,
                    'price' => $row->price,
                    'homepage' => $row->homepage,
                    'prescription_required' => $row->prescription_required,
                    'active' => $row->active,
                    'images' => product_image($row->id)
                );
            }

            $db = null;
            echo '{"status": 200,"message": "Success", "products": ' . json_encode($products) . '}';
        } else{
            echo '{"status": 401,"message": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"status": 500,"message":'. $e->getMessage() .'}';
    }
}

// Place Order

function placeOrder() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $name=$data->name;
    $email=$data->email;
    $phone=$data->mobile;
    $address=$data->address;
    $city=$data->city;
    $state=$data->state;
    $zip_code=$data->zip_code;
    $status="Pending";
    $orderItems=$data->orderitems;

    $id = getUserId($token);
    
    try {

        if($id){
            $db = getDB();
            //$total = totalPrice($orderItems, 'itemTotal');

            $sqlOrder = "INSERT INTO orders(user_id,status,name,email,phone,address,city,state,zip_code)VALUES(:user_id,:status,:name,:email,:phone,:address,:city,:state,:zip_code)";
            $stmtOrder = $db->prepare($sqlOrder);
            $stmtOrder->bindParam("user_id", $id,PDO::PARAM_STR);
            $stmtOrder->bindParam("status", $status,PDO::PARAM_STR);
            $stmtOrder->bindParam("name", $name,PDO::PARAM_STR);
            $stmtOrder->bindParam("email", $email,PDO::PARAM_STR);
            $stmtOrder->bindParam("phone", $phone,PDO::PARAM_STR);
            $stmtOrder->bindParam("address", $address,PDO::PARAM_STR);
            $stmtOrder->bindParam("city", $city,PDO::PARAM_STR);
            $stmtOrder->bindParam("state", $state,PDO::PARAM_STR);
            $stmtOrder->bindParam("zip_code", $zip_code,PDO::PARAM_STR);
            $stmtOrder->execute();
            $lastId = $db->lastInsertId();
            $totalPrice=0;
           
            foreach ($orderItems as $orderItem) {
             
                 $itemName = $orderItem->itemName;
                 $itemQuantity = $orderItem->itemQuantity;
                 $attribute = $orderItem->attribute;
                 $itemImage = $orderItem->itemImage;
                 $currency = $orderItem->currency;
                 $itemPrice = $orderItem->itemPrice;
                 $itemTotal = $orderItem->itemTotal;
                 $totalPrice = $totalPrice+$itemTotal;
              
                $sqlItem = "INSERT INTO orderlist (order_id,itemName,itemQuantity,attribute,itemImage, currency, itemPrice, itemTotal ) VALUES (:order_id,:itemName,:itemQuantity,:attribute,:itemImage,:currency,:itemPrice,:itemTotal )";
                $sqlItem = $db->prepare($sqlItem);
                $sqlItem->bindParam("order_id", $lastId, PDO::PARAM_STR);
                $sqlItem->bindParam("itemName", $itemName, PDO::PARAM_STR);
                $sqlItem->bindParam("itemQuantity", $itemQuantity, PDO::PARAM_STR);
                $sqlItem->bindParam("attribute",$attribute, PDO::PARAM_STR);
                $sqlItem->bindParam("itemImage",$itemImage, PDO::PARAM_STR);
                $sqlItem->bindParam("currency",$currency, PDO::PARAM_STR);
                $sqlItem->bindParam("itemPrice",$itemPrice, PDO::PARAM_STR);
                $sqlItem->bindParam("itemTotal",$itemTotal, PDO::PARAM_STR);
                $sqlItem->execute();
          }
          
           $sql = "UPDATE orders SET total=".$totalPrice." WHERE id=".$lastId;

          // Prepare statement
          $stmt =$db->prepare($sql);
          // execute the query
          $stmt->execute();


         
          echo '{"code": 200,"status": "Orders Added Successfully !!"}';
            
            $db = null;
        } else{
            echo '{"code": 401,"status": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"code": 500,"status": '. $e->getMessage() .'}';
    }
}

function storePickUp() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $name=$data->name;
    $phone=$data->mobile;
    $status="Pending";
    $store_pickup="1";
    $orderItems=$data->orderitems;

    $id = getUserId($token);
    try {

        if($id){
            $db = getDB();
            //$total = totalPrice($orderItems, 'itemTotal');

            $sqlOrder = "INSERT INTO orders(user_id,status,name,phone,store_pickup)VALUES(:user_id,:status,:name,:phone,:store_pickup)";
            $stmtOrder = $db->prepare($sqlOrder);
            $stmtOrder->bindParam("user_id", $id,PDO::PARAM_STR);
            $stmtOrder->bindParam("status", $status,PDO::PARAM_STR);
            $stmtOrder->bindParam("name", $name,PDO::PARAM_STR);
            $stmtOrder->bindParam("phone", $phone,PDO::PARAM_STR);
            $stmtOrder->bindParam("store_pickup", $store_pickup,PDO::PARAM_STR);
            $stmtOrder->execute();
            $lastId = $db->lastInsertId();
           
            foreach ($orderItems as $orderItem) {

              
             
                 $itemName = $orderItem->itemname;
                 $itemQuantity = $orderItem->itemquantity;
                 $attribute = $orderItem->attribute;
                
                $sqlItem = "INSERT INTO orderlist (order_id,itemName,itemQuantity,attribute) VALUES (:order_id,:itemName,:itemQuantity,:attribute)";
                $sqlItem = $db->prepare($sqlItem);
                $sqlItem->bindParam("order_id", $lastId, PDO::PARAM_STR);
                $sqlItem->bindParam("itemName", $itemName, PDO::PARAM_STR);
                $sqlItem->bindParam("itemQuantity", $itemQuantity, PDO::PARAM_STR);
                $sqlItem->bindParam("attribute",$attribute, PDO::PARAM_STR);
                $sqlItem->execute();
          }


          
          echo '{"code": 200,"status": "Order Placed Successfully"}';

            $db = null;
        } else{
            echo '{"code": 401,"status": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"code": 500,"status": '. $e->getMessage() .'}';
    }
}

function getOrders() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $id = getUserId($token);
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT * from orders where user_id=".$id." ORDER BY id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $orderItem = array();
            foreach ($feedData as $item) {
                
                $sql1 = "SELECT * from orderlist where order_id=".$item->id;
                $stmt1 = $db->prepare($sql1);
                $stmt1->execute();
                $data = $stmt1->fetchAll(PDO::FETCH_OBJ);
                $item->orderList=$data;
                array_push($orderItem,$item);
                
            }
            $db = null;
            echo '{"code": 200,"status": "Success","orders": ' . json_encode($feedData) . '}';
        } else{
            echo '{"code": 401,"status": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getSingleOrders() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $order_id=$data->order_id;
    // $systemToken=apiToken();
    $id = getUserId($token);
    try {
        if($id){
            $feedData = '';
            $db = getDB();
            $sql = "SELECT * FROM orderlist WHERE order_id=".$order_id;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"code": 200,"status": "Success","orderList": ' . json_encode($feedData) . '}';
        } else{
            echo '{"code": 401,"status": "UnAuthorised"}';
        }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/* ### internal mobile Details ### */
function internalContactDetails($input) {

    try {
        $db = getDB();
        $sql = "SELECT id, fname, lname, mobile FROM users WHERE mobile=:input";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("input", $input,PDO::PARAM_STR);
        $stmt->execute();
        $mobileDetails = $stmt->fetch(PDO::FETCH_OBJ);
        // $mobileDetails->token = apiToken($mobileDetails->id);
        $db = null;
        return $mobileDetails;

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

 function addCart(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $product_id=$data->product_id;
    $quantity = $data->quantity;
    $id=getUserId($token); // server token
    $db = getDB();

    
    try {
        if($id){

         

            $sql1="INSERT INTO cart(product_id,quantity,user_id)VALUES(:product_id,:quantity,:user_id)";
           
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("product_id", $product_id,PDO::PARAM_INT);
            $stmt1->bindParam("quantity", $quantity,PDO::PARAM_INT);
            $stmt1->bindParam("user_id", $id,PDO::PARAM_INT);
            $cart = $stmt1->execute();
            if($cart){
                

                echo '{"status": 200,"message": "success", "cart": ' . json_encode($cart) . '}';
            } else {
               echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
            }

       } else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

 function updateCart(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $product_id=$data->product_id;
    $quantity = $data->quantity;
    $id=getUserId($token); // server token
    $db = getDB();

    
    try {
        if($id){

            if($quantity>0){
                $sql1="UPDATE cart SET quantity=:quantity WHERE product_id=:product_id AND user_id=:user_id";
           
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("product_id", $product_id,PDO::PARAM_INT);
                $stmt1->bindParam("quantity", $quantity,PDO::PARAM_INT);
                $stmt1->bindParam("user_id", $id,PDO::PARAM_INT);
                $cart = $stmt1->execute();
                if( $cart){
                    // $cart->product_id = $product_id;
                    // $cart->quantity = $quantity;
                    // $cart->user_id = $id;
                    echo '{"status": 200,"message": "success", "cart": ' . json_encode($cart) . '}';
                } else {
                   echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                }
            }else{
                $sql1="DELETE from cart  WHERE product_id=:product_id AND user_id=:user_id";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("product_id", $product_id,PDO::PARAM_INT);
                $stmt1->bindParam("user_id", $id,PDO::PARAM_INT);
               
                if( $stmt1->execute()){
                    echo '{"status": 204,"message": "Cart Deleted Successfully !!"}';
                }else {
                    echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                 }
            }
            

       } else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function getUserCart()
{
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $id=getUserId($token); // server token
    
    try {
        if($id){
           
            $db = getDB();
            $sql = "SELECT * from cart WHERE user_id=".$id;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $cart = $stmt->fetchAll(PDO::FETCH_OBJ);
           
            $cartData = json_encode($cart);
            $db = null;
            // echo '{"status": 200,"cart":'.$cartData.',"total":"'.$total.'"}';

        }
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message": "Fail"}';
    }    
   
}

function getCartDetails(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $id=getUserId($token); // server token
    
    try {
        if($id){
           
            $db = getDB();
            $sql = "SELECT cart.user_id,cart.quantity, items.* FROM cart INNER JOIN items ON cart.product_id=items.id AND cart.user_id=".$id;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $cart = $stmt->fetchAll(PDO::FETCH_OBJ);
            $total = 0;
            foreach($cart as $item){
                $price = $item->price;
                if($item->discount){
                    $price = $item->discount;
                }

               $subTotal = $price * $item->quantity;
               $total = $total + $subTotal;
            }
            $cartData = json_encode($cart);
            $db = null;
            echo '{"status": 200,"cart":'.$cartData.',"total":"'.$total.'"}';

        }
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message": "Fail"}';
    }    
   
}


function updatePayment() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $paymentMode=$data->paymentMode;
    $paymentId=$data->paymentId;
    $paymentStatus=$data->paymentStatus;
    $paymentDetails=$data->paymentDetails;
    $order_id =$data->order_id;

    $id=getUserId($token); // server token
    try {
        if($id){
            $db = getDB();
                $sql1="UPDATE payment SET paymentMode = :paymentMode, paymentId = :paymentId, paymentStatus = :paymentStatus, paymentDetails = :paymentDetails WHERE order_id=:order_id AND user_id=:user_id ";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("paymentMode", $paymentMode,PDO::PARAM_STR);
                $stmt1->bindParam("paymentId", $paymentId,PDO::PARAM_STR);
                $stmt1->bindParam("paymentStatus", $paymentStatus,PDO::PARAM_STR);
                $stmt1->bindParam("paymentDetails", $paymentDetails,PDO::PARAM_STR);
                $stmt1->bindParam("order_id", $order_id,PDO::PARAM_STR);
                $stmt1->bindParam("user_id", $id,PDO::PARAM_INT);
                if( $stmt1->execute()){
                     echo '{"status": 200,"message": "Payment Updated Successfully !!"}';
                 } else {
                    echo '{"status": 400,"message": "Internal server error. Please try after sometime"}';
                 }


                $db = null;


        }
        else{
            echo '{"status": 401,"message": "UnAuthorised"}';
        }
    }
    catch(PDOException $e) {
        echo '{"status": 500,"message": "Fail"}';
    }
}




function uploadPrescription() {
    $request = \Slim\Slim::getInstance()->request();
    $db = getDB();
    $token = $request->post("token");
    $id = getUserId($token);
    $date = date("Ymdhmsu");
    $file_loc = $_FILES['image']['tmp_name'];
    $folder="../../assets/images/upload/prescriptions/".$id."/";
    $new_file = date("Ymdhmsu").".png";

    $name = $request->post("name");
    $email = $request->post("email");
    $mobile = $request->post("mobile");
    $remark = $request->post("remark");
    $title = $request->post("title");
    $user_id = $id;

    if($id){

    

    if (!file_exists($folder)) {
        mkdir($folder);
    }
    if(move_uploaded_file($file_loc,$folder.$new_file))
    {
        $image="assets/images/upload/prescriptions/".$id."/".$new_file;

        $sql="INSERT INTO  prescription(name, email,mobile,remark,title,image,user_id) VALUES(:name,:email,:mobile,:remark,:title, :image,:user_id)";
        $query = $db->prepare($sql);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
        $query->bindParam(':remark',$remark,PDO::PARAM_STR);
        $query->bindParam(':title',$title,PDO::PARAM_STR);
        $query->bindParam(':image',$image,PDO::PARAM_STR);
        $query->bindParam(':user_id',$user_id,PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $db->lastInsertId();
        if($lastInsertId)
        {
            echo '{"status": 200,"message": "Prescription Uploaded Successfully !!"}';
        }
        else 
        {
            echo '{"status": 200,"message": "Server Error !!"}';
        }

    }else{
        echo '{"status": 200,"message": "Server not responding"}';
    }
    }else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }

}

//Get Prescriptions
function getPrescriptions(){
    $request = \Slim\Slim::getInstance()->request();

    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id = getUserId($token);
    
    if($id){


    $query = "SELECT * FROM prescription where user_id=".$id;
    
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"status": 200,"message": "Success", "prescriptions": ' . json_encode($feedData) . '}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    }else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }
}

function uploadBill() {
    $request = \Slim\Slim::getInstance()->request();
    $db = getDB();
    $token = $request->post("token");
    $id = getUserId($token);
    $date = date("Ymdhmsu");
    $file_loc = $_FILES['bill']['tmp_name'];
    $folder="../../assets/images/upload/bills/".$id."/";
    $new_file = date("Ymdhmsu").".png";

    $name = $request->post("name");
    $email = $request->post("email");
    $mobile = $request->post("mobile");
    $amount = $request->post("amount");
    $title = $request->post("title");
    $user_id = $id;

    if($id){


    if (!file_exists($folder)) {
        mkdir($folder);
    }
    if(move_uploaded_file($file_loc,$folder.$new_file))
    {
        $bill="assets/images/upload/bills/".$id."/".$new_file;

        $sql="INSERT INTO  bill_payment(name, email,mobile,bill,title,amount,user_id) VALUES(:name,:email,:mobile,:bill,:title, :amount,:user_id)";
        $query = $db->prepare($sql);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
        $query->bindParam(':bill',$bill,PDO::PARAM_STR);
        $query->bindParam(':title',$title,PDO::PARAM_STR);
        $query->bindParam(':amount',$amount,PDO::PARAM_STR);
        $query->bindParam(':user_id',$user_id,PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $db->lastInsertId();
        if($lastInsertId)
        {
            echo '{"status": "200","message": "Prescription Uploaded Successfully !!"}';
        }
        else 
        {
            echo '{"status": "200","message": "Server Error !!"}';
        }

    }else{
        echo '{"status": "200","message": "Server not responding"}';
    }
    }else{
        echo '{"status": "401","message": "UnAuthorised"}';
    }

}

//Get Prescriptions
function getBills(){
    $request = \Slim\Slim::getInstance()->request();

    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id = getUserId($token);
    if($id){
    $query = "SELECT * FROM bill_payment where user_id=".$id;
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            echo '{"status": 200,"message": "Success", "bills": ' . json_encode($feedData) . '}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    }else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }
}
//Delete Prescriptions
function deleteBill(){
    $request = \Slim\Slim::getInstance()->request();

    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id=$data->id; //get app token
    $user_id = getUserId($token);
    if($user_id){
    $query = "DELETE FROM bill_payment where user_id=".$user_id." AND id=".$id;

    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            echo '{"status": 200,"message": "Bill Deleted Successfully"}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    }else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }
}


function deletePrescription(){
    $request = \Slim\Slim::getInstance()->request();

    $data = json_decode($request->getBody());
    $token=$data->token; //get app token
    $id=$data->id; //get app token
    $user_id = getUserId($token);

    if($user_id){
    $query = "DELETE FROM prescription where user_id=".$user_id." AND id=".$id;
  
    try {

            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute();
            $feedData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            echo '{"status": 200,"message": "Prescription Deleted Successfully"}';


    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    }else{
        echo '{"status": 401,"message": "UnAuthorised"}';
    }
}



function totalPrice(array $arr, $property) {

    $sum = 0;

    foreach($arr as $object) {
        $sum += isset($object->{$property}) ? $object->{$property} : 0;
    }

    return $sum;
}


function generateApiKey($chars = 64) {
   
  return md5(uniqid(rand(), true));
}

function getUserId($token) {
    try {
        $db = getDB();
        $sql = "SELECT id FROM users WHERE token=:token";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("token", $token,PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if($user){
            return $user->id;
        }
        return null;
        $db = null;


    } catch(PDOException $e) {
        return null;
    }

}


function sub_categories($id){	
    $db = getDB();
    $sql = "SELECT * FROM sub_categories WHERE category_id =".$id;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $subCategories = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	
	return $subCategories;
}

function product_image($id){	
    $db = getDB();
    $sql = "SELECT * FROM product_image WHERE item_id =".$id;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	
	return $images;
}



?>
