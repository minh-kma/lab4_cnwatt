<?php
$id      = trim($_GET['id'] ?? '');
$is_edit = $id !== '';

$errors = [];
$data   = [
    'MAHS' => '', 'HOTEN' => '', 'NGAYSINH' => '', 'DIACHI' => '',
    'LOP'  => '', 'DIEMTOAN' => '', 'DIEMLY' => '', 'DIEMHOA' => '',
];

if ($is_edit) {
    $found = hosoFind($id);
    if (!$found) {
        redirect('db.php?page=hoso_list');
    }
    $data = $found;
}

$lopList = lopOptions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfDbCheck($_POST['csrf'] ?? '')) {
        $errors[] = 'Token không hợp lệ.';
    } else {
        $data['MAHS']     = strtoupper(trim($_POST['mahs']     ?? ''));
        $data['HOTEN']    = trim($_POST['hoten']    ?? '');
        $data['NGAYSINH'] = trim($_POST['ngaysinh'] ?? '');
        $data['DIACHI']   = trim($_POST['diachi']   ?? '');
        $data['LOP']      = trim($_POST['lop']      ?? '');
        $data['DIEMTOAN'] = trim($_POST['diemtoan'] ?? '');
        $data['DIEMLY']   = trim($_POST['diemly']   ?? '');
        $data['DIEMHOA']  = trim($_POST['diemhoa']  ?? '');

        if (!preg_match('/^[A-Z0-9]{1,8}$/', $data['MAHS'])) {
            $errors[] = 'Mã HS: 1-8 ký tự, chỉ chữ và số.';
        }
        if ($data['HOTEN'] === '' || mb_strlen_utf8($data['HOTEN']) > 50) {
            $errors[] = 'Họ tên: bắt buộc, tối đa 50 ký tự.';
        }
        $d = DateTime::createFromFormat('Y-m-d', $data['NGAYSINH']);
        if (!$d || $d->format('Y-m-d') !== $data['NGAYSINH']) {
            $errors[] = 'Ngày sinh không hợp lệ (định dạng YYYY-MM-DD).';
        }
        if (mb_strlen_utf8($data['DIACHI']) > 150) {
            $errors[] = 'Địa chỉ: tối đa 150 ký tự.';
        }
        if (!isset($lopList[$data['LOP']])) {
            $errors[] = 'Lớp không tồn tại trong bảng LOP.';
        }
        foreach (['DIEMTOAN' => 'Toán', 'DIEMLY' => 'Lý', 'DIEMHOA' => 'Hóa'] as $k => $ten) {
            $v = $data[$k];
            if ($v === '') {
                $data[$k] = null; // cho phép NULL
                continue;
            }
            if (!is_numeric($v) || (float)$v < 0 || (float)$v > 10) {
                $errors[] = "Điểm $ten: số 0-10 (hoặc để trống).";
            } else {
                $data[$k] = (float)$v;
            }
        }

        if (!$errors) {
            try {
                if ($is_edit) {
                    hosoUpdate($id, $data);
                    $_SESSION['flash'] = 'Đã cập nhật hồ sơ ' . $id;
                } else {
                    hosoInsert($data);
                    $_SESSION['flash'] = 'Đã thêm hồ sơ ' . $data['MAHS'];
                }
                redirect('db.php?page=hoso_list');
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $errors[] = 'Mã HS đã tồn tại hoặc lớp không hợp lệ.';
                } else {
                    $errors[] = 'Lỗi CSDL: ' . $e->getMessage();
                }
            }
        }
    }
}

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
<h3><?= $is_edit ? 'Sửa hồ sơ ' . h($id) : 'Thêm hồ sơ học sinh' ?></h3>

<?php foreach ($errors as $e): ?>
    <p class="error"><?= h($e) ?></p>
<?php endforeach; ?>

<form method="post"
      action="db.php?page=hoso_form<?= $is_edit ? '&amp;id=' . urlencode($id) : '' ?>">
    <input type="hidden" name="csrf" value="<?= h(csrfDbToken()) ?>">
    <table class="form-table">
        <tr>
            <td><label>Mã HS:</label></td>
            <td>
                <input type="text" name="mahs" maxlength="8"
                       value="<?= h($data['MAHS']) ?>"
                       <?= $is_edit ? 'readonly' : 'required' ?>>
            </td>
        </tr>
        <tr>
            <td><label>Họ tên:</label></td>
            <td><input type="text" name="hoten" maxlength="50"
                       value="<?= h($data['HOTEN']) ?>" required></td>
        </tr>
        <tr>
            <td><label>Ngày sinh:</label></td>
            <td><input type="date" name="ngaysinh"
                       value="<?= h($data['NGAYSINH']) ?>" required></td>
        </tr>
        <tr>
            <td><label>Địa chỉ:</label></td>
            <td><input type="text" name="diachi" maxlength="150"
                       value="<?= h($data['DIACHI']) ?>"></td>
        </tr>
        <tr>
            <td><label>Lớp:</label></td>
            <td>
                <select name="lop" required>
                    <option value="">-- Chọn lớp --</option>
                    <?php foreach ($lopList as $ma => $ten): ?>
                        <option value="<?= h($ma) ?>"
                            <?= $data['LOP'] === $ma ? 'selected' : '' ?>>
                            <?= h($ma . ' - ' . $ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Điểm Toán:</label></td>
            <td><input type="number" name="diemtoan" step="0.1" min="0" max="10"
                       value="<?= h($data['DIEMTOAN']) ?>"></td>
        </tr>
        <tr>
            <td><label>Điểm Lý:</label></td>
            <td><input type="number" name="diemly" step="0.1" min="0" max="10"
                       value="<?= h($data['DIEMLY']) ?>"></td>
        </tr>
        <tr>
            <td><label>Điểm Hóa:</label></td>
            <td><input type="number" name="diemhoa" step="0.1" min="0" max="10"
                       value="<?= h($data['DIEMHOA']) ?>"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit"><?= $is_edit ? 'Cập nhật' : 'Thêm' ?></button>
                <a href="db.php?page=hoso_list">Hủy</a>
            </td>
        </tr>
    </table>
</form>