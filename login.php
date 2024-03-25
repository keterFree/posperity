<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sign.css">
</head>
<script>
    function storeDivContents() {
        // Get all div elements by their IDs
        const usnElement = document.getElementById('usn');
        const mnameElement = document.getElementById('mname');
        const meridElement = document.getElementById('merid');
        const suidElement = document.getElementById('suid');

        // Check if the div elements exist
        if (usnElement && mnameElement && meridElement && suidElement) {
            // Get the contents of the divs
            const usnContents = usnElement.innerHTML;
            const mnameContents = mnameElement.innerHTML;
            const meridContents = meridElement.innerHTML;
            const suidContents = suidElement.innerHTML;

            // Create an object to store all the contents
            const divContents = {
                usn: usnContents,
                mname: mnameContents,
                merid: meridContents,
                suid: suidContents
            };

            // Convert the object to a JSON string
            const jsonString = JSON.stringify(divContents);

            // Store the JSON string in local storage
            localStorage.setItem('loginData', jsonString);

            alert('All div contents stored in local storage!');
        } else {
            alert('One or more div elements not found!');
        }
    }
</script>

<body>
    <header>
        <h1>Posperity System</h1>
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
            <button type="submit" id="try">Login</button>
            <div style="color: red;">
                <?php
                $data = 1;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Retrieve hashed password from the database

                    // Database connection
                    include "dbconfig.php";

                    // User input (username or email)
                    $userInput = $_POST["username"];

                    // Prepare SQL statement
                    $sql = "SELECT u.user_id, u.user_name, u.password, u.merchant, u.email, u.fullname, u.address, u.mobile,m.merchantname 
                        FROM user u LEFT JOIN merchant m ON u.merchant = m.mid WHERE u.user_name = ? OR u.email = ?";
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
                        $merid = $row['merchant'];


                        // Password entered by the user during login
                        $userEnteredPassword = $_POST["password"];
                        $hashedUserEnteredPassword = password_hash($userEnteredPassword, PASSWORD_DEFAULT);
                        // Verify if the user-entered password matches the stored hashed password
                        echo password_verify($userEnteredPassword, $hashedPassword);
                        if (password_verify($userEnteredPassword, $hashedPassword)) {

                            echo "match found";
                            // Start the session
                            session_start();

                            // Store the username in the session
                            echo '<div id="usn" style="display: none;">' . $uname . '</div>';
                            echo '<div id="mname" style="display: none;">' . $mname . '</div>';
                            echo '<div id="merid" style="display: none;">' . $merid . '</div>';
                            echo '<div id="suid" style="display: none;">' . $suid . '</div>';
                            echo '<script>';
                            echo 'storeDivContents();'; // Call the storeDivContents() function
                            echo '</script>';

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