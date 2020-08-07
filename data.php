<?php
   include_once("db.php");
/// sending data to datatable ///
   $sql=mysqli_query($conn,'SELECT `user_id`,`firstname`, `lastname`, `email`, `phone`, `country`, `state`, `pincode` FROM `users`');
   $row=array();
 $i=1;
   while($row = mysqli_fetch_assoc($sql)) {
       $id=$row['user_id'];
       $row['sno']=$i;
    $row['edit']=$id;
    $row['delete']=$id;
        $i++;
    $array[] = $row;
}

$dataset = array(
    "echo" => 1,
    "totalrecords" => count($array),
    "totaldisplayrecords" => count($array),
    "data" => $array
);

echo json_encode($dataset);

 ?>  
 