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

//expense button
if(isset($_POST['submit'])) {
    if (isset($_POST['description']) && isset($_POST['paid_by']) && isset($_POST['share_with']) && isset($_POST['amount'])) {
        $result = $expenses_obj->insertExpense($_POST['description'], $_POST['paid_by'], $_POST['share_with'], $_POST['amount']);

    } else {
        $result['errorMessage'] = 'Fields are filled.';
    }
}



$s_id = '';
if(isset($_POST['fetch_btn'])) {
    $s_id = $_POST['get_email'];
}

//requesting notification number
$get_req_num = $friend_obj->req_notification($_SESSION['user_id'], false);
//total friends
$get_frnd_num = $friend_obj->get_all_friends($_SESSION['user_id'], false);

//get_all_friends
$get_all_friends = $friend_obj->get_all_friends($_SESSION['user_id'], true);

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
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


           <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer" >Home</a></li>

                <li><a href="expense.php" rel="noopener noreferrer" class="active">Add an Expense</a></li>
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


        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="login_signup_container groups_container" >
                        <div class="form-group">
                            <form action="" method="POST" name="add_name" id="add_name">
                                <div class="table-responsive">
                                    <table><tr><th>Create An Expense</th></tr></table>

                                    <table class="table table-bordered" id="dynamic_field">

                                        <tr>
                                            <td><label for="description">Description:</label></td>
                                            <td><input type="text" name="description"  required /> </td>
                                        </tr>
                                        <tr>
                                            <td><label for="paid_by">
                                                    Paid By: </label>
                                               </td>
                                            <td> <select name='paid_by' id='paid_by'>
                                                    <?php
                                                    echo '<option id="user1">'.$user_data->username.'</option>';
                                                    foreach ($get_all_friends as $row){
                                                        echo '<option>'.$row->username.'</option>';
                                                    }?>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td><label for="share_with">Share with: </label>
                                                </td>
                                            <td><select name='share_with' id='share_with'>
                                                    <?php
                                                    echo '<option value="" disabled selected>Select User</option>';
                                                    foreach ($get_all_friends as $row){
                                                        echo '<option>'.$row->username.'</option>';
                                                    }?>
                                                </select></td>
                                        </tr>

                                        <tr>
                                            <td><label for="amount">Amount:</label></td>
                                            <td><input type="text" name="amount" required /></td>
                                        </tr>

                                    </table>
                                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                                </div>

                            </form>
                            <div>
                                <?php
                                if(isset($result['errorMessage'])){
                                    echo '<p class="errorMsg">'.$result['errorMessage'].'</p>';
                                }
                                if(isset($result['successMessage'])){
                                    echo '<p class="successMsg">'.$result['successMessage'].'</p>';
                                }
                                ?>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="col">
                    <div class="profile_container">
                        <div class="all_users">

                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
	</div>
</body>
</html>

