<?php
$a = 0;
$b = 0;
$operator = '';
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = (int)($_POST['a'] ?? 0);
    $b = (int)($_POST['b'] ?? 0);
    $operator = $_POST['operator'] ?? '';
    switch ($operator) {
        case '+':
            $result = "$a + $b = " . ($a + $b);
            break;
        case '-':
            $result = "$a - $b = " . ($a - $b);
            break;
        case '*':
            $result = "$a * $b = " . ($a * $b);
            break;
        case '/':
            $result = $b === 0 ? "Không thể chia cho 0" : "$a / $b = " . ($a / $b);
            break;
        default:
            $result = "Vui lòng chọn phép tính.";
    }
}
?>
<form method="post" action="">
    <table border="1" cellpadding="8">
        <tr>
            <td>Số a</td>
            <td><input type="number" name="a" value="<?= $_POST ? $a : '' ?>" required></td>
        </tr>
        <tr>
            <td>Số b</td>
            <td><input type="number" name="b" value="<?= $_POST ? $b : '' ?>" required></td>
        </tr>
        <tr>
            <td>Phép tính</td>
            <td>
                <?php foreach (['+', '-', '*', '/'] as $op): ?>
                    <label><input type="radio" name="operator" value="<?= $op ?>" <?= $operator === $op ? 'checked' : '' ?>> <?= $op ?></label>&nbsp;
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Caculate</button></td>
        </tr>
    </table>
</form>
<p><strong>Kết quả: </strong><?= htmlspecialchars($result) ?></p>
