<?php
$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}
$tabs = [
    'home'         => 'Home',
    'register'     => 'Register',
    'contact1Page' => 'Contact1Page',
];

function h($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

include 'Head.php';
include 'Menu.php';
?>
<main class="main-content">
    <nav class="tabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="getform.php?page=<?= $key ?>" class="<?= $page === $key || ($page === 'registerProcess' && $key === 'register') ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
    <div class="content">
        <?php
        switch ($page) {
            case 'register':
                include 'pages/getform/register.php';
                break;
            case 'registerProcess':
                include 'pages/getform/registerProcess.php';
                break;
            case 'contact1Page':
                include 'pages/getform/contact1Page.php';
                break;
            case 'home':
            default:
                include 'pages/getform/home.php';
                break;
        }
        ?>
    </div>
</main>
<?php include 'Footer.php'; ?>
