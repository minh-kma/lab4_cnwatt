<?php
$mssv = $_GET['id'] ?? '';
if (!validateMSSV($mssv)) { echo '<p class="error">MSSV không hợp lệ.</p>'; return; }
$ds = docQLSV();
$idx = timTheoMSSV($ds, $mssv);
if ($idx === -1) { echo '<p class="error">Không tìm thấy.</p>'; return; }
$sv = $ds[$idx];
?>
<h3>Chi tiết sinh viên</h3>
<table class="info-table" border="1" cellpadding="6">
    <tr><td>MSSV:</td><td><?= h($sv['mssv']) ?></td></tr>
    <tr><td>Tên:</td><td><?= h($sv['ten']) ?></td></tr>
    <tr><td>Ngày sinh:</td><td><?= h($sv['ngay_sinh']) ?></td></tr>
    <tr><td>Địa chỉ:</td><td><?= h($sv['dia_chi']) ?></td></tr>
    <tr><td>Lớp:</td><td><?= h($sv['lop']) ?></td></tr>
    <tr><td>Ảnh:</td><td>
        <?php if ($sv['anh'] !== '' && is_file(uploadDir() . $sv['anh'])): ?>
            <img src="uploads/qlsv/<?= h($sv['anh']) ?>" width="200">
        <?php else: ?><em>Chưa có</em><?php endif; ?>
    </td></tr>
</table>
<p>
    <a href="qldt.php?page=edit&id=<?= urlencode($mssv) ?>">Sửa</a> |
    <a href="qldt.php?page=list">← Danh sách</a>
</p>