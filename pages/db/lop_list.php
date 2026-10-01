<?php
// Xử lý xóa (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_lop') {
    if (csrfDbCheck($_POST['csrf'] ?? '')) {
        $malop = trim($_POST['malop'] ?? '');
        try {
            lopDelete($malop);
            $_SESSION['flash'] = 'Đã xóa lớp ' . $malop;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $_SESSION['flash_error'] = 'Không xóa được: vẫn còn hồ sơ tham chiếu lớp ' . $malop;
            } else {
                $_SESSION['flash_error'] = 'Lỗi CSDL khi xóa.';
            }
        }
    }
    redirect('db.php?page=lop_list');
}

$rows      = lopAll();
$flash     = $_SESSION['flash']       ?? '';
$flash_err = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash'], $_SESSION['flash_error']);
?>
<h3>Danh sách lớp học (LOP)</h3>

<?php if ($flash):     ?><div class="flash"><?= h($flash) ?></div><?php endif; ?>
<?php if ($flash_err): ?><div class="flash error"><?= h($flash_err) ?></div><?php endif; ?>

<p><a href="db.php?page=lop_form">+ Thêm lớp mới</a></p>

<?php if (!$rows): ?>
    <p>Chưa có dữ liệu.</p>
<?php else: ?>
<table border="1" cellpadding="6" class="result-table">
    <tr>
        <th>Mã lớp</th><th>Tên lớp</th><th>Khóa học</th><th>GVCN</th><th>Thao tác</th>
    </tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= h($r['MALOP']) ?></td>
            <td><?= h($r['TENLOP']) ?></td>
            <td><?= h($r['KHOAHOC']) ?></td>
            <td><?= h($r['GVCN']) ?></td>
            <td>
                <a href="db.php?page=lop_form&amp;id=<?= urlencode($r['MALOP']) ?>">Sửa</a>
                |
                <form method="post" action="db.php?page=lop_list" style="display:inline;"
                      onsubmit="return confirm('Bạn chắc chắn muốn xóa lớp <?= h($r['MALOP']) ?>?');">
                    <input type="hidden" name="action" value="delete_lop">
                    <input type="hidden" name="malop"  value="<?= h($r['MALOP']) ?>">
                    <input type="hidden" name="csrf"   value="<?= h(csrfDbToken()) ?>">
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>