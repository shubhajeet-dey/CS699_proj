<?php
$conn = pg_connect("host=localhost dbname=pdf_tools user=pdf_admin password=my_world_is_great@699");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
echo "Connected successfully to the PostgreSQL database.";
pg_close($conn);
?>
