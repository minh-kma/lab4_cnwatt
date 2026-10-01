<?php
function qlsvPath() {
    return __DIR__ . '/../data/qlsv.txt';
}

function uploadDir() {
    return __DIR__ . '/../uploads/qlsv/';
}

function cleanField9($s) {
    $s = (string)$s;
    $s = str_replace(["\r", "\n", "\0", "|"], ' ', $s);
    return trim(preg_replace('/\s+/u', ' ', $s));
}

function docQLSV() {
    $path = qlsvPath();
    if (!is_file($path)) return [];
    $fp = @fopen($path, 'r');
    if (!$fp) return [];
    flock($fp, LOCK_SH);
    $kq = [];
    while (($line = fgets($fp)) !== false) {
        $line = rtrim($line, "\r\n");
        if ($line === '') continue;
        $parts = explode('|', $line);
        if (count($parts) < 6) continue;
        $kq[] = [
            'mssv'      => $parts[0],
            'ten'       => $parts[1],
            'ngay_sinh' => $parts[2],
            'dia_chi'   => $parts[3],
            'anh'       => $parts[4],
            'lop'       => $parts[5],
        ];
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    return $kq;
}

function ghiQLSV($ds) {
    $path = qlsvPath();
    $dir = dirname($path);
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $fp = @fopen($path, 'w');
    if (!$fp) return false;
    flock($fp, LOCK_EX);
    foreach ($ds as $sv) {
        $line = implode('|', [
            $sv['mssv'], $sv['ten'], $sv['ngay_sinh'],
            $sv['dia_chi'], $sv['anh'], $sv['lop'],
        ]);
        fwrite($fp, $line . "\n");
    }
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

function timTheoMSSV($ds, $mssv) {
    foreach ($ds as $i => $sv) {
        if ($sv['mssv'] === $mssv) return $i;
    }
    return -1;
}

function themQLSV($sv) {
    $ds = docQLSV();
    if (timTheoMSSV($ds, $sv['mssv']) !== -1) return false;
    $ds[] = $sv;
    return ghiQLSV($ds);
}

function suaQLSV($mssv, $sv) {
    $ds = docQLSV();
    $idx = timTheoMSSV($ds, $mssv);
    if ($idx === -1) return false;
    $ds[$idx] = $sv;
    return ghiQLSV($ds);
}

function xoaQLSV($mssv) {
    $ds = docQLSV();
    $idx = timTheoMSSV($ds, $mssv);
    if ($idx === -1) return false;
    $anh = $ds[$idx]['anh'];
    array_splice($ds, $idx, 1);
    $ok = ghiQLSV($ds);
    if ($ok && $anh !== '' && is_file(uploadDir() . $anh)) {
        @unlink(uploadDir() . $anh);
    }
    return $ok;
}

function validateMSSV($mssv) {
    return preg_match('/^[A-Za-z0-9_-]{1,20}$/', $mssv) === 1;
}

function validateNgaySinh($s) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $s)) return false;
    [$y, $m, $d] = explode('-', $s);
    return checkdate((int)$m, (int)$d, (int)$y);
}

function csrfToken9() {
    if (empty($_SESSION['csrf_qlsv'])) {
        $_SESSION['csrf_qlsv'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_qlsv'];
}

function csrfCheck9($t) {
    return !empty($_SESSION['csrf_qlsv']) && hash_equals($_SESSION['csrf_qlsv'], (string)$t);
}

function uploadAnh($file) {
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'name' => null]; // không upload
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'msg' => 'Lỗi upload (code ' . $file['error'] . ').'];
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        return ['ok' => false, 'msg' => 'Ảnh tối đa 2 MB.'];
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $choPhep = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
    ];
    if (!isset($choPhep[$mime])) {
        return ['ok' => false, 'msg' => 'Chỉ nhận ảnh JPG, PNG, GIF.'];
    }
    $dir = uploadDir();
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $name = bin2hex(random_bytes(16)) . '.' . $choPhep[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . $name)) {
        return ['ok' => false, 'msg' => 'Không lưu được ảnh.'];
    }
    return ['ok' => true, 'name' => $name];
}