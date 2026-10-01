<h3 style="text-align:center;">Đăng nhập</h3>
<?php if ($loginError !== ''): ?>
    <p class="error" style="text-align:center;"><?= h($loginError) ?></p>
<?php endif; ?>
<?php if ($lastTime > 0 && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
    <p style="text-align:center;">Lần đăng nhập trước: <?= h(date('d/m/Y H:i:s', $lastTime)) ?></p>
<?php endif; ?>
<form action="cookie.php?page=login" method="post">
    <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
    <table class="form-table" align="center">
        <tr>
            <td>Username:</td>
            <td><input type="text" name="txtUsername" value="<?= h($cookieUser) ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="txtPassword" autocomplete="current-password" required></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="reset" value="Nhập Lại">
                <input type="submit" name="btnDangNhap" value="Đăng Nhập">
            </td>
        </tr>
    </table>
</form>
<?php if ($cookieUser !== '' && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
    <p style="color:#c00;text-align:center;">Username được lấy từ Cookies</p>
<?php endif; ?>
<p><b>Chú ý:</b> dùng Session để xử lý đăng nhập; Cookies lưu thông tin người dùng đã đăng nhập thành công, thường dùng để ghi nhớ username cho các lần sau.</p>
