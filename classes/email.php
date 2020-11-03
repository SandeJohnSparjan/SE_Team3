<?php
use PHPMailer\PHPMailer\PHPMailer;


class Email{
    protected $db;
    protected $user_name;
    protected $user_email;


    function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    function sendRegistrationEmail($username, $email)
    {
        try {
            $this->user_name = trim($username);
            $this->user_email = trim($email);
            if (!empty($this->user_name) && !empty($this->user_email)) {
                $name = $this->user_name;
                $email = $this->user_email;
                $subject = "Registration Successful";
                $body = "Hello ".$email."!!, Your registration is successful";

                require_once "PHPMailer/PHPMailer.php";
                require_once "PHPMailer/SMTP.php";
                require_once "PHPMailer/Exception.php";

                $mail = new PHPMailer();

                //SMTP Settings
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->Username = "teamhcse@gmail.com"; //enter you email address
                $mail->SMTPAuth = true;
                $mail->Password = 'T3amH($3123'; //enter you email password
                $mail->Port = 465;
                $mail->SMTPSecure = "ssl";

                //Email Settings
                $mail->isHTML(true);
                $mail->setFrom($email, $name);
                $mail->addAddress("$email"); //enter you email address
                $mail->Subject = ("$email ($subject)");
                $mail->Body = $body;

                if ($mail->send()) {
                    return ['successMessage' => 'You have signed up successfully.'];
                } else {
                    return ['errorMessage' => 'Invalid email address!'];
                }
            }
            else {
                return ['errorMessage' => 'Please fill in all required fields.'];
            }

        } catch (PDOException $errorMsg) {
            die($errorMsg->getMessage());
        }

    }

}