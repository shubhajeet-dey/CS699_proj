<?php
session_start();

// If not logged in, Redirect to login page
if((!isset($_SESSION['login'])) || empty($_SESSION['login']['email'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
    <style>
        body {
            background-image: url('image2.webp');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #header {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 20px;
        }

        #functions-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #pdf-tools {
        }

        #functions {
            position: relative;
        }

        #functions:hover .popup {
            display: block;
        }

        #functions .popup {
            display: none;
            position: absolute;
            background-color: #333;
            color: white;
            padding: 10px;
            top: 100%;
            margin: auto 50px;
        }

        #functions .popup ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        #functions .popup ul li {
            margin: 5px 0;
        } 

        #sign-in {
            order: 0;
        }

        #main-text {
            text-align: center;
            justify-content: center;
            background-color: #3498db;
            color: white;
            width: 20%;
            margin: 10% 40%;
            border-radius: 25px;
            padding: 20px;
        }

        #title {
            padding: 10px;
            font-size: 3em;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div id="header">
        <div id="functions-container">
            <span id="pdf-tools">PDF TOOLS</span>
            <div id="functions">
                <h1>FUNCTIONS</h1>
                <div class="popup">
                    <ul>
                        <li><a style="text-decoration: none; color: white;" href="merge.php">MERGE</a></li>
                        <li><a style="text-decoration: none; color: white;" href="pdftoimg.php">PDFTOIMG</a></li>
                        <li><a style="text-decoration: none; color: white;" href="encrypt.php">ENCRYPT</a></li>
                    </ul>
                </div>
            </div>
            <span id="sign-in"><?php echo $_SESSION['login']['email']; ?></span>
        </div>
    </div>

    <div id="main-text">
        <h1 id="title">PDF TOOLS</h1>
    </div>

    <script>
        const functions = document.getElementById('functions');
        const functionsPopup = functions.querySelector('.popup');

        // Toggle the display of functionality options when clicking "FUNCTIONS"
        functions.addEventListener('click', function () {
            if (functionsPopup.style.display === 'block') {
                functionsPopup.style.display = 'none';
            } else {
                functionsPopup.style.display = 'block';
            }
        });

        // Close the functionality options when clicking outside of the menu
        document.addEventListener('click', function (event) {
            if (!functions.contains(event.target)) {
                functionsPopup.style.display = 'none';
            }
        });
    </script>
    
</body>
</html>
