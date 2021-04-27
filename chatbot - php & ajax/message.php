<?php
include '../function.php';
// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// getting user message through ajax
$getMesg = mysqli_real_escape_string($conn, $_POST['text']);

//  ============================================== MULAI MAIN PROGRAM ==============================================
if (isAddTask($getMesg)) {
  global $tabelname;
  $query = addTask($getMesg);
  $result = $conn->query($query);
  $query = "SELECT * FROM " . $tabelname . " WHERE Id = (SELECT max(Id) from " . $tabelname . ")";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  echo "Task berhasil dicatat\n (ID: " . $row["Id"] . ") " . $row["Deadline"] . " - " . $row["Subjects"] . " - " . $row['Keyword'] . " - " . $row["Topic"] . "<br><br>";
}else if(isAskingForHelp($getMesg)){
  echo "[Fitur]\n<br><br>
        1. Menambahkan task baru\n<br>
        2. Menghapus task dengan id tertentu\n<br>
        3. Menampilkan task\n<br>
        4. Memperbarui task\n<br>
        5. Menampilkan deadline suatu task\n<br><br>
        \n<br>
        [Daftar kata penting]\n<br>
        1. kuis\n<br>
        2. tubes\n<br>
        3. tucil\n<br>
        4. ujian\n<br>
        5. praktikum\n<br>
        6. tugas\n<br>
        7. pr\n<br>
        \n<br><br>
        Lebih lengkapnya baca readme : ntar kasi link readme ke sini";
}else if (isdeletetask($getMesg)) {
  $nomorId = getinputtaskid($getMesg);
  if ($nomorId == 0) {
    echo "Nomor id ga bisa aku temuin, atau kamu cari nomor id 0 dimana itu tidak ada";
  } else if ($nomorId == -1) {
    echo 'Aku engga ngerti perintah kamu';
  } else {
    $deletequery = 'DELETE FROM chatbot WHERE Id = ' . $nomorId;
    if ($conn->query($deletequery) === TRUE) {
      if ($conn->affected_rows > 0) {
        echo "Id $nomorId berhasil dihapus :D, keren semangat terus ya!";
      } else {
        echo "Maaff, id yang kamu cari gaada tuh :(";
      }
    } else {
      echo "Terjadi kesalahan pada database";
    }
  }
} else if (isShowTask($getMesg)) {
  $kata = getTimePeriodWord($getMesg);
  $query = getShowQuery($getMesg, $kata);
  if ($query == ';') {
    echo 'Pesan tidak dikenali';
  } else {
    $result = $conn->query($query);
    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        echo "(ID: " . $row["Id"] . ") " . $row["Deadline"] . " - " . $row["Subjects"] . " - " . $row['Keyword'] . " - " . $row["Topic"] . "<br><br>";
      }
    } else {
      echo "Tidak ada";
    }
  }
} else if (isDelayTask($getMesg)) {
  $query = getDelayQuery($getMesg);
  if ($query == '') {
    echo 'Tambahkan id task pada pesan ya, contoh: (task X) X adalah id';
  } else if ($query == "Tanggal tidak valid") {
    echo "Tanggal yang kamu masukan tidak valid, tanggal baru harus lebih besar dari hari ini";
  } else {
    $result = $conn->query($query);
    if ($result && $conn->affected_rows > 0) {
      echo 'Berhasil memperbarui task';
    } else {
      echo "Gagal memperbarui task, id tidak ada atau deadline yang kamu masukan salah";
    }
  }
} else if (isDeadline($getMesg)) {
  preg_match("/[a-z A-Z]{2}[\d]{4}/", $getMesg, $matches2);
  preg_match("/kuis|tubes|tucil|tugas|ujian/i", $getMesg, $matches3);
  // echo $matches2[0];
  // echo $matches3[0];
  $query = "SELECT * FROM chatbot WHERE Subjects = '$matches2[0]' AND Keyword = '$matches3[0]'";
  if ($query == ';') {
    echo 'Pesan tidak dikenali';
  } else {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        echo $row["Deadline"];
      }
    } else {
      echo "Tidak ada";
    }
  }
} else if (strtolower($getMesg) == 'halo' || strtolower($getMesg) == 'hai') {
  echo "Halo halo, tanya dong aku bisa ngapain aja";
}else if(isThereTypo(($getMesg))){
  $recommend = replaceTypo(($getMesg));
  echo "Mungkin maksud kamu <br> $recommend";
}else{
  echo "Pesan tidak dikenali";
}
mysqli_close($conn);
