<?php include 'Head.php'; include 'Menu.php'; ?>
<main class="main-content">
    <?php include 'TabMenu.php'; ?>
    <h3 style="text-align:center;">Form Đăng Ký</h3>
    <form action="ResultRegister.php" method="POST">
        <table align="center">
            <tr><td>Tên:</td><td><input type="text" name="ten" size="30"></td></tr>
            <tr><td>Địa chỉ:</td><td><input type="text" name="dia_chi" size="30"></td></tr>
            <tr><td>Nghề:</td><td><input type="text" name="nghe" size="30"></td></tr>
            <tr><td>Ghi chú:</td><td><textarea name="ghi_chu" rows="3" cols="32"></textarea></td></tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="reset" value="Xóa">
                    <input type="submit" value="Đăng Ký">
                </td>
            </tr>
        </table>
    </form>
</main>
<?php include 'Footer.php'; ?>
