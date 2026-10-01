<h3 style="text-align:center;">Đăng nhập</h3>
<?php if ($loginError !== ''): ?>
    <p class="error" style="text-align:center;"><?= h($loginError) ?></p>
<?php endif; ?>
<form action="session.php?page=login" method="post">
    <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
    <table class="form-table" align="center">
        <tr>
            <td>Username:</td>
            <td><input type="text" name="txtUsername" value="<?= h($lastUser) ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="txtPassword" autocomplete="current-password" required></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="reset" value="Nhập Lại">
                <input type="submit" name="btnLogin" value="Đăng Nhập">
            </td>
        </tr>
    </table>
</form>


