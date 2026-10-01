<?php
include 'Head.php';
include 'Menu.php';

$n = 10;
$giaiThua = 1;
for ($i = 2; $i <= $n; $i++) {
    $giaiThua *= $i;
}

$r = 10;
$dienTich = M_PI * $r ** 2;
$theTich  = (4 / 3) * M_PI * $r ** 3;
?>
<main class="main-content">
    <?php include 'TabMenu.php'; ?>
    <h3>Trang tính toán</h3>
    <p><b>Giai thừa của 10:</b> <?= $giaiThua ?></p>
    <p><b>Diện tích hình tròn (r = 10):</b> <?= round($dienTich, 2) ?></p>
    <p><b>Thể tích khối cầu (r = 10):</b> <?= round($theTich, 2) ?></p>
    <hr>
    <div class="marquee"><span>Hello</span></div>
</main>
<?php include 'Footer.php'; ?>
