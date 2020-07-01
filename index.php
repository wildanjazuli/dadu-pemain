<?php
$pemain = '';
$arrPemain = array(); // [0,1,2,3]
$dadu = '';
$arrDadu = array(); // [1] => [2,1,6,1]
$arrPoint = array(); // [1,4,3]
$arrDaduPemain = array();
$pemainPunyaDadu = array(); // [1]
$forpush = array();

if (isset($_GET['pemain']) && isset($_GET['dadu'])) {
    $pemain = $_GET['pemain'];
    $dadu = $_GET['dadu'];
    $pemainaktif = $pemain;
    $giliran = 1;
    $point = 0;
    $pemenang = '';

    while ($pemainaktif >= 1) {
        echo 'Giliran ' . $giliran . ' lempar dadu : <br>';
        for ($i = 0; $i < $pemain; $i++) {
            if (isset($arrDaduPemain[$i])) {
                $arrDadu[$i] = count($arrDaduPemain[$i]);
            } else {
                $arrDadu[$i] = $dadu;
            }
            $arrDaduPemain[$i] = lemparDadu($arrDadu[$i]);
            echo 'Pemain #' . ($i + 1) . '(' . (isset($arrPoint[$i]) ? $arrPoint[$i] : 0) . ')' . ':' . (implode(",", (isset($arrDaduPemain[$i]) ? $arrDaduPemain[$i] : ''))) . '<br>';
            foreach (array_keys($arrDaduPemain[$i], 6, true) as $key) {
                array_splice($arrDaduPemain[$i], $key, 1);
                $arrPoint[$i] = (isset($arrPoint[$i]) ? $arrPoint[$i] : 0) + 1;
            }
            foreach (array_keys($arrDaduPemain[$i], 1, true) as $key) {
                array_splice($arrDaduPemain[$i], $key, 1);
                if ($pemain == ($i + 1)) {
                    if(!isset($forpush[0])){
                        $forpush[0]= array();
                    }
                    array_push($forpush[0], 1);
                } else {
                    if(!isset($forpush[($i+1)])){
                        $forpush[($i+1)]= array();
                    }
                    array_push($forpush[($i+1)], 1);
                }
            }
        }

        echo 'Setelah evaluasi : <br>';
        for ($i = 0; $i < $pemain; $i++) {
            if(isset($forpush[$i])){
                foreach($forpush[$i] as $v){
                    array_push($arrDaduPemain[$i], $v);
                }
            }
            echo 'Pemain #' . ($i + 1) . '(' . (isset($arrPoint[$i]) ? $arrPoint[$i] : 0) . ')' . ':' . (implode(",", (isset($arrDaduPemain[$i]) ? $arrDaduPemain[$i] : ''))) . '<br>';
            if (isset($arrPoint[$i]) && $arrPoint[$i] > $point) {
                $point = $arrPoint[$i];
                $pemenang = $i + 1;
            }
            if (count($arrDaduPemain[$i]) == 0) {
                $pemainaktif--;
            }
            unset($forpush[$i]);
        }
        echo '<br>';

        $giliran++;
    }

    if ($pemainaktif == 0) {
        echo 'Pemenangnya = ' . $pemenang;
    }
}

function lemparDadu($dadu)
{
    $arrDaduPemain = array();
    for ($i = 0; $i < $dadu; $i++) {
        $arrDaduPemain[$i] = rand(1, 6);
    }

    return $arrDaduPemain;
}

?>

<form action='' method="GET">
    Pemain <input type='number' name='pemain' value='<?php echo $pemain ?>'>
    Dadu <input type='number' name='dadu' value='<?php echo $dadu ?>'>
    <input type='submit' value='Submit'>
</form>