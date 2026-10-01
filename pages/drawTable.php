<?php
const MAX_SIZE = 50;
$rows = (int)($_POST['sodong'] ?? 0);
$cols = (int)($_POST['socot'] ?? 0);
?>
<p><b>Form vẽ bảng:</b></p>
<form method="POST" action="">
    <table>
        <tr>
            <td>Số dòng:</td>
            <td><input type="number" name="sodong" value="<?= $rows ?: '' ?>" required></td>
        </tr>
        <tr>
            <td>Số cột:</td>
            <td><input type="number" name="socot" value="<?= $cols ?: '' ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="button" onclick="window.location.href='index.php?page=drawTable'">Nhập Lại</button>
                <button type="submit" name="btnVe">Vẽ</button>
            </td>
        </tr>
    </table>
    <p><i>(Khi click nút Vẽ thì mới vẽ bảng và hiển thị bên dưới)</i></p>
</form>
<hr>
<?php
if (isset($_POST['btnVe'])) {
    if ($rows > 0 && $cols > 0 && $rows <= MAX_SIZE && $cols <= MAX_SIZE) {
        echo "<h4>Kết quả:</h4>";
        echo "<table class='result-table' border='1'>";
        for ($i = 1; $i <= $rows; $i++) {
            echo "<tr>";
            for ($j = 1; $j <= $cols; $j++) {
                echo "<td>$j</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red;'>Vui lòng nhập số dòng và số cột từ 1 đến " . MAX_SIZE . "!</p>";
    }
}
