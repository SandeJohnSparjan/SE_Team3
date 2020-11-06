<?php

require 'includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data===false){
        header('Location: logout.php');
    }

    // fetch all users except me
    $all_users = $user_obj->all_users($_SESSION['user_id']);
}
else{
    header('Location: logout.php');
    exit;
}

$connect = mysqli_connect("localhost", "root", "", "easyroommate");
$number = count($_POST["name"]);

$grp_name = $_POST["group_name"];
$desc = $_POST["description"];


$groups = [$user_data->username];

for($i=0; $i<$number; $i++)
{
    if(trim($_POST["name"][$i] != ''))
    {
        //$sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
        //mysqli_query($connect, $sql);
        array_push($groups,$_POST["name"][$i]);
    }
}

$groups_values = implode(",", $groups);

echo $groups_values[0];


if($number > 2)
{
//    $sql = "INSERT INTO groups (users) VALUES ('$groups_values')";
//    $exe = mysqli_query($connect,$sql);


    $reg= "insert into groups (group_name,description,grp_members) values ('$grp_name','$desc','$groups_values')";//inserting expense details into database
    mysqli_query($connect,$reg);

    $reg1= "select grp_members from groups";//inserting expense details into database

    $new1=mysqli_query($connect,$reg1);

    while($row = mysqli_fetch_assoc($new1)){

        $name = $row['grp_members'];
        $name_explode = explode(",",$row['grp_members']);

        echo "name : ".$name."<br>";
        //echo $name_explode[1];
        foreach($name_explode as $i){
            echo ' ';
            echo $i;
        }
    }



}
else
{
    echo "Please Enter Name";
}
?>

