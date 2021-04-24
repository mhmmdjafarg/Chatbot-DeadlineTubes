<!-- <?php

    $kataPenting = new SplFixedArray(5);
    $kataPenting[0] = "kuis";
    $kataPenting[1] = "tubes";
    $kataPenting[2] = "tucil";
    $kataPenting[3] = "ujian";
    $kataPenting[4] = "praktikum";

    $bulan = array("januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
// $input = explode(" ", preg_filter("/\s+/" ," ","suka   makan  babi"));
// $pattern = "/^b/i";
// $tes = preg_grep($pattern, $input);
// print_r($input);
// print_r($tes);

    function isAddTask($input, $array, $bulan){
        // ngecek apakah ada 1. kata penting tugas, 2. kode kuliah valid, 3. ada tanggal yang valid pula 4. tanggal didahului pada
        $isThereTask = false;
        
        foreach ($array as $kata){
            if ($isThereTask == false){
                $pattern = "/\b" . $kata . "\b/i";
                $isThereTask = preg_match($pattern, $input);
            }
            
        }

        $isKodeValid = preg_match("/\b[a-z]{2}\d{4}\b/i", $input);
        
        $isdatevalid = false;
        $isdateusenamemonth = false;
        foreach ($bulan as $namabulan){
            if ($isdateusenamemonth == false){
                $pattern = "/\bpada\b(?=\d{2} ".$namabulan . " \d{2,4})/i";
                $isdateusenamemonth = preg_match($pattern,$input);
            }
        }
        $isdatevalid = (preg_match("/\bpada\b(?=\d{2}[-/.]\d{2}[-/.]\d{2,4})/", $input)||$isdateusenamemonth);


        return ($isThereTask && $isKodeValid && $isdatevalid);
    }

    var_dump (isAddTask("Halo bot tolong tambahin PrakTIkum IF2311 pada 23 januari 2020", $kataPenting, $bulan));
?> -->