<?php
include 'booyermoore.php';
$bulan = array("januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");

function validateDate($day, $month, $year){
  return checkdate($month,  $day, $year);
}


// GLOBAL VARIABLES
$tabelname = 'chatbot';
$jenistask = array('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas');
$timeperiod = array(
  'sejauh ini',
  'sampai saat ini',
  'minggu ke depan',
  'hari ke depan',
  'hari ini',
  'antara',
  'semua'
);

function isdeletetask($input)
{
  $katapentingdelete = array('sudah selesai', 'beres', 'hapus');

  foreach ($katapentingdelete as $kata) {
    if (preg_match("/\b" . $kata . "\b/i", $input)) {
      return true;
    }
  }
  return false;
}

function getinputtaskid($input)
{
  $input = strtolower($input);
  $katapenting = array('task');
  foreach ($katapenting as $kata) {
    $index = booyermoore($kata, $input);
    if ($index != -1) {
      $panjangkata = strlen($kata);
      $index = $panjangkata + $index + 1;
      $num = '';

      // skip jika ada spasi lebih sebelum nomor id
      while ($input[$index] == ' ') {
        $index++;
      }

      for ($i = $index; $i < strlen($input); $i++) {
        $num .= $input[$i];
        if ($input[$i] == ' ') {
          break;
        }
      }
      // jika tidak valid atau nomor id tidak ada, mengembalikan nilai 0
      return (int)$num;
    }
  }
  return -1; // tidak ditemukan
}


// ================== show data ===================
// Contoh command :
// Halo bot tampilkan, halo bot apa saja, halo bot daftar 

