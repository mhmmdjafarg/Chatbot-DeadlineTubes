<?php
// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");

// getting user message through ajax
$getMesg = mysqli_real_escape_string($conn, $_POST['text']);

//checking user query to database query
// $check_data = "INSERT INTO chatbot (queries, replies) VALUES ('$getMesg', 'Data sudah ada di database')";

// $check_data = "INSERT INTO dummydate (tanggal) VALUES (
//     preg_match(((\d{4})-(\d{1,2})-(\d{1,2})), $getMesg))";

preg_match("/\d{4}-\d{1,2}-\d{1,2}/", $getMesg,$matches1);

preg_match("/[a-z A-Z]{2}[\d]{4}/", $getMesg,$matches2);

preg_match("/[K k]uis|[T t]ubes|[U u]jian|[T t]ucil/", $getMesg,$matches3);

preg_match("/bab./", $getMesg,$matches4);

$check_data = "INSERT INTO chatbot (Deadline,Matkul,Keyword,Topic) VALUES ('$matches1[0]','$matches2[0]','$matches3[0]','$matches4[0]')";

// if ($matches2[0] == "kuis") {
//     for i in range database

// }
// $run_query = mysqli_query($conn, $check_data) or die("Error");

// // if user query matched to database query we'll show the reply otherwise it go to else statement
// if(mysqli_num_rows($run_query) > 0){
//     //fetching replay from the database according to the user query
//     $fetch_data = mysqli_fetch_assoc($run_query);
//     //storing replay to a varible which we'll send to ajax
//     $replay = $fetch_data['replies'];
//     echo $replay;

// }else{
//     echo "Sorry can't be able to understand you!";
// }
// if ($conn->query($check_data) === TRUE) {
//     echo "record inserted successfully";
// } else {
//     echo ($matches[0]);
// }

if (mysqli_query($conn, $check_data)) {
    echo "New record created successfully";
  } 
else {
    echo "Error: " . $check_data . "<br>" . mysqli_error($conn);
  }
  
mysqli_close($conn);
?>