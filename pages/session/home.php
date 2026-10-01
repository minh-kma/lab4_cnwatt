<h3>Trang Home - Session</h3>
<?php if (!empty($_SESSION['Username'])): ?>
    <p>Bạn đang đăng nhập với tên <b><?= h($_SESSION['Username']) ?></b>. <a href="admin/index.php">Vào trang quản trị</a></p>
<?php else: ?>
    <p>Bạn chưa đăng nhập. <a href="session.php?page=login">Đăng nhập</a></p>
<?php endif; ?>
