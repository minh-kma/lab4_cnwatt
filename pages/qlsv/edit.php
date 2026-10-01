<?php
$mssv = $_GET['id'] ?? '';
if (!validateMSSV($mssv)) {
    echo '<p class="error">MSSV không hợp lệ.</p>';
    return;
}
$ds  = docQLSV();
$idx = timTheoMSSV($ds, $mssv);
if ($idx === -1) {
    echo '<p class="error">Không tìm thấy sinh viên.</p>';
    return;
}
$sv = $ds[$idx];
$errors = []; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck9($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        $ten       = cleanField9($_POST['ten']       ?? '');
        $ngay_sinh = cleanField9($_POST['ngay_sinh'] ?? '');
        $dia_chi   = cleanField9($_POST['dia_chi']   ?? '');
        $lop       = cleanField9($_POST['lop']       ?? '');

        if ($ten === '' || $ngay_sinh === '' || $dia_chi === '' || $lop === '') {
            $errors[] = 'Vui lòng nhập đầy đủ.';
        }
        if (!validateNgaySinh($ngay_sinh)) {
            $errors[] = 'Ngày sinh phải đúng định dạng YYYY-MM-DD.';
        }

        if (!$errors) {
            $anhCu = $sv['anh'];
            $up = uploadAnh($_FILES['anh'] ?? []);
            if (!$up['ok']) {
                $errors[] = $up['msg'];
            } else {
                $anhMoi = $up['name'] ?? null;
                $anhDung = $anhMoi ?? $anhCu;

                $svMoi = [
                    'mssv' => $mssv,
                    'ten' => $ten, 'ngay_sinh' => $ngay_sinh,
                    'dia_chi' => $dia_chi, 'anh' => $anhDung, 'lop' => $lop,
                ];
                if (suaQLSV($mssv, $svMoi)) {
                    if ($anhMoi !== null && $anhCu !== '' && is_file(uploadDir() . $anhCu)) {
                        @unlink(uploadDir() . $anhCu);
                    }
                    $sv = $svMoi;
                    $success = 'Đã cập nhật.';
                } else {
                    if ($anhMoi !== null) @unlink(uploadDir() . $anhMoi);
                    $errors[] = 'Không ghi được file.';
                }
            }
        }
    }
}
?>
<h3>Sửa sinh viên: <?= h($sv['mssv']) ?></h3>
<?php foreach ($errors as $e): ?><p class="error"><?= h($e) ?></p><?php endforeach; ?>
<?php if ($success): ?><p style="color:green;"><?= h($success) ?></p><?php endif; ?>

<form method="post" action="qldt.php?page=edit&id=<?= urlencode($mssv) ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= h(csrfToken9()) ?>">
    <table class="form-table">
        <tr><td>MSSV:</td><td><?= h($sv['mssv']) ?> (không đổi)</td></tr>
        <tr><td>Tên:</td><td><input type="text" name="ten" maxlength="100" value="<?= h($sv['ten']) ?>" required></td></tr>
        <tr><td>Ngày sinh:</td><td><input type="date" name="ngay_sinh" value="<?= h($sv['ngay_sinh']) ?>" required></td></tr>
        <tr><td>Địa chỉ:</td><td><input type="text" name="dia_chi" maxlength="200" value="<?= h($sv['dia_chi']) ?>" required></td></tr>
        <tr><td>Lớp:</td><td><input type="text" name="lop" maxlength="50" value="<?= h($sv['lop']) ?>" required></td></tr>
        <tr><td>Ảnh hiện tại:</td><td>
            <?php if ($sv['anh'] !== '' && is_file(uploadDir() . $sv['anh'])): ?>
                <img src="uploads/qlsv/<?= h($sv['anh']) ?>" width="80">
            <?php else: ?><em>Chưa có</em><?php endif; ?>
        </td></tr>
        <tr><td>Đổi ảnh:</td><td><input type="file" name="anh" accept="image/jpeg,image/png,image/gif"></td></tr>
        <tr><td colspan="2"><input type="submit" value="Lưu"></td></tr>
    </table>
</form>
<p><a href="qldt.php?page=list">← Danh sách</a></p>