$jenistask = array('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'pr');

function isAddTask($input){
  global $bulan;
  global $jenistask;
  $isThereTask = -1;
  $message = strtolower($input);
  foreach ($jenistask as $kata){
    if ($isThereTask == -1){
        $isThereTask = booyermoore($kata, $message);
    }
  }
  if ($isThereTask == -1) return false;
  if (! preg_match("/\b[a-z]{2}\d{4}\b/i", $input)) return false;
  $isdateusenamemonth = false;
  foreach ($bulan as $namabulan){
      if ($isdateusenamemonth == false){
          $pattern = "/pada (\d{2}) (".$namabulan.") (\d{4})/i";
          $isdateusenamemonth = preg_match($pattern,$input,$date);
      }
  }
  if ($isdateusenamemonth){
    $day = (int) $date[1];
    $year = (int) $date[3];
    for ($i = 0; $i < 12; $i++){
      if ($date[2] == $bulan[$i]){
        $month = $i+1;
      }
    }
    
    return validateDate($day,$month, $year) && (date("Y-m-d") <= date("Y-m-d",mktime(0,0,0,$month,$day,$year))); 

  }
  preg_match("/pada (\d{2})([\-\/\.\s])(\d{2})\g{-2}(\d{4})/i",$input,$date);
  return validateDate((int)$date[1],(int)$date[3], (int)$date[4]) && (date("Y-m-d") <= date("Y-m-d",mktime(0,0,0,(int)$date[3],(int)$date[1],(int)$date[4]))); 
  
}

// var_dump(isAddTask("Halo bot tolong tambahin PrakTIkum IF2311 pada 23 04 2020"));

function addTask($input){
  $lowerinput = strtolower($input);
  $idxjenistask = -1;
  global $jenistask;
  global $bulan;
  foreach ($jenistask as $kata){
    if ($idxjenistask == -1){
      $idxjenistask = booyermoore($kata, $lowerinput);
    }
  }
  $jenistugas = "";
  while($input[$idxjenistask] != " "){
    $jenistugas .= $input[$idxjenistask];
    $idxjenistask++;
  }
  //aman sampai nyimpen jenis tugas
  preg_match("/\b[a-z]{2}\d{4}\b/i", $input,$match);
  $kodekuliah = $match[0];
  $isdateusenamemonth = false;
  foreach ($bulan as $namabulan){
    if ($isdateusenamemonth == false){
        $pattern = "/pada (\d{2}) (".$namabulan.") (\d{4})/i";
        $isdateusenamemonth = preg_match($pattern,$input,$date);
      }
  }
  if ($isdateusenamemonth){
    $day = (int) $date[1];
    $year = (int) $date[3];
    for ($i = 0; $i < 12; $i++){
      if ($date[2] == $bulan[$i]){
        $month = $i+1;
      }
    }
    $d = mktime(0,0,0,$month,$day,$year);
  }else{
    preg_match("/pada (\d{2})([\-\/\.\s])(\d{2})\g{-2}(\d{4})/i",$input,$date);
    $d = mktime(0,0,0,(int)$date[1],(int)$date[3], (int)$date[4]);
  }
  $topik = "";
  $indexpada = booyermoore("pada", $lowerinput)-1;
  $indexkode = booyermoore($kodekuliah,$input);
  $iterate = $indexkode + 7;
  while ($iterate != $indexpada){
    $topik .= $input[$iterate];
    $iterate++;
  }
  global $tabelname;
  $query = "INSERT INTO ".$tabelname."(Deadline,Subjects,Keyword,Topic) VALUES(\"".date("Y-m-d",$d)."\", \"".$kodekuliah."\", \"".$jenistugas."\",\"".$topik."\")";
  return $query;

}
// addTask("Halo bot tolong tambahin pr IF2311 membajak sawah pada 23 mei 2021");

function isAskingForHelp($input){
  return preg_match("/(?=.*bisa)((?=.*lakukan)(?=.*apa)|(?=.*ngapain))\w*/i",$input) ? true : false;
}


function isShowTask($input)
{
  $message = strtolower($input);
  $katapentingtampilkan = array('apa saja', 'tampilkan', 'daftar');
  global $timeperiod;

  $kata = 'deadline';
  if (!preg_match("/\b" . $kata . "\b/i", $message)) {
    return false;
  }
  $tampilkanfound = false;
  foreach ($katapentingtampilkan as $kata) {
    if (preg_match("/\b" . $kata . "\b/i", $message)) {
      $tampilkanfound = true;
      break;
    }
  }

  if ($tampilkanfound) {
    foreach ($timeperiod as $kata) {
      if (preg_match("/\b" . $kata . "\b/i", $message)) {
        return true;
      }
    }
  }
  return false;
}

// $message = "Halo bot apa saja deadline antara";
// var_dump(isShowTask($message));

function getTimePeriodWord($input)
{
  $message = strtolower($input);
  global $timeperiod;
  foreach ($timeperiod as $kata) {
    if (preg_match("/\b" . $kata . "\b/i", $message)) {
      return $kata;
    }
  }
}

function getShowQuery($input, $kata)
{
  global $tabelname;
  $message = strtolower($input);
  $query = '';
  if ($kata == 'sejauh ini' || $kata == 'sampai saat ini') {
    $query = 'SELECT * FROM ' . $tabelname . ' WHERE Deadline >= \'' . date("Y-m-d") . '\'';
    // $query = 'SELECT * FROM chatbot WHERE Deadline >= \'' . date("Y-m-d") . '\'';
  } else if ($kata == 'minggu ke depan' || $kata == 'hari ke depan') {
    // get number N
    $index = booyermoore($kata, $message);

    // skip for whitespace
    $index--;
    while ($message[$index] == ' ') {
      $index--;
    }
    // go to the first number char
    while ($message[$index] != ' ') {
      $index--;
    }
    $index++;
    $num = '';
    // take num
    for ($i = $index; $i < strlen($message); $i++) {
      $num .= $message[$i];
      if ($message[$i] == ' ') {
        break;
      }
    }

    if (strlen($num) > 0 && (int)$num > 0) {
      $num = (int)$num; // convert num
      if ($kata == 'minggu ke depan') {
        $datenow = strtotime("+$num Weeks");
      } else {
        // days
        $datenow = strtotime("+$num Days");
      }
      $query = 'SELECT * FROM '. $tabelname . ' WHERE Deadline BETWEEN \'' . date("Y-m-d") . '\' AND ' .  '\'' . date("Y-m-d", $datenow) . '\'';
    }
  } else if ($kata == 'hari ini') {
    $query = 'SELECT * FROM '. $tabelname . ' WHERE Deadline = \'' . date("Y-m-d") . '\'';
  } else if ($kata == 'antara') {
    $message = str_replace('/', '-', $message); // jika masukan format menggunakan / convert menjadi -
    preg_match_all("(\d{1,4}-\d{1,2}-\d{1,4})", $message, $arraydate);
    if (count($arraydate[0]) == 2) {
      $query = 'SELECT * FROM '. $tabelname . ' WHERE Deadline BETWEEN \'' . $arraydate[0][0] . '\' AND ' .  '\'' . $arraydate[0][1] . '\'';
    }
  } else if ($kata == 'semua') {
    $query = 'SELECT * FROM '. $tabelname;
    return $query;
  }

  // cek apakah mengandung spesifik task
  // $jenistask = array('kuis', 'tubes', 'tucil', 'ujian', 'praktikum');
  global $jenistask;
  $hastask = false;
  foreach ($jenistask as $task) {
    if (preg_match("/\b" . $task . "\b/i", $message)) {
      $hastask = true;
      $query .= ' AND Keyword = \'' . $task . '\';';
      break;
    }
  }
  if (!$hastask) {
    $query .= ';';
  }
  return $query;
}

// keyword perintah
// $katapentingtampilkan = array('apa saja', 'tampilkan', 'daftar');

// // Keyword time
// $timeperiod = array(
//   'sejauh ini',
//   'sampai saat ini',
//   'minggu ke depan',
//   'hari ke depan',
//   'hari ini',
//   'antara',
//   'semua'
// ); // satu lagi yakni mendeteksi 2 tanggal menggunakan regex

// keyword task
// $jenistask = array('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas');
// $message = 'Tampilkan deadline 5 HARI KE DEPAN';
// $message = 'Deadline hari ke depan apa saja?';


// MENGUPDATE JADWAL / MENGUNDUR DEADLINE ===========================================================
// Deadline task X diundur menjadi 2021-04-28
// perbarui deadline task X menjadi 2021-04-28
function isDelayTask($input)
{
  $message = strtolower($input);
  $katakuncidiundur = array('diundur', 'jadwal ulang', 'perbarui');
  $diundur = false;
  foreach ($katakuncidiundur as $task) {
    if (preg_match("/" . $task . "\b/i", $message)) {
      $diundur = true;
      break;
    }
  }

  $kata = 'deadline';
  // cek tanggal dan ada kata deadline
  $message = str_replace('/', '-', $message); // jika masukan format menggunakan / convert menjadi -
  if (!$diundur || !preg_match("/\b" . $kata . "\b/i", $message) || !preg_match('(\d{1,4}-\d{1,2}-\d{1,4})', $input)) {
    return false;
  }
  return true;
}

// $message = 'Deadline task 20 jadwal ulang menjadi 2021-04-28';
// var_dump(isDelayTask($message));
// echo getDelayQuery($message);
function getDelayQuery($input)
{
  global $tabelname;
  $input = str_replace('/', '-', $input); // jika masukan format menggunakan / convert menjadi -
  // ambil tanggal
  preg_match('(\d{1,4}-\d{1,2}-\d{1,4})', $input, $matches);
  $tanggal = $matches[0];
  $message = strtolower($input);
  $index = booyermoore('task', $message);

  // go to the first number char
  $index += 4;
  while ($message[$index] == ' ') {
    $index++;
  }
  $num = '';
  // take num
  for ($i = $index; $i < strlen($message); $i++) {
    $num .= $message[$i];
    if ($message[$i] == ' ') {
      break;
    }
  }

  $num = (int)$num;
  $query = '';
  if ($num > 0) {
    $tanggal = strtotime($tanggal);
    if(date("Y-m-d", $tanggal) > date("Y-m-d")){
      // tanggal baru harus lebih besar dari hari ini
      $query = 'UPDATE ' . $tabelname . ' SET Deadline = \'' . date("Y-m-d", $tanggal) . '\' WHERE Id = ' . $num . ';';
    } else{
      $query = 'Tanggal tidak valid';
    }
  }
  return $query;
}

function isDeadline($input)
{
  $message = strtolower($input);
  $katakuncideadline = array('kapan', 'deadline');
  $diundur = false;
  foreach ($katakuncideadline as $task) {
    if (preg_match("/" . $task . "\b/i", $message)) {
      $diundur = true;
      break;
    }
  }

  $kata = 'deadline';
  // cek tanggal dan ada kata deadline
  if (!$diundur || !preg_match("/[a-z A-Z]{2}[\d]{4}/", $message) || !preg_match('/kuis|tubes|tucil|tugas|ujian|praktikum/i', $message)) {
    return false;
  }
  return true;
}