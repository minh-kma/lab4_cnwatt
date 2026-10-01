<?php
$ds = docQLSV();
$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
if (strlen($q) > 100) $q = '';
if ($q !== '') {
    $ds = array_values(array_filter($ds, function ($sv) use ($q) {
        return stripos($sv['ten'], $q) !== false
            || stripos($sv['mssv'], $q) !== false
            || stripos($sv['lop'], $q) !== false;
    }));
}
?>
<h3>Danh sách sinh viên</h3>

<form method="get" action="qldt.php">
    <input type="hidden" name="page" value="list">
    <label>Tìm:</label>
    <input type="text" name="q" maxlength="100" value="<?= h($q) ?>">
    <input type="submit" value="Tìm">
    <?php if ($q !== ''): ?><a href="qldt.php?page=list">Xóa lọc</a><?php endif; ?>
</form>
<p><a href="qldt.php?page=add">+ Thêm sinh viên</a></p>

<?php if (!$ds): ?>
    <p>Chưa có sinh viên nào.</p>
<?php else: ?>
<table border="1" cellpadding="5" class="result-table">
    <tr>
        <th>STT</th><th>MSSV</th><th>Tên</th><th>Ngày sinh</th>
        <th>Địa chỉ</th><th>Ảnh</th><th>Lớp</th><th>Thao tác</th>
    </tr>
    <?php foreach ($ds as $i => $sv): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= h($sv['mssv']) ?></td>
            <td><?= h($sv['ten']) ?></td>
            <td><?= h($sv['ngay_sinh']) ?></td>
            <td><?= h($sv['dia_chi']) ?></td>
            <td>
                <?php if ($sv['anh'] !== '' && is_file(uploadDir() . $sv['anh'])): ?>
                    <img src="uploads/qlsv/<?= h($sv['anh']) ?>" alt="avatar" width="60">
                <?php else: ?>
                    <em>Chưa có</em>
                <?php endif; ?>
            </td>
            <td><?= h($sv['lop']) ?></td>
            <td>
                <a href="qldt.php?page=detail&id=<?= urlencode($sv['mssv']) ?>">Detail</a> |
                <a href="qldt.php?page=edit&id=<?= urlencode($sv['mssv']) ?>">Edit</a> |
                <a href="qldt.php?page=delete&id=<?= urlencode($sv['mssv']) ?>"
                   onclick="return confirm('Xóa sinh viên <?= h(addslashes($sv['ten'])) ?>?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>