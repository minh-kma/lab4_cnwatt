<?php
$id      = trim($_GET['id'] ?? '');
$is_edit = $id !== '';

$errors = [];
$data   = ['MALOP' => '', 'TENLOP' => '', 'KHOAHOC' => '', 'GVCN' => ''];

if ($is_edit) {
    $found = lopFind($id);
    if (!$found) {
        redirect('db.php?page=lop_list');
    }
    $data = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfDbCheck($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        $data['MALOP']   = strtoupper(trim($_POST['malop']   ?? ''));
        $data['TENLOP']  = trim($_POST['tenlop']  ?? '');
        $data['KHOAHOC'] = trim($_POST['khoahoc'] ?? '');
        $data['GVCN']    = trim($_POST['gvcn']    ?? '');

        if (!preg_match('/^[A-Z0-9]{1,6}$/', $data['MALOP'])) {
            $errors[] = 'Mã lớp: 1-6 ký tự, chỉ chữ và số.';
        }
        if ($data['TENLOP'] === '' || mb_strlen_utf8($data['TENLOP']) > 50) {
            $errors[] = 'Tên lớp: bắt buộc, tối đa 50 ký tự.';
        }
        if (!ctype_digit($data['KHOAHOC']) || (int)$data['KHOAHOC'] < 0 || (int)$data['KHOAHOC'] > 200) {
            $errors[] = 'Khóa học: số nguyên 0-200.';
        }
        if (mb_strlen_utf8($data['GVCN']) > 50) {
            $errors[] = 'GVCN: tối đa 50 ký tự.';
        }

        if (!$errors) {
            try {
                if ($is_edit) {
                    lopUpdate($id, $data);
                    $_SESSION['flash'] = 'Đã cập nhật lớp ' . $id;
                } else {
                    lopInsert($data);
                    $_SESSION['flash'] = 'Đã thêm lớp ' . $data['MALOP'];
                }
                redirect('db.php?page=lop_list');
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $errors[] = 'Mã lớp đã tồn tại.';
                } else {
                    $errors[] = 'Lỗi CSDL: ' . $e->getMessage();
                }
            }
        }
    }
}

// Hàm đếm ký tự UTF-8 nếu không có mbstring
if (!function_exists('mb_strlen_utf8')) {
    function mb_strlen_utf8($s) {
        $n = 0; $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            if ((ord($s[$i]) & 0xC0) !== 0x80) $n++;
        }
        return $n;
    }
}
?>
<h3><?= $is_edit ? 'Sửa lớp ' . h($id) : 'Thêm lớp mới' ?></h3>

<?php foreach ($errors as $e): ?>
    <p class="error"><?= h($e) ?></p>
<?php endforeach; ?>

<form method="post"
      action="db.php?page=lop_form<?= $is_edit ? '&amp;id=' . urlencode($id) : '' ?>">
    <input type="hidden" name="csrf" value="<?= h(csrfDbToken()) ?>">
    <table class="form-table">
        <tr>
            <td><label>Mã lớp:</label></td>
            <td>
                <input type="text" name="malop" maxlength="6"
                       value="<?= h($data['MALOP']) ?>"
                       <?= $is_edit ? 'readonly' : 'required' ?>>
            </td>
        </tr>
        <tr>
            <td><label>Tên lớp:</label></td>
            <td><input type="text" name="tenlop" maxlength="50"
                       value="<?= h($data['TENLOP']) ?>" required></td>
        </tr>
        <tr>
            <td><label>Khóa học:</label></td>
            <td><input type="number" name="khoahoc" min="0" max="200"
                       value="<?= h($data['KHOAHOC']) ?>" required></td>
        </tr>
        <tr>
            <td><label>GVCN:</label></td>
            <td><input type="text" name="gvcn" maxlength="50"
                       value="<?= h($data['GVCN']) ?>"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit"><?= $is_edit ? 'Cập nhật' : 'Thêm' ?></button>
                <a href="db.php?page=lop_list">Hủy</a>
            </td>
        </tr>
    </table>
</form>