<?php

try {
  $conn = new PDO('pgsql:host=localhost;port=5432;dbname=pdf_tools','pdf_admin','my_world_is_great@699');
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}

?>