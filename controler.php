<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("db.php");


/// displying state according to country ///
if (isset($_POST['country']) && $_POST['type']=="select") {

$country=$_POST['country'];
    $countryArr = array(
        "usa" => array("New Yourk", "Los Angeles", "California"),
        "india" => array("Mumbai", "New Delhi", "Bangalore"),
        "uk" => array("London", "Manchester", "Liverpool")
    );

if ($country !=='select') {

    echo '<select id="inputState" name="state"  class="form-control state-selected">';
    foreach($countryArr[$country] as $value){
        echo "<option vlaue='$value'>". $value . "</option>";
    }
    echo "</select>";

}



}


/// uploding the image ///

if($_FILES['file']['name']!=""){
   
$valid_extensions = array('jpeg', 'jpg','png'); 

       
        
        $size= $_FILES['file']['size'];
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if($size > 2097152) 
        {
            echo json_encode(array("statusCode"=>400,'msg'=>"Image allowd less than 2 mb"));
        }
        else if(!in_array($ext, $valid_extensions)) {
            echo json_encode(array("statusCode"=>400,'msg'=>$ext.' not allowed'));
        }
        else{
           
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' .$_FILES['file']['name'] );
            echo $_FILES['file']['name'];
                   }
        
    
}




/// Adding the user ////
if (isset($_POST['email']) && isset($_POST['firstname']) ) {
    

    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $pincode=$_POST['pincode'];
    $img=$_POST['img'];

    if ($img!="") {
       $image=$img; 
    }else{
        $image=null;
    }

$sql=mysqli_query($conn,"INSERT INTO `users`(`firstname`, `lastname`, `email`, `phone`, `country`, `state`, `pincode`, `img`) VALUES ('$firstname','$lastname','$email','$phone','$country','$state','$pincode','$image')");


if ($sql) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>user added!</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
    
   
}

/// fetching the user data to show in edit form///

if ($_POST['id']!="") {
    $id=$_POST['id'];
  
   $sql=mysqli_query($conn,'SELECT * FROM `users` where user_id="'.$id.'"');
   if($row = mysqli_fetch_assoc($sql)){
       
    $firstname=$row['firstname'];
    $lastname=$row['lastname'];
    $email=$row['email'];
    $phone=$row['phone'];
    $country=$row['country'];
    $state=$row['state'];
    $pincode=$row['pincode'];
    $img=$row['img'];


    $userdata=[
"userid"=>$id,
"firstname"=>$firstname,
"lastname"=>$lastname,
"email"=>$email,
"phone"=>$phone,
"country"=>$country,
"state"=>$state,
"pincode"=>$pincode,
"img"=>$img
    ];

   echo json_encode(array($userdata));


   } 
}

/// updateing the user data ///

if (isset($_POST['updateemail']) && isset($_POST['updatefirstname']) ) {
    

    $firstname=$_POST['updatefirstname'];
    $lastname=$_POST['updatelastname'];
    $email=$_POST['updateemail'];
    $phone=$_POST['updatephone'];
    $country=$_POST['updatecountry'];
    $state=$_POST['updatestate'];
    $pincode=$_POST['updatepincode'];
    $img=$_POST['updateimg'];
    $userid=$_POST['updateuserid'];

    if ($img!="") {
       $image=$img; 
    }else{
        $image=null;
    }

$sql=mysqli_query($conn,"UPDATE `users` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`phone`='$phone',`country`='$country',`state`='$state',`pincode`='$pincode',`img`='$image' WHERE user_id='$userid'");

if ($sql) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>user added!</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

}
/// deleting the user data ///
if (isset($_POST['userid']) && $_POST['status']=="delete") {
    $userid=$_POST['userid'];
  $sql=mysqli_query($conn,"DELETE FROM `users` WHERE user_id=$userid");

  if($sql){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>user deleted!</strong> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
    # code...
}


?>