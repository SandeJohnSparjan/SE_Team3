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

//username
$uname = $user_data->username;

$s_id = '';
if(isset($_POST['fetch_btn'])) {
    $s_id = $_POST['get_email'];
}

$email_id = '';
if(isset($_POST['add'])) {
    $email_id = $_POST['name[]'];
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
            <li><a href="groups.php" rel="noopener noreferrer">Groups</a></li>

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

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="profile_container">
                    <div class="user_box"><span><h2>Create Groups</h2></span></div>
                    <div class="form-group">
                        <form name="add_name" id="add_name">


                        <br />
                        <br />
                                <div class="table-responsive">
                                    <label for="group_name">Group Name:
                                        <input type="text" name="group_name" placeholder="Enter Group Name">
                                    </label>
                                    <label for="description">Description
                                        <input type="text" name="description" placeholder="Expense Description">
                                    </label>
                                    <label for="group_name">Add Group Members: </label>
                                    <table class="table table-bordered" id="dynamic_field">
                                        <tr>
                                            <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" required></td>
<!--                                                --><?php
//
//                                                if($all_users){
//                                                    $flag = 0;
//                                                    foreach($all_users as $row){
//
//                                                        if($row->user_email === $email_id && $email_id !== ''){
//                                                            $flag =1;
//                                                            echo '<p>User Present</p>';
//                                                        }
//                                                    }
//                                                    if($flag === 0 && $email_id !== ''){
//                                                        echo '<h4>User not registered</h4>';
//                                                    }
//                                                }
//
//                                                else{
//                                                    echo '<h4>There is no User!</h4>';
//                                                }
//                                                ?>

                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                                        </tr>
                                    </table>
<!--                                    <label for="amount">Amount:-->
<!--                                        <input type="text" name="amount" placeholder="Enter amount">-->
<!--                                    </label>-->
<!--                                    <label for="split_type">Split type:-->
<!--                                        <input type="text" name="Split Type" placeholder="Enter Group Name">-->
<!--                                    </label>-->
                                    <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
                                </div>
                            </form>
                        </div>

                    <script>
                        $(document).ready(function(){
                            var i=1;
                            $('#add').click(function(){
                                i++;
                                $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                            });
                            $(document).on('click', '.btn_remove', function(){
                                var button_id = $(this).attr("id");
                                $('#row'+button_id+'').remove();
                            });
                            $('#submit').click(function(){
                                $.ajax({
                                    url:"group_emails.php",
                                    method:"POST",
                                    data:$('#add_name').serialize(),
                                    success:function(data)
                                    {
                                        //alert(data);
                                        $('#add_name')[0].reset();
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col">
<!--                <div class="card-body">-->
<!--                    <form action="" method="POST">-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-6">-->
<!--                                <div class="form-group">-->
<!--                                    <input type="text"  name= "get_email" class="form-control" placeholder="Enter email ID" required>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-6">-->
<!--                                <button type="submit" name="fetch_btn" class="btn btn-primary">Search</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
                <div class="profile_container">
                    <?php

                    $connect = mysqli_connect("localhost", "root", "", "easyroommate");
                    $reg1= "select group_name,grp_members from groups";//inserting expense details into database

                    $new1=mysqli_query($connect,$reg1);

                    while($row = mysqli_fetch_assoc($new1)) {

                        $name = $row['grp_members'];
                        $g_name = $row['group_name'];
                        $name_explode = explode(",", $row['grp_members']);
                        foreach ($name_explode as $name_user)
                        if($uname === $name_user){
                            echo '<div class="user_box">
                                <div class="user_info"><span>Group Name: '.$g_name.'</span></div>';
                            echo '<div class="user_info"><span>Group Members:</span>';

                            foreach($name_explode as $i){
                                echo '<span>'.$i.' </span>';

                                }
                                '</div></div>';
                        }
                    }

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
    </div>
</div>
</body>
</html>

