<?php
include "redisconnect.php";
$logged = $redis->hgetall('session_data');
// Start session
session_start();

// Close Redis connection (Predis automatically handles connections, so no explicit close is needed)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="listItems.css">
    <script src="title.js"></script>
    <script src="https://kit.fontawesome.com/f7e75704ad.js" crossorigin="anonymous"></script>
</head>


<body>
    <header>
        <h1>
            <?php
            if (isset($logged['merchantname'])) {
                echo "{$logged['merchantname']} Sales";
            }
            ?>
        </h1>
        <div class="head">

            <div class="menu">
                <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
                <div id="hide" class="navbar-toggle">
                    <a class="bar" href="index.php">Home</a>
                    <a class="bar" href="makeSale.php">Make Sale</a>
                    <a class="bar" href="inventory.php">Inventory</a>
                    <a class="bar" href="transactions.php">Transactions</a>
                    <a class="bar" href="about.html">About</a>
                    <a class="bar" href="services.html">Services</a>
                    <a class="bar" href="logout.php">Log out</a>
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
                    <li><a href="logout.php"><i class="fa-regular fa-user" style="color: #ffffff;"></i> log out</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="inventorydiv">
        <div>
            <div class="actionsBar">
                <div>
                    <button class="button" id="nextButton">Preview Selection</button>
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
                // Connect to your database
                include 'dbconfig.php';

                // Fetch data from the database
                $sql = "SELECT `product_id`, `name`, `description`, `price`, `quantity`, `img_url`,
             `user_id`, `merchant_id` FROM `product` WHERE `merchant_id` = ?";

                $stmt = $conn->prepare($sql);

                // logged[o the statemen]
                $stmt->bind_param("i", $logged['merchantid']);

                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if the query returned any rows
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $prod = strval($row["product_id"]);
                        $quantity = $row["quantity"];
                        echo "<div class='card' style='color:white;' data-productid='$prod' data-quantity='$quantity'>";
                        echo "<img src='" . $row["img_url"] . "' alt='Product Image'>";
                        echo "<div class='card-content'>";
                        echo "<h4>" . $row["name"] . "</h4>";
                        echo "<p>" . $row["description"] . "</p>";
                        echo "<p>Ksh. " . $row["price"] . "</p>";

                        // Check if quantity is less than or equal to zero
                        if ($quantity <= 0) {
                            // If quantity is zero or negative, echo "Out of stock" in red
                            echo '<p style="color: red;">Out of stock</p>';
                        } else {
                            // Otherwise, echo the quantity as normal
                            echo "<p>Stock: $quantity</p>";
                        }

                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo '<div id="maindiv">';
                    echo '<div class="main-content" id="div2">';
                    echo 'You have no prducts in your inventory';
                    echo '<button class="button" onclick="toAdd()">Add new products</button>';
                    echo '</div>';
                    echo '</div>';
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

    function toAdd() {
        // Redirect to another page (replace 'page-url' with the actual URL)
        window.location.href = 'add_product.php';
    }
</script>
<!-- JavaScript code -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectedProducts = []; // Array to store selected product IDs

        // Add event listener to each card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', () => {
                const productId = card.getAttribute('data-productid'); // Get product ID
                const quantity = parseInt(card.getAttribute('data-quantity')); // Get quantity as integer

                // Check if quantity is greater than zero
                if (quantity > 0) {
                    const index = selectedProducts.indexOf(productId); // Check if product ID is in the array

                    // Toggle selection state
                    if (index === -1) {
                        // Product not selected, add to selectedProducts array
                        selectedProducts.push(productId);
                        card.classList.add('selected'); // Add selected class for styling
                        console.log('Product selected:', productId);
                    } else {
                        // Product already selected, remove from selectedProducts array
                        selectedProducts.splice(index, 1);
                        card.classList.remove('selected'); // Remove selected class
                        console.log('Product deselected:', productId);
                    }

                    console.log('Selected products:', selectedProducts); // Log selected products array
                } else {
                    console.error('Product is out of stock:', productId);
                }
            });
        });
        // Event listener for next page navigation
        document.getElementById('nextButton').addEventListener('click', () => {
            // Pass selected product IDs to the next page using query string
            if (selectedProducts.length > 0) {
                const queryString = `?selected_products=${selectedProducts.join(',')}`;
                window.location.href = 'salesPreview.php' + queryString;
            } else {
                console.error('No products selected.');
            }
        });
    });
</script>

</html>