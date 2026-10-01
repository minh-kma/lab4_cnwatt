<?php
$mssv = $_GET['id'] ?? '';
if (!validateMSSV($mssv)) { echo '<p class="error">MSSV không hợp lệ.</p>'; return; }
$ds = docQLSV();
$idx = timTheoMSSV($ds, $mssv);
if ($idx === -1) { echo '<p class="error">Không tìm thấy.</p>'; return; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck9($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        if (xoaQLSV($mssv)) {
            header('Location: qldt.php?page=list');
            exit;
        }
        $errors[] = 'Không xóa được.';
    }
}
$sv = $ds[$idx];
?>
<h3>Xóa sinh viên</h3>
<?php foreach ($errors as $e): ?><p class="error"><?= h($e) ?></p><?php endforeach; ?>
<p>Bạn có chắc muốn xóa <b><?= h($sv['ten']) ?></b> (<?= h($sv['mssv']) ?>)?</p>
<form method="post" action="qldt.php?page=delete&id=<?= urlencode($mssv) ?>">
    <input type="hidden" name="csrf" value="<?= h(csrfToken9()) ?>">
    <input type="submit" value="Xóa">
    <a href="qldt.php?page=list">Hủy</a>
</form>