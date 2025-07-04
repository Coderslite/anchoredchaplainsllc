<?php
//Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    // Extract data from the JSON
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $messageContent = $_POST['message'];
    $messageContent = nl2br($messageContent);

    //Set mailer to use smtp
    $mail = new PHPMailer();
    $mail->isSMTP();
    //Define smtp host
    $mail->Host = "anchoredchaplainsllc.com";
    //Enable smtp authentication
    $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = "ssl";
    //Port to connect smtp
    $mail->Port = "465";
    //Set gmail username
    $mail->Username = "contact@anchoredchaplainsllc.com";
    //Set gmail password
    $mail->Password = "Techvista2024";
    //Email subject
    $mail->Subject = "Contact Us Entries";
    $mail->setFrom($email);
    //Enable HTML
    $mail->isHTML(true);
    $mail->addAddress('contact@anchoredchaplainsllc.com');
    $mail->addReplyTo($email,$name);
    // Email body
    $mail->Body =
        '<html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #333;
                        margin-bottom: 20px;
                    }
                    .details {
                        margin-bottom: 20px;
                    }
                    .details strong {
                        font-weight: bold;
                        margin-right: 5px;
                    }
                    p {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Contact Details</h1>
                    <div class="details">
                        <p><strong>Full Name:</strong> ' . $name . '</p>
                        <p><strong>Email Address:</strong> ' . $email . '</p>
                    </div>
                    <div class="message">
                        <p><strong>Message:</strong></p>
                        <p>' . $messageContent . '</p>
                    </div>
                </div>
            </body>
        </html>';

    // Add recipient

    // Finally send email
    if ($mail->send()) {
        $result = 'success';
    } else {
        $result = $email;
    }


    // Closing smtp connection
    $mail->smtpClose();

header('content-Type: application/json');
echo json_encode($result);
?>