<?php
$hovaten = $lop = $m1 = $m2 = $m3 = $tongdiem = $msg = '';

if (isset($_POST['ok'])) {
    $hovaten = trim((string)($_POST['hovaten'] ?? ''));
    $lop     = trim((string)($_POST['lop'] ?? ''));
    $m1      = trim((string)($_POST['m1'] ?? ''));
    $m2      = trim((string)($_POST['m2'] ?? ''));
    $m3      = trim((string)($_POST['m3'] ?? ''));

    if ($hovaten === '' || $lop === '' || $m1 === '' || $m2 === '' || $m3 === '') {
        $msg = "Vui lòng nhập đầy đủ thông tin!";
    } elseif (!is_numeric($m1) || !is_numeric($m2) || !is_numeric($m3)) {
        $msg = "Điểm M1, M2, M3 phải là số!";
    } else {
        $tongdiem = (float)$m1 + (float)$m2 + (float)$m3;
    }
}
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>
<div class="form-container">
    <h3 style="text-align:center;">Bảng Điểm</h3>
    <?php if ($msg): ?><p class="error"><?= $h($msg) ?></p><?php endif; ?>
    <form action="" method="POST">
        <div class="form-group"><label>Họ và tên</label><input type="text" name="hovaten" value="<?= $h($hovaten) ?>"></div>
        <div class="form-group"><label>Lớp</label><input type="text" name="lop" value="<?= $h($lop) ?>"></div>
        <div class="form-group"><label>Điểm M1</label><input type="text" name="m1" value="<?= $h($m1) ?>"></div>
        <div class="form-group"><label>Điểm M2</label><input type="text" name="m2" value="<?= $h($m2) ?>"></div>
        <div class="form-group"><label>Điểm M3</label><input type="text" name="m3" value="<?= $h($m3) ?>"></div>
        <div class="form-group"><label>Tổng điểm</label><input type="text" name="tongdiem" value="<?= $h($tongdiem) ?>" readonly style="background-color:#e9e9e9;"></div>
        <div class="buttons">
            <input type="submit" name="ok" value="OK">
            <input type="button" value="CanCel" onclick="window.location.href='index.php?page=calculate2'">
        </div>
    </form>
</div>
