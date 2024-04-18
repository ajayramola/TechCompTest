<?php

include("connection.php");

function sanitize_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
$name=$email=$phone=$message='';
$errors=[];

if($_SERVER["REQUEST_METHOD"]=="POST"){
 $name=sanitize_input($_POST['name']);
 $phone=sanitize_input($_POST['phone']);
 $email=sanitize_input($_POST['email']);
 $subject=sanitize_input($_POST['subject']);
 $message=sanitize_input($_POST['message']);



if(empty($name)){
    $error[]="Name is Requried";
}
if(empty($email || filter_var($email, FILTER_VALIDATE_EMAIL) )){
    $error[]="Valid email is Requried";
}

if(empty($phone)){
    $error[]="phone number is Requried";
}

if(empty($message)){
    $error[]="message  is Requried";
}
// if(!preg_match('/^\d{10}$/', $phone)){
//     die ("Invalid  Number Format. Please Enter 10 digites number.");
// }


$ip_address = $_SERVER['REMOTE_ADDR'];
$SelectDate="SELECT id FROM contactform WHERE ip_address= ? AND date_time>= NOW()- INTERVAL 1 HOUR";
$stmt=$conn->prepare($SelectDate);
$stmt->bind_param("s",$ip_address);
$stmt->execute();
$result=$stmt->get_result();
if($result->num_rows>0){
    $error[]="Duplicate submission";
}

if(empty($errors)){



$InsertData = "INSERT INTO contactform (name, emailId, phone, message,subject,ip_address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($InsertData);
$stmt->bind_param("ssssss", $name, $email, $phone, $message, $subject, $ip_address);
$stmt->execute();

echo "Data inserted successfully.";

$stmt->close();


//send mail notification

$to='a@gmail.com';
$Subject="New Contact form";
$body="name:$name\nEmail:$email\nphone:$phone\nmessage:$message\nip_address:$ip_address";
$headers="From: contact@gmail.com";
mail($to,$Subject,$body,$headers);
echo "Form SUbmitted SuccesFully!";


}
}

$conn->close();

?>