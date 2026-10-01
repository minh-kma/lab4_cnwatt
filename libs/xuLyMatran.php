<?php
// Các hàm thao tác trên ma trận vuông (mảng 2 chiều) $m[$i][$j]

function maxMatran(array $mang2Chieu)
{
    $max = null;
    foreach ($mang2Chieu as $dong) {
        foreach ($dong as $v) {
            if ($max === null || $v > $max) {
                $max = $v;
            }
        }
    }
    return $max;
}

function minMatran(array $mang2Chieu)
{
    $min = null;
    foreach ($mang2Chieu as $dong) {
        foreach ($dong as $v) {
            if ($min === null || $v < $min) {
                $min = $v;
            }
        }
    }
    return $min;
}

function tongTrenCheoChinh(array $mang2Chieu)
{
    $sum = 0;
    $n = count($mang2Chieu);
    for ($i = 0; $i < $n; $i++) {
        $sum += $mang2Chieu[$i][$i];
    }
    return $sum;
}

function tongTrenCheoPhu(array $mang2Chieu)
{
    $sum = 0;
    $n = count($mang2Chieu);
    for ($i = 0; $i < $n; $i++) {
        $sum += $mang2Chieu[$i][$n - 1 - $i];
    }
    return $sum;
}

function tinhMatranTong(array $matran1, array $matran2): array
{
    $kq = [];
    $n = count($matran1);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $kq[$i][$j] = $matran1[$i][$j] + $matran2[$i][$j];
        }
    }
    return $kq;
}

function tinhMatranHieu(array $matran1, array $matran2): array
{
    $kq = [];
    $n = count($matran1);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $kq[$i][$j] = $matran1[$i][$j] - $matran2[$i][$j];
        }
    }
    return $kq;
}

function tinhMatranTich(array $matran1, array $matran2): array
{
    $kq = [];
    $n = count($matran1);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $kq[$i][$j] = 0;
            for ($k = 0; $k < $n; $k++) {
                $kq[$i][$j] += $matran1[$i][$k] * $matran2[$k][$j];
            }
        }
    }
    return $kq;
}
