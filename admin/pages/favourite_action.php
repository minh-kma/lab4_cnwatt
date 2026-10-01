<?php
defined('IN_ADMIN') or exit('Forbidden');

$token = is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : '';
$ds    = layYeuThich();
$loi   = '';

if (!hash_equals($_SESSION['csrf'], $token)) {
    $loi = 'Phiên không hợp lệ.';
} elseif (isset($_POST['btnAdd'])) {
    $t = is_string($_POST['title'] ?? null) ? trim($_POST['title']) : '';
    $u = is_string($_POST['url'] ?? null) ? trim($_POST['url']) : '';
    if ($t === '' || doDaiChuoi($t) > FAV_MAX_TITLE) {
        $loi = 'Tiêu đề phải từ 1 đến ' . FAV_MAX_TITLE . ' ký tự.';
    } elseif (!hopLeUrl($u)) {
        $loi = 'URL không hợp lệ (chỉ chấp nhận http/https, tối đa ' . FAV_MAX_URL . ' ký tự).';
    } elseif (count($ds) >= FAV_MAX_LINKS) {
        $loi = 'Tối đa ' . FAV_MAX_LINKS . ' link.';
    } else {
        $ds[] = ['t' => $t, 'u' => $u];
        luuYeuThich($ds);
    }
} elseif (isset($_POST['btnDelete'])) {
    $i = filter_var($_POST['index'] ?? null, FILTER_VALIDATE_INT);
    if ($i !== false && isset($ds[$i])) {
        unset($ds[$i]);
        luuYeuThich($ds);
    }
}

if ($loi !== '') {
    $_SESSION['flash_err'] = $loi;
}
header('Location: index.php?page=favourite');
exit;
