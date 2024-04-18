<!DOCTYPE html>
<html>
    <head>
<title>Form</title>


</head>
<body>
<form action="formProcess.php" method="POST">
    <label for='name'> Name</label>
    <input type='text'  name='name' required><br></br>

    <label for='phone'> Phone Number:</label>
    <input type='number'  name="phone" required><br></br>

    <label for='email'> Email</label>
    <input type='email'  name="email" required><br></br>

    <label for='subject'> Subject:</label>
    <input type='text'  name="subject" required><br></br>


    <label for='name'> Message</label>
    <textarea  name='message' required></textarea><br></br>

    <input type="submit"  value="submit">

</form>
</body>



</html>