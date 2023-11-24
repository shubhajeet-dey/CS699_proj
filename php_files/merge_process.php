<?php
session_start();

// If not logged in, Redirect to login page
if((!isset($_SESSION['login'])) || empty($_SESSION['login']['email'])) {
    header("Location: login.php");
    exit();
}

$_SESSION['merge']['error'] = '';
$uploadDir = '../uploads/';
$venvDir = '../venv_proj/bin/activate';

// Checking if request was indeed POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Checking if the request came from merge.php
    if(!isset($_SESSION['merge']['active']) || $_SESSION['merge']['active'] === 0) {
        header("Location: merge.php");
        exit();
    }
    $_SESSION['merge']['active'] = 0;
    $_SESSION['merge']['process'] = 1;

    // Check if the files are uploaded
    if (!empty($_FILES["uploadedFiles"]["name"][0])) {
        $allowedMimeType = 'application/pdf';
        $newFiles = [];

        // Process each uploaded file individually
        foreach ($_FILES["uploadedFiles"]["name"] as $key => $value) {
            if($_FILES["uploadedFiles"]["size"][$key] <= 52428800)
            {
                $uploadedFileType = mime_content_type($_FILES["uploadedFiles"]["tmp_name"][$key]);

                // Check if the file mime type is allowed
                if ($uploadedFileType === $allowedMimeType) {

                    // Generate a random filename
                    $randomFileName = bin2hex(random_bytes(8)) . '.pdf';

                    // Move the uploaded file to a new location with the random filename
                    move_uploaded_file($_FILES["uploadedFiles"]["tmp_name"][$key], $uploadDir . $randomFileName);

                    array_push($newFiles, $randomFileName);

                } else {
                    $_SESSION['merge']['error'] = "File {$key}: Invalid file type!";
                }
            }else{
                $_SESSION['merge']['error'] = "File {$key}: Size more than 50MB!";
            }
        }

        if(empty($_SESSION['merge']['error'])) {
            // Executing the python script
            $args = array("operation"=>"merge","files"=>$newFiles);
            $bashCommand = '. '. $venvDir .' && python3 ../pdf_scripts/manager.py ' . escapeshellarg(base64_encode(json_encode($args)));
            $output_file = shell_exec($bashCommand);

            //Error while executing the script
            if($output_file == null || $output_file === 'Error: File Handling' || $output_file === false) {
                $_SESSION['merge']['error'] = 'Error while processing the files!';
            }else{
                $_SESSION['merge']['file'] = $output_file;
            }
        }
    } else {
        $_SESSION['merge']['error'] = 'Error in uploading the files!';
    }
}else if(!isset($_SESSION['merge']['process']) || $_SESSION['merge']['process'] === 0){
    header("Location: merge.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Merge PDFs</title>
    <style>
        body {
            background-image: url('image2.webp');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            align-items: center;
            justify-content: center;
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

        .progress-bar-container {
            text-align: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .progress-bar {
            width: 0;
            height: 30px;
            background-color: #C41E3A;
            border-radius: 5px 5px 5px 5px;
        }

        #download-button {
            display: none;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            background-color: #3498db;
            align-items: center;
            justify-content: center;
            width: 20%;
            margin: 20% 40%;
        }

        .progress-bar-details {
            display: block;
            justify-content: center;
            align-items: center;
            margin: 20% 30%;
            background-color: #DDDDDD;
            border: 1px solid white;
            border-radius: 5px 5px 5px 5px;
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
    <div class="progress-bar-container">
            <div class="progress-bar-details">
                <div class="progress-bar" id="progress-bar"></div>
            </div>
            <?php 
                // Checking if no error message
                if(empty($_SESSION['merge']['error'])) {
                    echo '<a id="download-button" href="download.php?op=merge">Download Merge PDF</a>';
                }else{
                    echo '<h4 id="download-button">'. $_SESSION['merge']['error'] .'</h4>';
                }
            ?>
    </div>
    <script>
            // Simulate a progress bar for 5 seconds
            var progressBar = document.getElementById("progress-bar");
            var downloadButton = document.getElementById("download-button");
            var progressBarDetails = document.getElementsByClassName("progress-bar-details")[0];

            progressBar.style.display = "block";
            downloadButton.style.display = "none";

            function updateProgressBar() {
                var width = 1;
                var interval = setInterval(function () {
                    if (width >= 100) {
                        clearInterval(interval);
                        downloadButton.style.display = "block";
                        progressBarDetails.style.display = "none";
                    } else {
                        width++;
                        progressBar.style.width = width + "%";
                    }
                }, 50);
            }

            updateProgressBar();
    </script>
</body>
</html>
