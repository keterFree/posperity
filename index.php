<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://kit.fontawesome.com/f7e75704ad.js" crossorigin="anonymous"></script>
    <script src="title.js"></script>
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
                            document.getElementById('h2').textContent = usnValue;
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
                    <a class="bar" href="#">Home</a>
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
                    <li><a href="#">Home</a></li>
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

    <div id="maindiv">
        <div class="main-content" id="div2">
            <h2 id='h2'></h2>
            <div class='profile-image'><img src='assets\profile.png' alt='Profile Image'></div>
        </div>

    </div>
    <footer>
        <p style="font-size: 10px;">
            &copy; 2024 posperity,all rights reserved</p>
    </footer>
</body>
<script>
    // Retrieve data from local storage
    const storedData = localStorage.getItem('loginData');

    // Check if data retrieval was successful
    if (storedData) {

    } else {
        window.location.href = "login.php";
    }
</script>

</html>