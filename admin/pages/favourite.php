<?php
defined('IN_ADMIN') or exit('Forbidden');
$ds = layYeuThich();
?>
<h3>Danh sách link ưa thích (lưu trong Cookie)</h3>
<?php if (!empty($_SESSION['flash_err'])): ?>
    <p class="error"><?= h($_SESSION['flash_err']) ?></p>
    <?php unset($_SESSION['flash_err']); ?>
<?php endif; ?>

<?php if (!$ds): ?>
    <p>Chưa có link nào.</p>
<?php else: ?>
    <ul>
        <?php foreach ($ds as $i => $item): ?>
            <li>
                <a href="<?= h($item['u']) ?>" target="_blank" rel="noopener noreferrer"><?= h($item['t']) ?></a>
                <form method="post" action="index.php?page=favourite" style="display:inline;">
                    <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                    <input type="hidden" name="index" value="<?= (int)$i ?>">
                    <button type="submit" name="btnDelete">Xóa</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h4>Thêm link mới</h4>
<form method="post" action="index.php?page=favourite">
    <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
    <table class="form-table">
        <tr><td>Tiêu đề:</td><td><input type="text" name="title" maxlength="<?= FAV_MAX_TITLE ?>" required></td></tr>
        <tr><td>URL:</td><td><input type="url" name="url" size="40" maxlength="<?= FAV_MAX_URL ?>" placeholder="https://..." required></td></tr>
        <tr><td></td><td><button type="submit" name="btnAdd">Add</button></td></tr>
    </table>
</form>
