<?php
session_start();
unset($_SESSION['register']);
$_SESSION['register'] = array('error'=>'');

// Checking if request was indeed POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the variables are set
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {

        // Checking if email exists
        include 'db.php';
        $SQL = $conn->prepare("SELECT email FROM users WHERE email = :email");
        $SQL->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $SQL->execute();
        $result = $SQL->fetch(PDO::FETCH_ASSOC);
        
        if($result === false) {
            // Email doesn't exist in the database
            // Generate random 512 bits salt
            $salt = bin2hex(random_bytes(64));
            $password_hash = hash('sha512', '' . $_POST['password'] . $salt . '');

            $SQL = $conn->prepare("INSERT INTO users(email, name, password, salt) VALUES (:email, :name, :password, :salt)");
            $SQL->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $SQL->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $SQL->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $SQL->bindParam(':salt', $salt, PDO::PARAM_STR);
            
            // Insertion succesful
            if($SQL->execute() === true) {
                $_SESSION['login']['email'] = $_POST['email'];
                $_SESSION['login']['name'] = $_POST['name'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['register']['error'] = "Registration Failed! Retry?";
            }

        } else {
            $_SESSION['register']['error'] = 'Registration Failed: Account Exists! Retry?';
        }

    } else {
        $_SESSION['register']['error'] = "Registration Failed! Retry?";
    }   
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>REGISTER</title>
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

        .register-container {
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .register {
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

        .register-failed-container {
            text-align: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        #register-failed {
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

        #register-failed:hover {
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
                        <li>EDIT</li>
                        <li>MERGE</li>
                        <li>SPLIT</li>
                        <!-- Add more functionality options as needed -->
                    </ul>
                </div>
            </div>
            <span id="sign-in">SIGN IN</span>
        </div>
    </div>

    <?php
    // Checking if no error message
    if( !empty($_SESSION['register']['error']) ):
    ?>

    <div class="register-failed-container">
            <button onclick="location.href = 'register.php';" id="register-failed" ><?php echo $_SESSION['register']['error']; ?></button>
    </div>
    
    <?php else: ?>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="register-container">
            <input type="text" class="register" name="name" placeholder="Name" pattern="[A-Za-z ]+" title="Only alphabets are allowed" required>
        </div>
        <div class="register-container">
            <input type="email" class="register" name="email" placeholder="Email" required>
        </div>
        <div class="register-container">
            <input type="password" class="register" name="password" pattern="[A-Za-z0-9]+" title="Only alphanumeric characters are allowed" placeholder="Password" required>
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
