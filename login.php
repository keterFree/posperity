<?php
include "redisconnect.php";
// Start session
session_start();

// Close Redis connection (Predis automatically handles connections, so no explicit close is needed)
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sign.css">
</head>

<body>
    <header>
        <h1>Posperity System <small>test</small> </h1>
    </header>


    <div class="login-form">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <div style="color: red;">
                <?php
                $data = 1;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Retrieve hashed password from the database

                    // Database connection parameters
                    include 'dbconfig.php';

                    // User input (username or email)
                    $userInput = $_POST["username"];

                    // Prepare SQL statement
                    $sql = "SELECT u.user_id, u.user_name, u.password, u.merchant_id, u.email, u.fullname, u.address, u.mobile,m.merchantname 
                        FROM user u LEFT JOIN merchant m ON u.merchant_id = m.mid WHERE u.user_name = ? OR u.email = ?";
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter to the statement
                    $stmt->bind_param("ss", $userInput, $userInput);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    // Check if the query returned any rows
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $suid  = $row['user_id'];
                        $uname  = $row['user_name'];
                        $hashedPassword = $row['password'];
                        $mname = $row['merchantname'];
                        $merid = $row['merchant_id'];


                        // Password entered by the user during login
                        $userEnteredPassword = $_POST["password"];
                        $hashedUserEnteredPassword = password_hash($userEnteredPassword, PASSWORD_DEFAULT);
                        // Verify if the user-entered password matches the stored hashed password
                        echo password_verify($userEnteredPassword, $hashedPassword);
                        if (password_verify($userEnteredPassword, $hashedPassword)) {

                            echo "match found";
                            // Start the session
                            session_start();

                            // // Store the username in the session
                            // $_SESSION["username"] =     $uname;
                            // $_SESSION["merchantname"] = $mname;
                            // $_SESSION["merchantid"] =   $merid;
                            // $_SESSION["userid"] =       $suid;
                            // echo $_SESSION["username"];
                            // Store session data in Redis
                            $redis->set($uname, 'username');
                            $redis->set('username', $uname);
                            $redis->set('merchantname', $mname);
                            $redis->set('merchantid', $merid);
                            $redis->set('userid', $suid);

                            // Echo session data to confirm it's stored
                            echo "Username: " . $redis->get('username') . "<br>";
                            echo "Merchant Name: " . $redis->get('merchantname') . "<br>";
                            echo "Merchant ID: " . $redis->get('merchantid') . "<br>";
                            echo "User ID: " . $redis->get('userid') . "<br>";


                            // Redirect to the home page
                            echo '<script>window.location.href = "index.php"</script>';
                            exit();
                        } else {
                            // Redirect back to the login page with an error message
                            // header("Location: login.php?error=1");
                            echo "incorrect password,please retry";
                        }
                    } else {
                        // No matching user found
                        echo "Incorrect email or username, please retry";
                    }

                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
            <div>Don't have an account,<a href="signup.php">sign up</a>?</div>
            <div><a href="reset.php?data=<?php echo urlencode($data); ?>">Forgot Password?</a></div>


    </div>
    </form>

    <footer>
        <p>&copy; 2024 Posperity. All rights reserved.</p>
    </footer>
</body>

</html>