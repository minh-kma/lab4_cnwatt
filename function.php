<?php
require_once __DIR__ . '/libs/xuLyMangSo.php';
require_once __DIR__ . '/libs/xuLyMatran.php';

if (!function_exists('h')) {
    function h($v): string
    {
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
    }
}

$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}
$tabs = ['home' => 'Home', 'ar1Chieu' => 'Ar1Chieu', 'matrix' => 'Matrix'];

include 'Head.php';
include 'Menu.php';
?>
<main class="main-content">
    <nav class="tabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="function.php?page=<?= $key ?>" class="<?= $page === $key ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
    <div class="content">
        <?php
        switch ($page) {
            case 'ar1Chieu':
                include 'pages/function/ar1Chieu.php';
                break;
            case 'matrix':
                include 'pages/function/matrix.php';
                break;
            case 'home':
            default:
                include 'pages/function/home.php';
                break;
        }
        ?>
    </div>
</main>
<?php include 'Footer.php'; ?>
