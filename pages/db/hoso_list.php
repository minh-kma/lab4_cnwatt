<?php
// Xử lý xóa (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_hoso') {
    if (csrfDbCheck($_POST['csrf'] ?? '')) {
        $mahs = trim($_POST['mahs'] ?? '');
        try {
            hosoDelete($mahs);
            $_SESSION['flash'] = 'Đã xóa hồ sơ ' . $mahs;
        } catch (PDOException $e) {
            $_SESSION['flash_error'] = 'Lỗi CSDL khi xóa.';
        }
    }
    $back = 'db.php?page=hoso_list&p=' . max(1, (int)($_POST['p'] ?? 1));
    redirect($back);
}

$limit     = 10;
$page_num  = max(1, (int)($_GET['p'] ?? 1));
$total     = hosoCount();
$totalPage = max(1, (int)ceil($total / $limit));
if ($page_num > $totalPage) $page_num = $totalPage;
$offset    = ($page_num - 1) * $limit;

$rows      = hosoPaged($offset, $limit);
$flash     = $_SESSION['flash']       ?? '';
$flash_err = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash'], $_SESSION['flash_error']);
?>
<h3>Danh sách hồ sơ học sinh (HOSO)</h3>

<?php if ($flash):     ?><div class="flash"><?= h($flash) ?></div><?php endif; ?>
<?php if ($flash_err): ?><div class="flash error"><?= h($flash_err) ?></div><?php endif; ?>

<p>
    <a href="db.php?page=hoso_form">+ Thêm hồ sơ mới</a>
    &nbsp;|&nbsp;
    Tổng: <b><?= $total ?></b> hồ sơ, trang <?= $page_num ?>/<?= $totalPage ?>.
</p>

<?php if (!$rows): ?>
    <p>Chưa có dữ liệu.</p>
<?php else: ?>
<table border="1" cellpadding="6" class="result-table">
    <tr>
        <th>Mã HS</th><th>Họ tên</th><th>Ngày sinh</th><th>Địa chỉ</th>
        <th>Lớp</th><th>Toán</th><th>Lý</th><th>Hóa</th><th>Thao tác</th>
    </tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= h($r['MAHS']) ?></td>
            <td><?= h($r['HOTEN']) ?></td>
            <td><?= h($r['NGAYSINH']) ?></td>
            <td><?= h($r['DIACHI']) ?></td>
            <td><?= h($r['LOP']) ?></td>
            <td><?= h($r['DIEMTOAN']) ?></td>
            <td><?= h($r['DIEMLY']) ?></td>
            <td><?= h($r['DIEMHOA']) ?></td>
            <td>
                <a href="db.php?page=hoso_form&amp;id=<?= urlencode($r['MAHS']) ?>">Sửa</a>
                |
                <form method="post" action="db.php?page=hoso_list" style="display:inline;"
                      onsubmit="return confirm('Xóa hồ sơ <?= h($r['MAHS']) ?>?');">
                    <input type="hidden" name="action" value="delete_hoso">
                    <input type="hidden" name="mahs"   value="<?= h($r['MAHS']) ?>">
                    <input type="hidden" name="p"      value="<?= $page_num ?>">
                    <input type="hidden" name="csrf"   value="<?= h(csrfDbToken()) ?>">
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="pagination" style="margin-top:10px;">
    <?php if ($page_num > 1): ?>
        <a href="db.php?page=hoso_list&amp;p=<?= $page_num - 1 ?>">&laquo; Trước</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
        <?php if ($i === $page_num): ?>
            <span class="current"><?= $i ?></span>
        <?php else: ?>
            <a href="db.php?page=hoso_list&amp;p=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page_num < $totalPage): ?>
        <a href="db.php?page=hoso_list&amp;p=<?= $page_num + 1 ?>">Sau &raquo;</a>
    <?php endif; ?>
</div>
<?php endif; ?>