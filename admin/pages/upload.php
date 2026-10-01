<?php
defined('IN_ADMIN') or exit('Forbidden');

$uploadDir = dirname(__DIR__, 2) . '/uploads/';
$allowed   = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
$maxSize   = 2 * 1024 * 1024;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
if (!file_exists($uploadDir . '.htaccess')) {
    file_put_contents($uploadDir . '.htaccess',
        "<FilesMatch \"\\.(php|phtml|phar|php[0-9])$\">\n    Require all denied\n</FilesMatch>\n");
}
?>
<h3>Trang upload Files</h3>
<form action="index.php?page=upload" method="post" enctype="multipart/form-data">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <input type="file" name="files[]"><br>
    <?php endfor; ?>
    <br>
    <input type="reset" value="Reset">
    <input type="submit" name="btnUpload" value="Upload">
</form>
<?php
if (isset($_POST['btnUpload']) && isset($_FILES['files']['name']) && is_array($_FILES['files']['name'])) {
    echo '<hr><h4>Kết quả:</h4>';
    $coFile = false;
    foreach ($_FILES['files']['name'] as $i => $name) {
        if ($name === '' || $_FILES['files']['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        $goc = basename($name);
        $ext = strtolower(pathinfo($goc, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            echo '<p class="error">Bỏ qua ' . h($goc) . ': định dạng không được phép.</p>';
            continue;
        }
        if ($_FILES['files']['size'][$i] > $maxSize) {
            echo '<p class="error">Bỏ qua ' . h($goc) . ': vượt quá 2 MB.</p>';
            continue;
        }
        $luu = bin2hex(random_bytes(8)) . '.' . $ext;
        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadDir . $luu)) {
            $coFile = true;
            echo '<p><a href="../uploads/' . $luu . '" download="' . h($goc) . '">Download File: ' . h($goc) . '</a></p>';
        }
    }
    if (!$coFile) {
        echo '<p>Chưa có file nào được upload.</p>';
    }
}
