<?php
define('IN_ADMIN', true);
require __DIR__ . '/../libs/session_init.php';
require __DIR__ . '/../libs/cookie_helper.php';
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
if ($daDangNhap && empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

// Thêm/xóa link yêu thích: ghi cookie phải làm trước khi có output
if ($daDangNhap && $page === 'favourite' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/pages/favourite_action.php';
    exit;
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
            case 'favourite':
                include __DIR__ . '/pages/favourite.php';
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
