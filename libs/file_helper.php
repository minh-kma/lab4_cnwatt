<?php

/**
 * Nhiệm vụ 8 - Đọc/ghi file sinh viên
 * Định dạng file data/student.txt: mỗi sinh viên gồm 3 dòng liên tiếp
 *   dòng 1: Tên
 *   dòng 2: Địa chỉ
 *   dòng 3: Tuổi
 */

function filePath()
{
    return __DIR__ . '/../data/student.txt';
}

/**
 * Loại bỏ ký tự có thể phá vỡ cấu trúc file (xuống dòng, NUL)
 * và cắt khoảng trắng hai đầu.
 */
function cleanField($s)
{
    $s = (string)$s;
    $s = str_replace(["\r", "\n", "\0"], '', $s);
    return trim($s);
}

/**
 * Đếm số ký tự UTF-8 (thay cho mb_strlen vì sandbox không có mbstring).
 */
function doDai($s)
{
    $n = 0;
    $len = strlen($s);
    for ($i = 0; $i < $len; $i++) {
        if ((ord($s[$i]) & 0xC0) !== 0x80) $n++;
    }
    return $n;
}

/**
 * Đọc toàn bộ danh sách sinh viên từ file.
 * Trả về mảng các mảng ['ten' => ..., 'dia_chi' => ..., 'tuoi' => ...].
 */
function docSinhVien()
{
    $path = filePath();
    if (!is_file($path)) return [];

    $fp = @fopen($path, 'r');
    if (!$fp) return [];

    flock($fp, LOCK_SH);

    $kq   = [];
    $line = 0;
    $cur  = ['ten' => '', 'dia_chi' => '', 'tuoi' => ''];

    while (($raw = fgets($fp)) !== false) {
        $val = rtrim($raw, "\r\n");
        $m   = $line % 3;

        if ($m === 0) {
            $cur['ten'] = $val;
        } elseif ($m === 1) {
            $cur['dia_chi'] = $val;
        } else {
            $cur['tuoi'] = $val;
            $kq[] = $cur;
            $cur = ['ten' => '', 'dia_chi' => '', 'tuoi' => ''];
        }
        $line++;
    }

    flock($fp, LOCK_UN);
    fclose($fp);

    return $kq;
}

/**
 * Ghi thêm một sinh viên vào cuối file (append).
 * Trả về true nếu thành công.
 */
function ghiSinhVien($ten, $dia_chi, $tuoi)
{
    $path = filePath();
    $dir  = dirname($path);

    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    $fp = @fopen($path, 'a');
    if (!$fp) return false;

    flock($fp, LOCK_EX);
    fwrite($fp, $ten . "\n" . $dia_chi . "\n" . $tuoi . "\n");
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);

    return true;
}

/**
 * Sinh token CSRF cho form thêm sinh viên.
 */
function csrfToken()
{
    if (empty($_SESSION['csrf_file'])) {
        $_SESSION['csrf_file'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_file'];
}

/**
 * So sánh token CSRF gửi lên bằng hash_equals (chống timing attack).
 */
function csrfCheck($t)
{
    return !empty($_SESSION['csrf_file'])
        && hash_equals($_SESSION['csrf_file'], (string)$t);
}
