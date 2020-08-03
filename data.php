<?php
   include_once("db.php");
/// sending data to datatable ///
   $sql=mysqli_query($conn,'SELECT `user_id`,`firstname`, `lastname`, `email`, `phone`, `country`, `state`, `pincode` FROM `users`');
   $row=array();
 $i=1;
   while($row = mysqli_fetch_assoc($sql)) {
       $id=$row['user_id'];
       $row['sno']=$i;
    $row['edit']='<button type="button" class="btn btn-success btn-sm "  onclick="edit('.$id.')" >edit</button>';
    $row['delete']='<button type="submit" id="submit" onclick="deleteuser('.$id.')" class="btn btn-danger btn-sm">Delete</button';
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
 