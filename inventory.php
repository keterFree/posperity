<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="listItems.css">
    <script src="https://kit.fontawesome.com/f7e75704ad.js" crossorigin="anonymous"></script>
</head>


<body>
    <header>
        <h1>
            <div id="usn" style="display: none;"></div>
            <div id="mname" style="display: none;"></div>
            <div id="merid" style="display: none;"></div>
            <div id="suid" style="display: none;"></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Retrieve the JSON string from local storage
                    const jsonString = localStorage.getItem('loginData');

                    // Check if the JSON string exists in local storage
                    if (jsonString) {
                        // Parse the JSON string back to an object
                        const divContents = JSON.parse(jsonString);

                        // Access the values from the object
                        const usnValue = divContents.usn;
                        const mnameValue = divContents.mname;
                        const meridValue = divContents.merid;
                        const suidValue = divContents.suid;

                        // Populate the div elements if values exist in local storage
                        if (usnValue) {
                            document.getElementById('usn').textContent = usnValue;
                        }
                        if (mnameValue) {
                            document.getElementById('mname').textContent = mnameValue;
                            document.getElementById('mname').style.display = 'block';
                        }
                        if (meridValue) {
                            document.getElementById('merid').textContent = meridValue;
                        }
                        if (suidValue) {
                            document.getElementById('suid').textContent = suidValue;
                        }

                        // AJAX request to send values to PHP script
                        const xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // Response received from PHP script
                                console.log("Response from PHP script:", this.responseText);
                            }
                        };
                        xhttp.open("GET", "processData.php?usn=" + usnValue + "&mname=" + mnameValue + "&merid=" + meridValue + "&suid=" + suidValue, true);
                        xhttp.send();
                    } else {
                        console.log('No data found in local storage for key "loginData"');
                    }
                });
            </script>



        </h1>
        <div class="head">
            <div></div>
            <div class="menu">
                <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
                <div id="hide" class="navbar-toggle">
                    <a class="bar" href="index.php">Home</a>
                    <a class="bar" href="makeSale.php">Make Sale</a>
                    <a class="bar" href="inventory.php">Inventory</a>
                    <a class="bar" href="transactions.php">Transactions</a>
                    <a class="bar" href="about.html">About</a>
                    <a class="bar" href="services.html">Services</a>
                    <a class="bar" href="contact.html">Contact</a>
                    <a class="bar" href="logout.php"><i class="fa-regular fa-user" style="color: #ffffff;"></i> log out</a>
                </div>
            </div>
            <nav class="nav" id="navbarLinks">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="makeSale.php">Make Sale</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="transactions.php">Transactions</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="logout.php"><i class="fa-regular fa-user" style="color: #ffffff;"></i> log out</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="inventorydiv">
        <div>
            <div class="actionsBar">
                <div>
                    <a class="button" href="add_product.php">Add items</a>
                </div>
                <div>
                    <div class="searchBar">
                        <input type="text" id="searchInput" class="searchInput" placeholder="Search...">
                        <button class="searchButton" onclick="searchItems()">Search</button>
                    </div>
                </div>
            </div>
            <div class="inventorydiv1">
                <!-- <button>::</button> -->
                <?php
                try {
                    $_SERVER["REQUEST_METHOD"] = "POST";
                    include 'processData.php';
                    // Connect to your database
                    include "dbconfig.php";

                    // Fetch data from the database
                    $sql = "SELECT `product_id`, `name`, `description`, `price`, `quantity`, `img_url`,`user_id`, `merchant_id` FROM `product` WHERE `merchant_id` = ?";

                    $stmt = $conn->prepare($sql);
                    echo "<script>alert(" . $php_merid . ");</script>";
                    // Bind the parameter to the statement

                    $stmt->bind_param("i", $php_merid);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    // Check if the query returned any rows
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $prod = strval($row["product_id"]);
                            echo "<div class='card' style='color:white;'>";
                            echo "<img src='" . $row["img_url"] . "' alt='Product Image'>";
                            echo "<div class='card-content'>";
                            echo "<h4>" . $row["name"] . "</h4>";
                            echo "<p>" . $row["description"] . "</p>";
                            echo "<p>Ksh. " . $row["price"] . "</p>";
                            $quantity = $row["quantity"];

                            // Check if quantity is less than zero
                            if ($quantity <= 0) {
                                // If quantity is negative, echo "Out of stock" in red
                                echo '<p style="color: red;">Out of stock</p>';
                            } else {
                                // Otherwise, echo the quantity as normal
                                echo "<p>stock: $quantity</p>";
                            }
                            echo '<div class="edit"><a href="editInventory.php?product_id=' . $prod . '"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></a></div>';

                            echo "</div>";
                            echo "</div>";
                        }
                    } else {

                        if (isset($php_merid)) {
                            echo "<tr><td colspan='7'>No data found</td></tr>";
                        } else {
                            echo "<script>";
                            echo "console.log(NUll merchant id);";
                            // echo "location.reload();";
                            echo "</script>";
                        }
                    }
                } catch (Exception $e) {
                    // Print error message to JavaScript console
                    echo "<script>";
                    echo "console.log(" . $e->getMessage() . ");";
                    echo "</script>";
                }
                $conn->close();
                ?>

            </div>
        </div>
        <footer>
            <p style="font-size: 10px;color:white;">
                &copy; 2024 posperity,all rights reserved</p>
        </footer>
    </div>


</body>
<script>
    function toggleMenu() {
        var navbarLinks = document.getElementById("hide");
        if (navbarLinks.style.display === "flex") {
            navbarLinks.style.display = "none";
        } else {
            navbarLinks.style.display = "flex";
        }
    }


    function searchItems() {
        var input = document.getElementById('searchInput').value.trim().toLowerCase();
        var cards = document.getElementsByClassName('card');

        for (var i = 0; i < cards.length; i++) {
            var name = cards[i].querySelector('h4').textContent.toLowerCase();
            var description = cards[i].querySelector('p').textContent.toLowerCase();

            if (name.includes(input) || description.includes(input)) {
                cards[i].style.display = 'block';
            } else {
                cards[i].style.display = 'none';
            }
        }
    }
</script>

</html>