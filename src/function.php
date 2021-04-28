<?php
include 'booyermoore.php';

$bulan = array("januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
// GLOBAL VARIABLES
$tabelname = 'chatbot';
$jenistask = array('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr');
$timeperiod = array(
  'sejauh ini',
  'sampai saat ini',
  'minggu ke depan',
  'hari ke depan',
  'hari ini',
  'antara',
  'semua'
);
$katakunciall = array("januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember",'kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr',  'tampilkan', 'daftar','sejauh', 'sampai', 'minggu', 'hari' ,'depan', 'antara', 'semua','diundur', 'jadwal','ulang', 'perbarui','kapan', 'deadline','lakukan', 'bisa','ngapain', 'tanggal');

// ================== delete task ===================
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

function validateDate($day, $month, $year){
  return checkdate($month,  $day, $year);
}

// ================== add task ===================
function isAddTask($input){
  if (preg_match("/hapus|hilangkan|sudahi|hilang/i", $input)) return false;
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
  if (! preg_match("/pada/", $message)) return false;
  $isdateusenamemonth = false;
  foreach ($bulan as $namabulan){
      if ($isdateusenamemonth == false){
          $pattern = "/(pada\s+(\d{1,2})\s+(".$namabulan.")\s+(\d{4}))|pada\s+tanggal\s+(\d{1,2})\s+(".$namabulan.")\s+(\d{4})/i";
          $isdateusenamemonth = preg_match($pattern,$message,$date);          
      }
  }
  if ($isdateusenamemonth){
    // echo "please ga nyampe sini";
    if (preg_match("/tanggal/",$message)){
      $day = (int) $date[5];
      $year = (int) $date[7];
      $month = $date[6];
      
    }else{
      $day = (int) $date[2];
      $year = (int) $date[4];
      $month = $date[3];
    }
  }else if (preg_match("/(pada\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))|(pada\s+tanggal\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))/i",$message)){
    // echo "please ga nyampe sini";
    preg_match("/(pada\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))|(pada\s+tanggal\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))/i",$message,$date);
    if (preg_match("/tanggal/", $message)){
      $day = (int) $date[7];
      $year = (int) $date[10];
      $month = $date[9];
    }else{
      $day = (int) $date[2];
      $year = (int) $date[5];
      $month = $date[4];
    }
  }else return false;
  // echo "helo";
  if ($isdateusenamemonth){
    $bulans = -1;
    for ($i = 0; $i < 12; $i++){
      if ($month == $bulan[$i]){
        $bulans = $i+1;
      }
    }
  }
  else $bulans = $month;
  return validateDate($day,$bulans, $year) && (date("Y-m-d") <= date("Y-m-d",mktime(0,0,0,$bulans,$day,$year)));
}

//  
// var_dump(isAddTask("Halo bot hapus tubes if2230 pada 12 Mei 2021"));

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
        $pattern = "/(pada (\d{1,2}) (".$namabulan.") (\d{4}))|pada tanggal (\d{1,2}) (".$namabulan.") (\d{4})/i";
        $isdateusenamemonth = preg_match($pattern,$lowerinput,$date);
      }
  }
  if ($isdateusenamemonth){
    if (preg_match("/tanggal/",$lowerinput)){
      $day = (int) $date[5];
      $year = (int) $date[7];
      $month = $date[6];
      
    }else{
      $day = (int) $date[2];
      $year = (int) $date[4];
      $month = $date[3];
    }
  }else{
    preg_match("/(pada\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))|(pada\s+tanggal\s+(\d{1,2})([\-\/\.\s])(\d{2})\g{-2}(\d{4}))/i",$lowerinput,$date);
    if (preg_match("/tanggal/", $lowerinput)){
      $day = (int) $date[7];
      $year = (int) $date[10];
      $month = $date[9];
    }else{
      $day = (int) $date[2];
      $year = (int) $date[5];
      $month = $date[4];
    }
  }
  if ($isdateusenamemonth){
    $bulans = -1;
    for ($i = 0; $i < 12; $i++){
      if ($month == $bulan[$i]){
        $bulans = $i+1;
      }
    }
  }
  else $bulans = $month;
  $d = mktime(0,0,0,$bulans,$day,$year);
  $topik = "";
  $indexpada = booyermoore("pada", $lowerinput)-1;
  $indexkode = booyermoore($kodekuliah,$input);
  $iterate = $indexkode + 7;
  if ($iterate <= $indexpada){
    while ($iterate != $indexpada){
      $topik .= $input[$iterate];
      $iterate++;
    }
  }
  
  global $tabelname;
  $query = "INSERT INTO ".$tabelname."(Deadline,Subjects,Keyword,Topic) VALUES(\"".date("Y-m-d",$d)."\", \"".$kodekuliah."\", \"".$jenistugas."\",\"".$topik."\")";
  return $query;

}
// addTask("Halo bot tolong tambahin pr IF2311 membajak sawah pada 23 mei 2021");
// echo addTask("bot tambahin pr IF2111 pada tanggal 5 Mei 2021");
// ================== ask for help ====================
function isAskingForHelp($input){
  return preg_match("/(?=.*bisa)((?=.*lakukan)(?=.*apa)|(?=.*ngapain))\w*/i",$input) ? true : false;
}

