<?php
$errors  = [];
$success = '';
$ten     = '';
$dia_chi = '';
$tuoi    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        $ten     = cleanField($_POST['ten']     ?? '');
        $dia_chi = cleanField($_POST['dia_chi'] ?? '');
        $tuoi    = cleanField($_POST['tuoi']    ?? '');

        if ($ten === '' || $dia_chi === '' || $tuoi === '') {
            $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
        }
        if (doDai($ten) > 100) {
            $errors[] = 'Tên tối đa 100 ký tự.';
        }
        if (doDai($dia_chi) > 200) {
            $errors[] = 'Địa chỉ tối đa 200 ký tự.';
        }
        if ($tuoi !== '' && (!ctype_digit($tuoi) || (int)$tuoi < 1 || (int)$tuoi > 150)) {
            $errors[] = 'Tuổi phải là số nguyên từ 1 đến 150.';
        }

        if (!$errors) {
            if (ghiSinhVien($ten, $dia_chi, $tuoi)) {
                $success = 'Đã thêm sinh viên: ' . $ten;
                $ten = $dia_chi = $tuoi = '';
            } else {
                $errors[] = 'Không ghi được file. Kiểm tra quyền ghi thư mục data/.';
            }
        }
    }
}
?>
<h3>Thêm sinh viên mới</h3>

<?php foreach ($errors as $e): ?>
    <p class="error"><?= h($e) ?></p>
<?php endforeach; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= h($success) ?></p>
<?php endif; ?>

<form method="post" action="file.php?page=addStudent">
    <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">
    <table class="form-table">
        <tr>
            <td><label>Tên:</label></td>
            <td><input type="text" name="ten" maxlength="100" value="<?= h($ten) ?>" required></td>
        </tr>
        <tr>
            <td><label>Địa chỉ:</label></td>
            <td><input type="text" name="dia_chi" maxlength="200" value="<?= h($dia_chi) ?>" required></td>
        </tr>
        <tr>
            <td><label>Tuổi:</label></td>
            <td><input type="number" name="tuoi" min="1" max="150" value="<?= h($tuoi) ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="reset" value="Nhập lại">
                <input type="submit" value="Ghi">
            </td>
        </tr>
    </table>
</form>