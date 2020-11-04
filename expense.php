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
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer" class="active">Home</a></li>

                <li><a href="expense.php" rel="noopener noreferrer">Add an Expense</a></li>
								<li><a href="balance.php" rel="noopener noreferrer">Balance</a></li>


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

        <div class="add">
<center ><b>&nbsp &nbsp ADD AN EXPENSE</b></center>
<br></br>
<div class="container-fluid" style="border:1px solid #cecece;">
<br>
<form action="expense_added.php" method="post">
<b>Description</b> &nbsp 
<input type="text" name="description" required /> <br><br><br>
<b>Paid by:&nbsp&nbsp&nbsp&nbsp&nbsp
<?php $mysqli = new mysqli("localhost", "root", "", "easyroommate"); 

if ($mysqli ==false) { 
	die("ERROR: Could not connect. ".$mysqli->connect_error); 
} 
$result=mysqli_query($mysqli,"select * from users");
echo"<select name='paid_by' id='paid_by'>";
echo "<option> Select Person Who Paid the expense</option>";
while($row=mysqli_fetch_array($result))
{
	echo "<option id='user1'>$row[username]</option>";
}
echo"</select> <br></br>";

echo "Share With:&nbsp";
$result=mysqli_query($mysqli,"select * from users");
echo"<select name='share_with' id='share_with'>";

echo "<option> -- Select Person Whom you want to share the expense with--</option>";
while($row=mysqli_fetch_array($result))
{
	echo "<option id='user2'>$row[username]</option>";
}
echo"</select>";


?> </b>
<br></br>

<b>Amount:</b> &nbsp&nbsp&nbsp &nbsp&nbsp<input type="text" name="amount"required /> <br><br>
<center>
<input type="submit" name="expense_button" value="Submit" /><br></br>
</center>
</form>
</div>
    </div>
	</div>
	</div>
</body>
</html>

