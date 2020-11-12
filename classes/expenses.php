<?php

class Expenses
{
    protected $db;
    protected $desc;
    protected $amount;
    protected $user1;
    protected $user2;
    protected $amount1;
    protected $amount2;

    function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    function insertExpense($desc, $paid_by, $share_with, $amount)
    {
        $this->desc = $desc;

        $this->user1 = $paid_by;
        $this->user2 = $share_with;
        $this->amount = $amount;

        $this->amount1 = $amount / 2;
        $this->amount2 = $amount / 2;



        if (!empty($this->desc) && !empty($this->amount) && !empty($this->user1) && !empty($this->user2)) {
            $sql = "INSERT INTO expense(exp_name,amount1,amount2,user1,user2,total_amount,paid_by) VALUES (:exp_name,:amount1,:amount2,:user1,:user2,:total_amount,:paid_by)";

            $register_stmt = $this->db->prepare($sql);
            $register_stmt->bindValue(':exp_name', $this->desc, PDO::PARAM_STR);
            $register_stmt->bindValue(':amount1', $this->amount1, PDO::PARAM_INT);
            $register_stmt->bindValue(':amount2', $this->amount2, PDO::PARAM_INT);
            $register_stmt->bindValue(':user1', $this->user1, PDO::PARAM_STR);
            $register_stmt->bindValue(':user2', $this->user2, PDO::PARAM_STR);
            $register_stmt->bindValue(':total_amount', $this->amount, PDO::PARAM_INT);
            $register_stmt->bindValue(':paid_by', $this->user1, PDO::PARAM_INT);

            $register_stmt->execute();

            return ['successMessage' => 'Expense added successfully.'];


        } else {
            return ['errorMessage' => 'Please fill the fields.'];
        }
    }
}


//$desc=$_POST['description'];
//$amount=$_POST['amount'];
//$paid_by = $_POST['paid_by'];
//if (isset($_POST['paid_by'])) {
//$user1 = $_POST['paid_by'];
//}
//if (isset($_POST['share_with'])) {
//    $user2 = $_POST['share_with'];
//}
//
//$mysqli = new mysqli("localhost", "root", "", "easyroommate");
//if ($mysqli ==false) {
//    die("ERROR: Could not connect. ".$mysqli->connect_error);
//}
//$reg=" insert into expense(exp_name,amount1,amount2,user1,user2,total_amount,paid_by) values ('$exp_name','$amount1','$amount1','$user1','$user2','$amount','$paid_by')";//inserting expense details into database
//$query=mysqli_query($mysqli,$reg);
//// $ex1="SELECT SUM(amount1) as sum FROM expense WHERE user1='shravani'";
//$ex1 = mysqli_query($mysqli, "SELECT SUM(amount1) as sum1 FROM expense WHERE user1='$user1'");
//$row = mysqli_fetch_assoc($ex1);
//$sum1 = $row['sum1'];
//echo "<script> alert('Expense succesfully added'); </script>";
//
//}