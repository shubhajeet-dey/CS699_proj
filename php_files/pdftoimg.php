<?php
session_start();
unset($_SESSION['pdftoimg']);
$_SESSION['pdftoimg'] = array('active'=>1);
$_SESSION['pdftoimg']['process'] = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Convert PDF to IMGs</title>
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
            margin-top: 15%;
        }

        #uploaded-file {
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
            margin-top: 80px;
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

        .dropdown-container {
            text-align: center;
            margin-top: 20px;
        }

        .dropdown-button {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        .dropdown-button:hover {
            background-color: #2980b9;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            justify-content: center;
            left: 50%;
            width: 60px;
            margin-left:-30px;
        }

        .dropdown-option {
            padding: 10px;
            color: #3498db;
            cursor: pointer;
        }

        .dropdown-option:hover {
            background-color: #f0f0f0;
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

    <form method="post" action="pdftoimg_process.php" enctype="multipart/form-data">
        <div id="upload">
            <label for="file-upload" class="upload-button">Upload File</label>
            <input type="file" id="file-upload" accept=".pdf" name="uploadedFile" required>
        </div>

        <div id="uploaded-file"></div>
        <div class="dropdown-container">
            <button class="dropdown-button" onclick="toggleDropdown()" type="button">Choose Image Type</button>
            <div class="dropdown-content" id="imageTypeDropdown">
                <div class="dropdown-option" onclick="selectOption('JPEG')">JPEG</div>
                <div class="dropdown-option" onclick="selectOption('PNG')">PNG</div>
            </div>
        </div>
    
        <input type="hidden" name="selectedOption" id="selectedOption" value="">

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
        const fileDisplay = document.getElementById('uploaded-file');

        fileInput.addEventListener('change', function () {

            fileDisplay.innerHTML = '';
            const fileInfo = document.createElement('div');
            fileInfo.innerText = `${fileInput.files[0].name} (${fileInput.files[0].type})`;
            fileInfo.style.color = 'white';
            fileDisplay.appendChild(fileInfo);
        });

        function toggleDropdown() {
            var dropdownContent = document.getElementById("imageTypeDropdown");
            dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
        }

        function selectOption(option) {
            var dropdownButton = document.querySelector('.dropdown-button');
            var selectedOptionInput = document.getElementById('selectedOption');
            
            dropdownButton.innerHTML = option;
            dropdownButton.style.backgroundColor = '#3498db';
            dropdownButton.style.color = '#ffffff';

            selectedOptionInput.value = option;

            var dropdownContent = document.getElementById("imageTypeDropdown");
            dropdownContent.style.display = "none";
        }
    </script>
</body>
</html>
