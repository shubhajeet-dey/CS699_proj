<?php
session_start();
unset($_SESSION['login']);
$_SESSION['login'] = array('error'=>'','name'=>'','email'=>'');

// Checking if request was indeed POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the variables are set
    if (isset($_POST['email']) && isset($_POST['password'])) {

        // Getting password hash and salt from database to verify
        include 'db.php';
        $SQL = $conn->prepare("SELECT password, salt, name FROM users WHERE email = :email");
        $SQL->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $SQL->execute();
        $result = $SQL->fetch(PDO::FETCH_ASSOC);
        
        if($result === false) {
            $_SESSION['login']['error'] = 'Login Failed!';
        } else {
            $salt = $result['salt'];
            $password_hash = hash('sha512', '' . $_POST['password'] . $salt . '');

            // Checking if login successful
            if($password_hash === $result['password']) {
                
                $_SESSION['login']['email'] = $_POST['email'];
                $_SESSION['login']['name'] = $result['name'];
                header("Location: index.php");
                exit();

            } else {
                $_SESSION['login']['error'] = 'Login Failed!';
            }
        }

    } else {
        $_SESSION['login']['error'] = "Login Failed!";
    }   
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

        #submit-container {
            text-align: center;
            margin-top: 30px;
        }

        #submit-button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #submit-button:hover {
            background-color: #2980b9;
        }

        #sign-in {
            order: 0;
        }

        .login-container {
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .login {
            width: 15%;
            font-size: 18px;
            margin-top: 40px;
            text-align: center;
            border-radius: 4px;
            border-color: #3498db;
            color: #3498db;
        }

        ::placeholder {
          color: #3498db;
          opacity: 1; /* Firefox */
        }

        ::-ms-input-placeholder { /* Edge 12 -18 */
          color: #3498db;
        }
        
        input:focus::placeholder {
          color: transparent;
        }

        .login-failed-container {
            text-align: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        #login-failed {
            display: block;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            background-color: #3498db;
            align-items: center;
            justify-content: center;
            width: 20%;
            margin: 20% 40%;
            font-size: 1em;
            font-weight: bold;
        }

        #login-failed:hover {
            background-color: #2980b9;
        }

        form {
            margin-top: 10%;
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
                        <li><a style="text-decoration: none; color: white;" href="rotate.php">ROTATE</a></li>
                    </ul>
                </div>
            </div>
            <span id="sign-in"><a style="text-decoration: none; color: white;" href="register.php">REGISTER</a></span>
        </div>
    </div>

    <?php
    // Checking if no error message
    if( !empty($_SESSION['login']['error']) ):
    ?>

    <div class="login-failed-container">
            <button onclick="location.href = 'login.php';" id="login-failed" ><?php echo $_SESSION['login']['error']; ?> Retry?</button>
    </div>
    
    <?php else: ?>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="login-container">
            <input type="email" class="login" name="email" placeholder="Email" required>
        </div>
        <div class="login-container">
            <input type="password" class="login" name="password" pattern="[A-Za-z0-9]+" title="Only alphanumeric characters are allowed" placeholder="Password" required>
        </div>
        
        <div id="submit-container">
            <input type="submit" id="submit-button">
        </div>
    </form>

    <?php endif; ?>

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
