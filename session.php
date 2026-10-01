<?php
require __DIR__ . '/libs/session_init.php';
startSecureSession();

$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}
$tabs = ['home' => 'Home', 'login' => 'Login'];

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

// Xử lý đăng nhập TRƯỚC khi in bất kỳ HTML nào (header() chỉ chạy được khi chưa có output)
$loginError = '';
$lastUser   = '';
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = is_string($_POST['txtUsername'] ?? null) ? trim($_POST['txtUsername']) : '';
    $pass  = is_string($_POST['txtPassword'] ?? null) ? $_POST['txtPassword'] : '';
    $token = is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : '';
    $lastUser = $name;

    if (!hash_equals($_SESSION['csrf'], $token)) {
        $loginError = 'Phiên không hợp lệ, vui lòng thử lại.';
    } elseif (hash_equals('admin', $name) && hash_equals('admin', $pass)) {
        session_regenerate_id(true);
        $_SESSION['Username']  = $name;
        $_SESSION['LoginTime'] = date('d/m/Y H:i:s');
        $_SESSION['flash']     = 'Đăng nhập thành công!';
        header('Location: admin/index.php');
        exit;
    } else {
        $loginError = 'Tên đăng nhập hoặc mật khẩu không đúng.';
    }
}

include 'Head.php';
include 'Menu.php';
?>
<main class="main-content">
    <nav class="tabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="session.php?page=<?= $key ?>" class="<?= $page === $key ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
    <div class="content">
        <?php
        switch ($page) {
            case 'login':
                include 'pages/session/login.php';
                break;
            case 'home':
            default:
                include 'pages/session/home.php';
                break;
        }
        ?>
    </div>
</main>
<?php include 'Footer.php'; ?>
