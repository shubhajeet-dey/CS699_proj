<?php
session_start();
$_SESSION['merge'] = array('active'=>1);
$_SESSION['merge']['process'] = 0;
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

        #upload {
            text-align: center;
            margin-top: 22%;
        }

        #uploaded-files {
            text-align: center;
            margin-top: 20px;
        }

        input[type="file"] {
            display: none;
        }

        label.upload-button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        label.upload-button:hover {
            background-color: #2980b9;
        }

        #submit-container {
            text-align: center;
            margin-top: 20px;
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

    <form method="post" action="merge_process.php" enctype="multipart/form-data">
        <div id="upload">
            <label for="file-upload" class="upload-button">Upload Files</label>
            <input type="file" id="file-upload" accept=".pdf" name="uploadedFiles[]" multiple>
        </div>

        <div id="uploaded-files"></div>

        <div id="submit-container">
            <input type="submit" id="submit-button">
        </div>
    </form>

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

        const fileInput = document.getElementById('file-upload');
        const fileDisplay = document.getElementById('uploaded-files');
        const uploadedFiles = [];

        fileInput.addEventListener('change', function () {
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                const fileName = file.name;
                const fileType = file.type;

                if (uploadedFiles.indexOf(fileName) === -1) {
                    uploadedFiles.push(fileName);

                    const fileInfo = document.createElement('div');
                    fileInfo.innerText = `${fileName} (${fileType})`;
                    fileInfo.style.color = 'white'; 
                    fileDisplay.appendChild(fileInfo);
                }
            }
        });

        const submitButton = document.getElementById('submit-button');
        submitButton.addEventListener('click', function () {
            // Handle the submit logic here
            // You can submit the uploaded files to your backend or perform other actions.
        });
    </script>
</body>
</html>
