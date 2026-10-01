<?php
$errors = []; $success = '';
$sv = ['mssv'=>'','ten'=>'','ngay_sinh'=>'','dia_chi'=>'','anh'=>'','lop'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck9($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        $sv['mssv']      = cleanField9($_POST['mssv']      ?? '');
        $sv['ten']       = cleanField9($_POST['ten']       ?? '');
        $sv['ngay_sinh'] = cleanField9($_POST['ngay_sinh'] ?? '');
        $sv['dia_chi']   = cleanField9($_POST['dia_chi']   ?? '');
        $sv['lop']       = cleanField9($_POST['lop']       ?? '');

        if ($sv['mssv'] === '' || $sv['ten'] === '' || $sv['ngay_sinh'] === '' || $sv['dia_chi'] === '' || $sv['lop'] === '') {
            $errors[] = 'Vui lòng nhập đầy đủ.';
        }
        if ($sv['mssv'] !== '' && !validateMSSV($sv['mssv'])) {
            $errors[] = 'MSSV chỉ chứa chữ, số, gạch dưới, gạch ngang (1–20 ký tự).';
        }
        if ($sv['ngay_sinh'] !== '' && !validateNgaySinh($sv['ngay_sinh'])) {
            $errors[] = 'Ngày sinh phải đúng định dạng YYYY-MM-DD.';
        }
        if (!$errors) {
            $up = uploadAnh($_FILES['anh'] ?? []);
            if (!$up['ok']) {
                $errors[] = $up['msg'];
            } else {
                $sv['anh'] = $up['name'] ?? '';
                if (themQLSV($sv)) {
                    $success = 'Đã thêm sinh viên ' . $sv['mssv'];
                    $sv = ['mssv'=>'','ten'=>'','ngay_sinh'=>'','dia_chi'=>'','anh'=>'','lop'=>''];
                } else {
                    $errors[] = 'MSSV đã tồn tại hoặc không ghi được file.';
                }
            }
        }
    }
}
?>
<h3>Thêm sinh viên</h3>
<?php foreach ($errors as $e): ?><p class="error"><?= h($e) ?></p><?php endforeach; ?>
<?php if ($success): ?><p style="color:green;"><?= h($success) ?></p><?php endif; ?>

<form method="post" action="qldt.php?page=add" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= h(csrfToken9()) ?>">
    <table class="form-table">
        <tr><td>MSSV:</td><td><input type="text" name="mssv" maxlength="20" value="<?= h($sv['mssv']) ?>" required></td></tr>
        <tr><td>Tên:</td><td><input type="text" name="ten" maxlength="100" value="<?= h($sv['ten']) ?>" required></td></tr>
        <tr><td>Ngày sinh:</td><td><input type="date" name="ngay_sinh" value="<?= h($sv['ngay_sinh']) ?>" required></td></tr>
        <tr><td>Địa chỉ:</td><td><input type="text" name="dia_chi" maxlength="200" value="<?= h($sv['dia_chi']) ?>" required></td></tr>
        <tr><td>Lớp:</td><td><input type="text" name="lop" maxlength="50" value="<?= h($sv['lop']) ?>" required></td></tr>
        <tr><td>Ảnh:</td><td><input type="file" name="anh" accept="image/jpeg,image/png,image/gif"></td></tr>
        <tr><td colspan="2"><input type="submit" value="Ghi"></td></tr>
    </table>
</form>