<?php defined('IN_ADMIN') or exit('Forbidden'); ?>
<?php if (!empty($_SESSION['flash'])): ?>
    <p style="color:green;"><?= h($_SESSION['flash']) ?></p>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
<h3>Thông tin người dùng</h3>
<table class="info-table">
    <tr><td>Tên đăng nhập:</td><td><?= h($_SESSION['Username']) ?></td></tr>
    <tr><td>Mật khẩu:</td><td>******** (không lưu trong session)</td></tr>
    <tr><td>Đăng nhập lúc:</td><td><?= h($_SESSION['LoginTime'] ?? '') ?></td></tr>
</table>
