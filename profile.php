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
                <img src="profile_images/<?php echo $user_data->user_image;?>" alt="Profile image">
            </div>
            <h1><?php echo $user_data->username;?></h1>
        </div>


        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer" class="active">Home</a></li>

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

        <div class="all_users">
            <h3>All Users</h3>
            <div class="usersWrapper">
                <?php
                if($all_users){
                    foreach($all_users as $row){
                        echo '<div class="user_box">
                                <div class="user_img"><img src="profile_images/'.$row->user_image.'" alt="Profile Image"></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->id.'" class="see_profileBtn">See Profile</a></span></div>
                                </div>';
                    }
                }
                else{
                    echo '<h4>There is no User!</h4>';
                }
                ?>
            </div>
        </div>

        <hr>
        <div class="card-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text"  name= "get_email" class="form-control" placeholder="Enter email ID" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="fetch_btn" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="all_users">
            <h3>Search results</h3>
            <div class="usersWrapper">
                <?php

                if($all_users){
                    $flag = 0;
                    foreach($all_users as $row){

                        if($row->user_email === $s_id && $s_id !== ''){
                            $flag =1;
                            echo '<div class="user_box">
                                <div class="user_img"><img src="profile_images/'.$row->user_image.'" alt="Profile Image"></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->id.'" class="see_profileBtn">See Profile</a></span></div>
                                </div>';
                        }




                    }
                    if($flag=== 0 && $s_id !== ''){
                        echo '<h4>User not registered</h4>';
                    }
                }

                else{
                    echo '<h4>There is no User!</h4>';
                }
                ?>
            </div>
        </div>

    </div>
</body>
</html>