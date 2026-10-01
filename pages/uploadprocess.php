<h2>Danh sách file đã upload</h2>
<?php
$uploadDir = dirname(__DIR__) . '/uploads/';
$webDir    = 'uploads/';
$allowed   = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
$maxSize   = 2 * 1024 * 1024;
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$coFile = false;
if (isset($_FILES['files']['name']) && is_array($_FILES['files']['name'])) {
    foreach ($_FILES['files']['name'] as $i => $name) {
        if ($name === '' || $_FILES['files']['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        $goc = basename($name);
        $ext = strtolower(pathinfo($goc, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            echo "<p style='color:red'>Bỏ qua " . $h($goc) . ": định dạng không được phép.</p>";
            continue;
        }
        if ($_FILES['files']['size'][$i] > $maxSize) {
            echo "<p style='color:red'>Bỏ qua " . $h($goc) . ": vượt quá 2 MB.</p>";
            continue;
        }

        $luu = bin2hex(random_bytes(8)) . '.' . $ext;
        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadDir . $luu)) {
            $coFile = true;
            echo "<p><a href='" . $webDir . $luu . "' download=\"" . $h($goc) . "\">Download File: " . $h($goc) . "</a></p>";
        }
    }
}
if (!$coFile) {
    echo "<p>Chưa có file nào được upload.</p>";
}
