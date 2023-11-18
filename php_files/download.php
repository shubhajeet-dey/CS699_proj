<?php
session_start();
$resultDir = '../final_results/';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if(isset($_GET['op'])) {
		if($_GET['op'] === 'merge' && isset($_SESSION['merge']['file'])) {
			// Downloading the merged file to the client computer
			$filePath = $resultDir . $_SESSION['merge']['file'];

			// Getting File size
			$filesize = shell_exec('wc -c < ' . $filePath);
			header("Content-disposition: attachment; filename=" . $_SESSION['merge']['file']);
			header("Content-type: application/pdf");
			header('Content-Length: ' . $filesize);

			// Getting file contents
			echo shell_exec('cat ' . $filePath);
			exit();

		} else if($_GET['op'] === 'pdftoimg' && isset($_SESSION['pdftoimg']['file'])) {
			// Downloading the image zip file to the client computer
			$filePath = $resultDir . $_SESSION['pdftoimg']['file'];

			// Getting File size
			$filesize = shell_exec('wc -c < ' . $filePath);
			header("Content-disposition: attachment; filename=" . $_SESSION['pdftoimg']['file']);
			header("Content-type: application/zip");
			header('Content-Length: ' . $filesize);

			// Getting file contents
			echo shell_exec('cat ' . $filePath);
			exit();
		}
	}
}

?>