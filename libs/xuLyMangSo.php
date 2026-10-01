<?php
// Lưu ý: min() và max() là hàm có sẵn của PHP, không thể khai báo lại cùng tên
// (gây Fatal error: Cannot redeclare). Vì vậy đặt tên là minDay() và maxDay().

function minDay(array $mangSo)
{
    if (count($mangSo) === 0) {
        return null;
    }
    $min = $mangSo[0];
    for ($i = 1; $i < count($mangSo); $i++) {
        if ($mangSo[$i] < $min) {
            $min = $mangSo[$i];
        }
    }
    return $min;
}

function maxDay(array $mangSo)
{
    if (count($mangSo) === 0) {
        return null;
    }
    $max = $mangSo[0];
    for ($i = 1; $i < count($mangSo); $i++) {
        if ($mangSo[$i] > $max) {
            $max = $mangSo[$i];
        }
    }
    return $max;
}

function tongDay(array $mangSo)
{
    $sum = 0;
    foreach ($mangSo as $item) {
        $sum += $item;
    }
    return $sum;
}

function avgDay(array $mangSo)
{
    if (count($mangSo) === 0) {
        return null;
    }
    return tongDay($mangSo) / count($mangSo);
}

// Sắp xếp bằng thuật toán chọn (selection sort); $tang = true: tăng dần, false: giảm dần
function sortDay(array $mangSo, bool $tang = true): array
{
    $mangSo = array_values($mangSo);
    $n = count($mangSo);
    for ($i = 0; $i < $n - 1; $i++) {
        $vt = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            if ($tang ? $mangSo[$j] < $mangSo[$vt] : $mangSo[$j] > $mangSo[$vt]) {
                $vt = $j;
            }
        }
        if ($vt !== $i) {
            $tam = $mangSo[$i];
            $mangSo[$i] = $mangSo[$vt];
            $mangSo[$vt] = $tam;
        }
    }
    return $mangSo;
}

function daoNguocDay(array $mangSo): array
{
    $kq = [];
    for ($i = count($mangSo) - 1; $i >= 0; $i--) {
        $kq[] = $mangSo[$i];
    }
    return $kq;
}
