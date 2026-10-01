<?php include 'Head.php'; include 'Menu.php'; ?>
<main class="main-content">
    <?php include 'TabMenu.php'; ?>
    <h3 style="text-align:center;">Kết quả đăng ký</h3>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div style="text-align:center;">
            Tên: <?= htmlspecialchars($_POST['ten'] ?? '') ?><br><br>
            Địa chỉ: <?= htmlspecialchars($_POST['dia_chi'] ?? '') ?><br><br>
            Nghề: <?= htmlspecialchars($_POST['nghe'] ?? '') ?><br><br>
            Ghi chú: <?= nl2br(htmlspecialchars($_POST['ghi_chu'] ?? '')) ?>
        </div>
    <?php else: ?>
        <p style="text-align:center;">Chưa có dữ liệu đăng ký.</p>
    <?php endif; ?>
</main>
<?php include 'Footer.php'; ?>
