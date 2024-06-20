

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin-Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="register.php" method="POST">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            name="fname" placeholder="First Name">
                                    </div>
                                   <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                        name="lname"    placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                      name="email" placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                          name="password"  id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                        name="confirmpassword"    id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" name="register">
                                    Register Account
                                </button>
                              <!--  <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>-->
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
/*include('includes/connection.php');

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $confirmpass = $_POST['confirmpass'];

    // Hash the password before storing it in the database
    //$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO  adminlogin1 (username, lastname, email, password,confirmpassword) VALUES ('$fname', '$lname', '$email', '$pass','$confirmpass')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<div class="alert alert-success">Registration successful. Please <a href="login.php">login</a>.</div>';
    } else {
        echo '<div class="alert alert-danger">Registration failed. Please try again.</div>';
    }
}*/
?>
<?php
// Include database connection file
require_once 'includes/connection.php';

// Initialize variables
if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];
$msg = '';
$error = '';

// Validate inputs
if ($password !== $confirmpassword) {
    $error = "Passwords do not match.";
} else {
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $sql = "SELECT * FROM adminlogin1 WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $error = "Email already exists. Please use a different email.";
    } else {
        // Insert user into database
        $sql_insert = "INSERT INTO adminlogin1(username, lastname, email, password) VALUES (:fname, :lname, :email, :password)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bindParam(':fname', $fname, PDO::PARAM_STR);
        $stmt_insert->bindParam(':lname', $lname, PDO::PARAM_STR);
        $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            $msg = "Registration successful.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
}

?>


<!--Close database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Result</title>
</head>
<body>
    <h2>Registration Result</h2>
    <?php /*if (!empty($msg)): ?>
        <p style="color: green;"><?php echo $msg; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <a href="register.php">Back to Registration Form</a>
</body>
</html>


<?php
/*Database Configuration File
include('includes/connection.php');
error_reporting(0);
if(isset($_POST['register']))
{
//Getting Post Values
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$confirmpass = $_POST['confirmpass'];

// Query for validation of username and email-id
$query = "SELECT * FROM adminlogin1 WHERE username = :fname OR email = :email";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->rowCount();
/*$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
if($queryt -> rowCount() == 0)*
if($count === 0) 
{

// Query for Insertion
$sql="INSERT INTO adminlogin1 (username, lastname, email, password,confirmpassword) VALUES ('$fname', '$lname', '$email', '$pass','$confirmpass')";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':pass', $hashed_password, PDO::PARAM_STR);
$query->bindParam(':confirmpass', $confirmpass, PDO::PARAM_STR);
if ($query->execute()) {
    $msg = "You have signed up successfully";
} else {
    $error = "Something went wrong. Please try again";
}
} else {
$error = "Username or Email-id already exists. Please try again";
}
}
?>





<!--$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="You have signup  Scuccessfully";
}
else
{
$error="Something went wrong.Please try again";
}}

else
{
$error="Username or Email-id already exist. Please try again";
}
}*/

?>