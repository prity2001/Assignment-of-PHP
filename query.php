<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="login.css">

</head>
<body>  
<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// define variables and set to empty values
$fullnameErr = $phonenumberErr = $emailErr = $subjectErr = $messageErr = "";
$fullname = $phonenumber = $email = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Name is required";
      } else {
        $fullname = test_input($_POST["fullname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$fullname)) {
          $fullnameErr = "Only letters and white space allowed";
        }
      }


  if (empty($_POST["phonenumber"])) {
    $phonenumberErr = "Phone Number  is required";
} else {
    $phonenumber = test_input($_POST["phonenumber"]);
    // Remove non-numeric characters from the phone number
    $phonenumber = preg_replace("/[^0-9]/", "", $phonenumber);
    
    // Check if the phone number is well-formed
    if (strlen($phonenumber) !== 10) {
        $phonenumberErr = "Phone number must be 10 digits";
    }
}
  

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["subject"])) {
    $subjectErr = "Subject is required";
} else {
    $subject = test_input($_POST["subject"]);
    // You can add additional checks for subject length or allowed characters here if needed
}

  if (empty($_POST["message"])) {
    $message = "";
  } else {
    $message = test_input($_POST["message"]);
  }
  
}


?>
  <div class="container-fluid">
<div class="row ">
    <div class="col-lg-5"></div>
    <div class="col-lg-3 border mt-5 text-center bg-white ">
        <h2>QUERY FORM</h2 >
        <hr>

<p><span class="error">* required field</span></p>
<form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<input type="text" placeholder="  Full Name" name="fullname" required value="<?php echo $fullname;?>">
  <span class="error">* <?php echo $fullnameErr;?></span>
  <br><br>
 <input type="number" placeholder=" Phone Number" name="phonenumber" required  value="<?php echo $phonenumber;?>">
  <span class="error"> *<?php echo $phonenumberErr;?></span>
  <br><br>
   <input type="text" placeholder="E-mail" name="email" required  value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
 
   <input type="text" placeholder="Subject" name="subject" required  value="<?php echo $subject;?>">
  <span class="error"><?php echo $subjectErr;?></span>
  <br>
  <br>
  <textarea name="message" placeholder="Message" rows="5" required  cols="40"><?php echo $message;?></textarea>
  <br><br>

  <input class="submit" type="submit" name="submit" value="Submit">  
</form>

<?php
 $conn = mysqli_connect("localhost", "root", "", "techsolv");
if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $subjectInput = $_POST['subject'];  // Using a different variable name for subject input
    $userMessage = $_POST['message'];   // Using a different variable name for user message
  
        $result1=mysqli_query($conn, "INSERT INTO contact_form VALUES ('','$fullname', '$phonenumber', '$email','$subjectInput','$userMessage')");
        if ($result1) {
            echo '<script> alert("Data sent Successfully"); </script>';
        } else {
            echo "Failed to insert data";
        }
    

    $to = 'raushan9661144750@gmail.com';
    $emailSubject = 'Query Submission'; // Using a different variable name for email subject
    $emailMessage = "Full Name: " . $fullname . "\n" .
                    "Phone Number: " . $phonenumber . "\n" .
                    "Email: " . $email . "\n" .
                    "Subject: " . $subjectInput . "\n" .
                    "Message: " . $userMessage;

    $headers = "From: " . $email;

    if (mail($to, $emailSubject, $emailMessage, $headers)) {
        echo "<h4>Sent Successfully! Thank you, " . $fullname . "!</h4>";
    } else {
        echo "Something went Wrong!";
    }
  }
?>



</body>
</html>
