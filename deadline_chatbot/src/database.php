<?php

// FIle ini hanya dijalankan untuk melakukan reset database

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS bot;";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();


// clear DB
// Create connection
$conn = new mysqli($servername, $username, $password, 'bot');
// create tabel
$sql = "DROP TABLE IF EXISTS chatbot;";

if ($conn->query($sql) === TRUE) {
  echo "Tabel dropped successfully";
} else {
  echo "Error dropping tabel: " . $conn->error;
}


// create tabel
$sql = "CREATE TABLE IF NOT EXISTS chatbot (
  Id INT(11) AUTO_INCREMENT PRIMARY KEY,
  Deadline DATE,
  Subjects VARCHAR(30),
  Keyword VARCHAR(30),
  Topic VARCHAR(255)
);";

if ($conn->query($sql) === TRUE) {
  echo "Tabel created successfully";
} else {
  echo "Error creating tabel: " . $conn->error;
}

$conn->close();
