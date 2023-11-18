<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if files are uploaded
    if (!empty($_FILES["uploadedFiles"]["name"][0])) {
        $allowedMimeTypes = ['image/png', 'image/jpeg', 'application/pdf'];
        $outputFiles = [];

        // Process each uploaded file
        foreach ($_FILES["uploadedFiles"]["name"] as $key => $value) {
            $uploadedFileType = mime_content_type($_FILES["uploadedFiles"]["tmp_name"][$key]);

            // Check if the file type is allowed
            if (in_array($uploadedFileType, $allowedMimeTypes)) {
                // Generate a random filename with the original extension
                $randomFileName = bin2hex(random_bytes(8)) . '.' . pathinfo($_FILES["uploadedFiles"]["name"][$key], PATHINFO_EXTENSION);

                // Move the uploaded file to a new location with the random filename
                move_uploaded_file($_FILES["uploadedFiles"]["tmp_name"][$key], $randomFileName);

                // Execute a bash command (example command, replace with your actual command)
                $bashCommand = "ls -l";
                $outputFiles[] = [
                    'filename' => $randomFileName,
                    'output' => shell_exec($bashCommand),
                ];
            } else {
                echo "Invalid file type for file {$key}. Allowed types are PNG, JPEG, and PDF.<br>";
            }
        }

        // HTML page with progress bars and download buttons
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>File Processing</title>
            <style>
                body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }

                .progress-bar-container {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .progress-bar {
                    width: 0;
                    height: 30px;
                    background-color: #4CAF50;
                    margin-bottom: 10px;
                }

                .download-button {
                    display: none;
                    padding: 10px;
                    background-color: #008CBA;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <?php foreach ($outputFiles as $index => $fileInfo): ?>
                <div class="progress-bar-container">
                    <div class="progress-bar" id="progress-bar-<?php echo $index; ?>"></div>
                    <a class="download-button" href="<?php echo $fileInfo['filename']; ?>" download>Download <?php echo $fileInfo['filename']; ?></a>
                </div>

                <script>
                    // Simulate a progress bar for 5 seconds
                    var progressBar<?php echo $index; ?> = document.getElementById("progress-bar-<?php echo $index; ?>");
                    var downloadButton<?php echo $index; ?> = document.getElementsByClassName("download-button")[<?php echo $index; ?>];

                    function updateProgressBar<?php echo $index; ?>() {
                        var width = 1;
                        var interval = setInterval(function () {
                            if (width >= 100) {
                                clearInterval(interval);
                                downloadButton<?php echo $index; ?>.style.display = "block";
                            } else {
                                width++;
                                progressBar<?php echo $index; ?>.style.width = width + "%";
                            }
                        }, 50);
                    }

                    updateProgressBar<?php echo $index; ?>();
                </script>
            <?php endforeach; ?>
        </body>
        </html>
        <?php
    } else {
        echo "Error uploading files.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
</head>
<body>
    <form action="fileprocessing.php" method="post" enctype="multipart/form-data">
        <label for="uploadedFiles">Choose files:</label>
        <input type="file" name="uploadedFiles[]" id="uploadedFiles" accept=".png, .jpeg, .jpg, .pdf" multiple>
        <br>
        <input type="submit" value="Upload Files">
    </form>
</body>
</html>
