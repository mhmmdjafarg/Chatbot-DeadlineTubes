<?php
// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");

$header =   $class = "<div class=\"bot-inbox inbox\" style = \"align-items: center;\"><div class=\"icon\"><img src=\"https://d17ivq9b7rppb3.cloudfront.net/original/commons/dibantu-pp.png\" class=\"agent\"></div><div class=\"msg-header\">";

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM chatbot ORDER BY Deadline";
$result = $conn->query($query);
if (mysqli_num_rows($result) > 0) {
  echo $header . "<p>Hello, ini daftar deadline kamu sejauh ini" . "</p></div></div>";
  // output data of each row
  $class = "<div class=\"bot-inbox inbox\" style = \"align-items: center;\"><div class=\"icon\"><img src=\"../assets/blue-snow.png\" class=\"agent\"></div><div class=\"msg-body\">";
  // $class = "<div class=\"bot-inbox inbox\" style = \"align-items: center;\"><div class=\"icon\"><img src=\"https://d17ivq9b7rppb3.cloudfront.net/original/commons/dibantu-pp.png\" class=\"agent\"></div><div class=\"msg-header\">";
  while ($row = $result->fetch_assoc()) {
    $keyword = strtoupper($row["Keyword"]);
    echo $class . "<p>" . $keyword . " " . $row["Subjects"] .  " || Deadline " . $row["Deadline"] . "<br> Topic " . $row["Topic"] . "</p></div></div>";
  }
}
else {
  echo $header . "<p>Tidak ada deadline apapun sejauh ini" . "</p></div></div>";
}

mysqli_close($conn);