// ================== show task ===================
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


// ================== update task ===================
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
  if (!$diundur || !preg_match("/\b" . $kata . "\b/i", $message) || !preg_match('(\d{1,4}-\d{1,2}-\d{1,4})', $message)) {
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

// ================== get specific task ===================
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

// ================== leviathan ===================
function lev ($str1, $str2){
  $size1 = strlen($str1);
  $size2 = strlen($str2);
  $matriks = array();
  for ($i = 0 ; $i < $size2+1; $i++){
    $dummy = array();
    for ($j = 0; $j < $size1+1; $j++){
      array_push($dummy,($i ==0 || $j==0 ? max($i,$j) : 0));
    }
    array_push($matriks,$dummy);
  }
  // var_dump($matriks);
  for ($i = 1 ; $i <= $size2; $i++){
    for ($j = 1; $j <= $size1; $j++){
      if (min($i,$j) == 0){
        $matriks[$i][$j] = max($i,$j);
      }else{
        $matriks[$i][$j] = min(min($matriks[$i][$j-1]+1,$matriks[$i-1][$j]+1), $matriks[$i-1][$j-1] + ($str1[$j-1] == $str2[$i-1] ? 0 : 1));
      }
    }
  }
  // var_dump($matriks);
  return $matriks[$size2][$size1];
}

function isTypo($str1,$str2){
  $lev = lev($str1,$str2);
  $maks = max(strlen($str1), strlen($str2));
  return $lev <= ($maks/4) && $lev > 0;
}

function isThereTypo($input){
  $data = preg_split('/ +/',$input);
  global $katakunciall;
  for ($i = 0 ; $i < sizeof($data); $i++){
    for ($j = 0; $j < sizeof($katakunciall); $j++){
      if (isTypo($data[$i],$katakunciall[$j])){
        return true;
      }
    }
  }
  return false;
}

function replaceTypo($input){
  $lowerinput = strtolower($input);
  $data = preg_split('/ +/',$lowerinput);
  $dataasli = preg_split('/ +/',$input);
  $arraytypo = array();
  global $katakunciall;
  for ($i = 0 ; $i < sizeof($data); $i++){
    for ($j = 0; $j < sizeof($katakunciall); $j++){
      if (isTypo($data[$i],$katakunciall[$j])){
        $data[$i]=$katakunciall[$j];
        array_push($arraytypo,$i);
      }
    }
  }
  $ouput = "";
  $j = 0;
  for ($i = 0; $i < sizeof($data); $i++){
    if ($j < count($arraytypo) && $i == $arraytypo[$j]){
      $ouput .= "<i>".$data[$i]."</i>";
      $j++;
    }else $ouput .= $dataasli[$i];
    $ouput .= " ";
  }
  return $ouput;
}

// echo lev("deadline","dedlen");


// var_dump(isTypo("haloo","halo"));