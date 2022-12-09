<?php 

if(isset($_POST['fname']) && 
   isset($_POST['uname']) && 
   isset($_POST['pass'])){

    include "../db_conn.php";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
	$email = $_POST['emaill'];
	$confirmpass = $_POST['pass2'];
	
    $data = "fname=".$fname."&uname=".$uname;
    
	$duplicate= mysqli_query($con,"SELECT * FROM users WHERE username='$uname' OR email='$email'");

	if (mysqli_num_rows($duplicate)>0)
	{
		echo '<script>alert("Sorry accound is taken please go and try again")</script>';
		header('Refresh: 1; URL=http://localhost/loginsinup/index.php');
		exit();
	}

    if (empty($fname)) {
    	$em = "Please enter your full name";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }else if(empty($uname)){
    	$em = "Please enter your usename";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }else if(empty($pass)){
    	$em = "Please enter your password";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }
	else if(empty($email)){
		$em = "Please enter your email";
    	header("Location: ../index.php?error=$em&$data");
		exit;
	}
	else if($pass != $confirmpass){
		$em = "plese enter the same password";
		header("location: ../index.php?error=$em&$data");
		exit;
	}
	else {

    	// hashing the password
    	$pass = password_hash($pass, PASSWORD_DEFAULT);

    	$sql = "INSERT INTO users(fname, username, password, email) 
    	        VALUES(?,?,?,?)";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$fname, $uname, $pass, $email]);

    	header("Location: ../index.php?success=Your account has been created successfully");
	    exit;
    }

}else {
	header("Location: ../index.php?error=error");
	exit;
}