<?php
$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}
$tabs = [
    'home'       => 'Home',
    'drawTable'  => 'DrawTable',
    'calculate1' => 'Calculate1',
    'calculate2' => 'Calculate2',
    'array1'     => 'Array1',
    'array2'     => 'Array2',
];
include 'Head.php';
include 'Menu.php';
?>
<main class="main-content">
    <nav class="tabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="index.php?page=<?= $key ?>" class="<?= $page === $key ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
    <div class="content">
        <?php
        switch ($page) {
            case 'drawTable':
                include 'pages/drawTable.php';
                break;
            case 'calculate1':
                include 'pages/calculate1.php';
                break;
            case 'calculate2':
                include 'pages/calculate2.php';
                break;
            case 'array1':
                include 'pages/array1.php';
                break;
            case 'array2':
                include 'pages/array2.php';
                break;
            case 'uploadprocess':
                include 'pages/uploadprocess.php';
                break;
            case 'home':
            default:
                include 'pages/home.php';
                break;
        }
        ?>
    </div>
</main>
<?php include 'Footer.php'; ?>
