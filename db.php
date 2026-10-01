<?php
/**
 * Router nhiệm vụ 11 - CSDL cơ bản
 * URL: db.php?page=home|lop_list|lop_form|hoso_list|hoso_form
 */
ob_start();

require_once __DIR__ . '/libs/session_init.php';
startSecureSession();

require_once __DIR__ . '/libs/db_helper.php';

$page    = $_GET['page'] ?? 'home';
$allowed = ['home', 'lop_list', 'lop_form', 'hoso_list', 'hoso_form'];
if (!in_array($page, $allowed, true)) {
    $page = 'home';
}

include __DIR__ . '/Head.php';
include __DIR__ . '/Menu.php';
?>
<main class="main-content">
    <div class="tabs">
        <a href="db.php?page=home"
           class="<?= $page === 'home' ? 'active' : '' ?>">Home</a>
        <a href="db.php?page=lop_list"
           class="<?= in_array($page, ['lop_list','lop_form'], true) ? 'active' : '' ?>">LOP</a>
        <a href="db.php?page=hoso_list"
           class="<?= in_array($page, ['hoso_list','hoso_form'], true) ? 'active' : '' ?>">HOSO</a>
    </div>

    <?php include __DIR__ . '/pages/db/' . $page . '.php'; ?>
</main>
<?php
include __DIR__ . '/Footer.php';

if (ob_get_level() > 0) {
    ob_end_flush();
}   