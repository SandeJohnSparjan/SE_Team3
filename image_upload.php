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

$s_id = '';
if(isset($_POST['fetch_btn'])) {
    $s_id = $_POST['get_email'];
}

//requesting notification number
$get_req_num = $friend_obj->req_notification($_SESSION['user_id'], false);
//total friends
$get_frnd_num = $friend_obj->get_all_friends($_SESSION['user_id'], false);

//image upload
if (isset($_POST['submit'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], "profile_images/" . $_FILES['file']['name']);
    $con = mysqli_connect("localhost", "root", "", "easyroommate");
    $q = mysqli_query($con, "UPDATE users SET user_image = '" . $_FILES['file']['name'] . "' WHERE id = '" . $_SESSION['user_id'] . "'");
//    $upload_image = $user_obj->upload_image($_SESSION['user_id'], false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username ;?></title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<div class="profile_container">
    <div class="inner_profile">
        <div class="img">
            <img src="profile_images/<?php echo $user_data->user_image;?>" class="img-fluid" alt="Profile image">
        </div>
        <h1><?php echo $user_data->username;?></h1>
    </div>


    <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer" >Home</a></li>

                <li><a href="expense.php" rel="noopener noreferrer">Add an Expense</a></li>
                <li><a href="balance.php" rel="noopener noreferrer">Balance</a></li>
                <li><a href="groups_create.php" rel="noopener noreferrer">Groups</a></li>

                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Edit
                </button>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                        if($get_req_num > 0){
                            echo 'redBadge';
                        }
                        ?>"><?php echo $get_req_num;?></span></a>
                    <a class="dropdown-item" href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a>
                    <a class="dropdown-item" href="image_upload.php" rel="noopener noreferrer">Change Pic</a>
                    <a class="dropdown-item" href="logout.php" rel="noopener noreferrer">Logout</a>
                </div>
            </ul>
        </nav>
<div class="inner_profile">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" placeholder="Upload a file">
        <input type="submit" name="submit"><br><br>
		<label> Image dimensions should be less than 600x800 pixels </label>
    </form>

</div>

</div>


</body>
</html>




<?php
//    require 'includes/init.php';
//    if(isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
//        if (isset($_POST['submit'])) {
//            move_uploaded_file($_FILES['file']['tmp_name'], "profile_images/" . $_FILES['file']['name']);
//            $con = mysqli_connect("localhost", "root", "", "easyroommate");
//            $q = mysqli_query($con, "UPDATE users SET user_image = '" . $_FILES['file']['name'] . "' WHERE id = '" . $_SESSION['user_id'] . "'");
//        }
//    }
//?>

<!--<!DOCTYPE html>-->
<!--<html>-->
<!--    <head>-->
<!---->
<!--    </head>-->
<!--    <body>-->
<!--        <form action="" method="post" enctype="multipart/form-data">-->
<!--            <input type="file" name="file">-->
<!--            <input type="submit" name="submit">-->
<!--        </form>-->
<!---->
<!---->
<!--<?php
        if($q){
            header('Location: profile.php');
            exit;
        }
////            $con = mysqli_connect("localhost","root","","easyroommate");
////            $q = mysqli_query($con,"SELECT * FROM users");
////            while($row = mysqli_fetch_assoc($q)){
////                echo $row['username'];
////                if($row['user_image'] == ""){
////                    echo "<img width='100' height='100' src='profile_images/default.jpg' alt='Default Profile Pic'>";
////                } else {
////                    echo "<img width='100' height='100' src='profile_images/".$row['user_image']."' alt='Profile Pic'>";
////                }
////                echo "<br>";
////            }
////        ?>
  </body>-->
<!--</html>-->


