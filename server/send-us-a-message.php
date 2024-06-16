<?php
 // Include the PHPMailer Autoload file
// require 'vendor/autoload.php';

// Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 

require './Exception.php';
require './PHPMailer.php';
require  './SMTP.php';


 
 

$servername = "sql108.ezyro.com"; // Replace 'localhost' with your MySQL server address
$username = "ezyro_36660504";  
$password = "401d5512d37"; 
$database = "ezyro_36660504_alunya_techiez";  //Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$mail = new PHPMailer(true); // Passing `true` enables exceptions
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
     echo "Connected successfully";
}
 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Retrieve user data
   $name = $_POST["name"];
   $email = $_POST["email"];
   $phone = $_POST["phone"];
   $message = $_POST["message"];
    
   
$sql = "INSERT INTO messages (created_at,name, email,phone,message) VALUES (CURRENT_TIMESTAMP,'$name', '$email','$phone','$message')";

//Execute query
if ($conn->query($sql) === TRUE) {
    echo "Message sent succesfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error; 
}

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com:465'; // SMTP server address : The smtp test host server address
    $mail->SMTPAuth = true;
    $mail->Username = 'patrickalunya2021@gmail.com'; // SMTP username: Always replace this with the business gmail address for authenticity
    $mail->Password = 'ghun khuh qwgm icay'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25; // TCP port to connect to

    // Sender and recipient settings
    $mail->setFrom('patrickalunya2021@gmail.com', 'P&A Co.'); // Sender's email and name
    $mail->addAddress($email, $name); // Recipient's email and name
    $mail->addReplyTo('patrickalunya2021@gmail.com', 'Reply To'); //The email option for customers to reply to

    // Email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Thank you message'; //The usual email subject
    $mail->Body    = 'Dear Customer. This is just but an smtp test case.Forget about pinching that hair under the chin.Just grab that coffee mug and think about the latest movie in town.The "The Fall Guy". Very nice. '; //System auto generated message to users every time they send a message to us.
    $mail->AltBody = 'This is the plain text message body for non-HTML mail clients';

    // Send email
    $mail->send();
    header("Location: ./confirmation-message.php"); //This prevents resubmission of the form data when browser is refreshed by the user
        exit;
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
 
}
 
// Close the connection
$conn->close();