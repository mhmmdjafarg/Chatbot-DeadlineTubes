<?php

// Mengembalikan array posisi kemunculan terakhir suatu karakter pada text T dai dalam pattern P, jika tidak pernah muncul bernilai -1
function calculatetabelLo($pattern)
{
  $lastoccurence = array();
  $lowerpattern = strtolower($pattern);
  for ($i = 0; $i < strlen($lowerpattern); $i++) {
    $lastoccurence[$pattern[$i]] = $i;
  }
  return $lastoccurence;
}

// mengembalikan nilai L(x) 
function getlastoccurence($tabelLx, $charT)
{
  if (array_key_exists($charT, $tabelLx)) {
    return $tabelLx[$charT];
  } else {
    return -1;
  }
}

// mengembalikan index pertama text yang match dengan pattern, -1 jika tidak ditemukan
function booyermoore($pattern, $text)
{

  
  // Simpan array last occurence untuk karakter pada pattern
  $last = calculatetabelLo($pattern);

  // Pencocokan
  $n = strlen($text);
  $panjangpattern = strlen($pattern);
  $panjangtext = strlen($text);
  if($panjangpattern > $panjangtext){
    return -1;
  }
  $j = $panjangpattern - 1;
  $i = $j;

  do {
    if ($pattern[$j] == $text[$i]) {
      if ($j == 0) {
        return $i;
      } else {
        // looking glass
        $i--;
        $j--;
      }
    } else {
      // character jump
      $lo = getlastoccurence($last, $text[$i]);
      $i = $i + $panjangpattern - min($j, $lo + 1);
      $j = $panjangpattern - 1;
    }
  } while ($i <= $n - 1);

  return -1;
}

// $tingkat = levenshtein('deadline', 'dealine');
// echo $tingkat . "<br>";
// $nilai = $tingkat/strlen('deadline');
//  if($tingkat/strlen('deadline') <= 0.25 && $nilai > 0){
//    echo "typo";
//  } else{
//    echo 'tidak typo';
//  }