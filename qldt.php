<?php
require_once __DIR__ . '/libs/session_init.php';
startSecureSession();
require_once __DIR__ . '/libs/qlsv_helper.php';

$page = $_GET['page'] ?? 'home';
$allowed = ['home', 'list', 'add', 'edit', 'detail', 'delete'];
if (!in_array($page, $allowed, true)) $page = 'home';

include __DIR__ . '/Head.php';
include __DIR__ . '/Menu.php';
?>
<main class="main-content">
    <div class="tabs">
        <a href="qldt.php?page=home" class="<?= $page==='home'?'active':'' ?>">Home</a>
        <a href="qldt.php?page=list" class="<?= in_array($page,['list','detail','edit','delete'])?'active':'' ?>">List</a>
        <a href="qldt.php?page=add"  class="<?= $page==='add' ?'active':'' ?>">Add</a>
    </div>
    <?php include __DIR__ . '/pages/qlsv/' . $page . '.php'; ?>
</main>
<?php include __DIR__ . '/Footer.php'; ?>