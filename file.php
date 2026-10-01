<?php
/**
 * Router nhiệm vụ 8 - Đọc/ghi file
 * URL: file.php?page=home | listStudent | addStudent
 */

require_once __DIR__ . '/libs/session_init.php';
startSecureSession();

require_once __DIR__ . '/libs/file_helper.php';

$page    = $_GET['page'] ?? 'home';
$allowed = ['home', 'listStudent', 'addStudent'];
if (!in_array($page, $allowed, true)) {
    $page = 'home';
}

include __DIR__ . '/Head.php';
include __DIR__ . '/Menu.php';
?>
<main class="main-content">
    <div class="tabs">
        <a href="file.php?page=home"        class="<?= $page === 'home'        ? 'active' : '' ?>">Home</a>
        <a href="file.php?page=listStudent" class="<?= $page === 'listStudent' ? 'active' : '' ?>">ListStudent</a>
        <a href="file.php?page=addStudent"  class="<?= $page === 'addStudent'  ? 'active' : '' ?>">Add Student</a>
    </div>

    <?php include __DIR__ . '/pages/file/' . $page . '.php'; ?>
</main>
<?php
include __DIR__ . '/Footer.php';