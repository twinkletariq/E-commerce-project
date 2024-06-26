<?php
session_start();

// Database connection details
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "123");
define("DB_NAME", "onlineshop");
define("DB_PORT", 3307);

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the errors array
$errors = array();

// Handle login process
if (isset($_POST['login_admin'])) {
    $admin_username = $_POST['admin_username'];
    $password = $_POST['password'];

    // Prepare the SQL query
    $sql = "SELECT * FROM admin_info WHERE admin_email = ? AND admin_password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $error_msg = "Error preparing the statement: " . $conn->error;
        array_push($errors, $error_msg);
        include './server/errors.php';
    } else {
        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $admin_username, $password);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Login successful
                $_SESSION['admin_email'] = $admin_username;
               // header('location: ./server/home.php'); // Redirect to index.php
               header('location: ./admin/');
                exit();
            } else {
                // Login failed
                $error_msg = "Wrong username/password combination";
                array_push($errors, $error_msg);
                include './server/errors.php';
            }
        } else {
            // Error executing statement
            $error_msg = "Error executing the statement: " . $stmt->error;
            array_push($errors, $error_msg);
            include './server/errors.php';
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
