<?php
const SO_PHAN_TU = 10;

$mac_dinh = [3, 3, 3, 1, 3, 3, 5, 3, 3, 3];
$vao      = $mac_dinh;
$msg      = '';
$mang     = [];
$coKetQua = false;

if (isset($_POST['btnTinh'])) {
    $raw = $_POST['so'] ?? [];
    $vao = [];
    $ok  = is_array($raw) && count($raw) === SO_PHAN_TU;
    if ($ok) {
        foreach ($raw as $v) {
            if (!is_string($v) || trim($v) === '' || !is_numeric(trim($v))) {
                $ok = false;
            }
            $vao[] = is_string($v) ? trim($v) : '';
        }
    }
    if ($ok) {
        $mang     = array_map(fn($v) => $v + 0, $vao);
        $coKetQua = true;
    } else {
        $msg = 'Vui lòng nhập đủ ' . SO_PHAN_TU . ' số hợp lệ.';
        $vao = array_pad(array_map(fn($v) => is_string($v) ? $v : '', array_slice($vao, 0, SO_PHAN_TU)), SO_PHAN_TU, '');
    }
}
?>
<p>Thao tác trên mảng 1 chiều:</p>
<p>Bài toán: nhập vào chuỗi số, tính tổng các số, giá trị trung bình, tìm min, max.</p>
<?php if ($msg !== ''): ?><p class="error"><?= h($msg) ?></p><?php endif; ?>
<form method="post" action="function.php?page=ar1Chieu">
    <div class="mang-input">
        <?php foreach ($vao as $v): ?>
            <input type="text" name="so[]" value="<?= h($v) ?>" required>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:8px;">
        <input type="reset" value="Reset">
        <input type="submit" name="btnTinh" value="Calculate">
    </div>
</form>
<?php if ($coKetQua): ?>
    <div class="result-box">
        <p><b>KẾT QUẢ:</b></p>
        <p>Tổng: <?= h(tongDay($mang)) ?></p>
        <p>Trung bình: <?= h(round(avgDay($mang), 4)) ?></p>
        <p>Min: <?= h(minDay($mang)) ?></p>
        <p>Max: <?= h(maxDay($mang)) ?></p>
        <p>Sắp xếp tăng dần: <?= h(implode(', ', sortDay($mang))) ?></p>
        <p>Sắp xếp giảm dần: <?= h(implode(', ', sortDay($mang, false))) ?></p>
        <p>Đảo ngược dãy: <?= h(implode(', ', daoNguocDay($mang))) ?></p>
    </div>
<?php endif; ?>
