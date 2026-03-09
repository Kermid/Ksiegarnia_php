<?php
$conn = pg_connect("host=127.0.0.1 dbname=ksiegarnia user=postgres password=postgres");

if (!$conn) 
{
echo "Błąd połączenia z bazą danych.";
exit;
}
?>

