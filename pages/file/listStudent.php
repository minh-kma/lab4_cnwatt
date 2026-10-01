<?php
$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
if (doDai($q) > 100) {
    $q = '';
}

$all      = docSinhVien();
$filtered = $all;

if ($q !== '') {
    $filtered = array_values(array_filter($all, function ($sv) use ($q) {
        return stripos($sv['ten'], $q) !== false
            || stripos($sv['dia_chi'], $q) !== false;
    }));
}
?>
<h3>Danh sách sinh viên</h3>

<form method="get" action="file.php">
    <input type="hidden" name="page" value="listStudent">
    <label>Tìm kiếm:</label>
    <input type="text" name="q" maxlength="100" value="<?= h($q) ?>">
    <input type="submit" value="Tìm">
    <?php if ($q !== ''): ?>
        <a href="file.php?page=listStudent">Xóa lọc</a>
    <?php endif; ?>
</form>

<p>Tổng: <b><?= count($filtered) ?></b> sinh viên<?= $q !== '' ? ' (đã lọc từ ' . count($all) . ')' : '' ?>.</p>

<?php if (!$filtered): ?>
    <p>Chưa có dữ liệu.</p>
<?php else: ?>
    <table border="1" cellpadding="5" class="result-table">
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Địa chỉ</th>
            <th>Tuổi</th>
        </tr>
        <?php foreach ($filtered as $i => $sv): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= h($sv['ten']) ?></td>
                <td><?= h($sv['dia_chi']) ?></td>
                <td><?= h($sv['tuoi']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>