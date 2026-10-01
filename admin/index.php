<?php
define('IN_ADMIN', true);
require __DIR__ . '/../libs/session_init.php';
startSecureSession();

$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}

// Logout phải chạy trước khi có output vì dùng header()
if ($page === 'logout') {
    include __DIR__ . '/pages/logout.php';
    exit;
}

$daDangNhap = !empty($_SESSION['Username']);
if (!$daDangNhap) {
    http_response_code(401);
}

$basePath = '../'; // để Head.php trỏ đúng tới style.css và images/ từ thư mục admin

include __DIR__ . '/../Head.php';
include __DIR__ . '/MenuAdmin.php';
?>
<main class="main-content">
    <?php
    if (!$daDangNhap) {
        echo '<p class="error">Chưa đăng nhập. Bạn không được phép sử dụng các trang trong khu vực quản trị.</p>';
        echo '<p><a href="../session.php?page=login">Đến trang đăng nhập</a></p>';
    } else {
        switch ($page) {
            case 'upload':
                include __DIR__ . '/pages/upload.php';
                break;
            case 'home':
            default:
                include __DIR__ . '/pages/home.php';
                break;
        }
    }
    ?>
</main>
<?php include __DIR__ . '/../Footer.php'; ?>
