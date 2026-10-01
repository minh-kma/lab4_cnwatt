<?php
$m1 = $_POST['m1'] ?? [];
$m2 = $_POST['m2'] ?? [];
$tong = $hieu = $tich = [];
$msg = '';
$hienKetQua = false;

function layGiaTri($m, $i, $j)
{
    return (is_array($m) && isset($m[$i][$j]) && is_scalar($m[$i][$j])) ? $m[$i][$j] : '';
}

function hienThiMaTran($ten, $maTran)
{
    echo "<div class='matrix-display'><b>$ten:</b><br>";
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            echo $maTran[$i][$j] . "&nbsp;&nbsp;&nbsp;";
        }
        echo "<br>";
    }
    echo "</div>";
}

if (isset($_POST['btnTinh'])) {
    $hienKetQua = true;
    for ($i = 0; $i < 3 && $hienKetQua; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if (!is_numeric(layGiaTri($m1, $i, $j)) || !is_numeric(layGiaTri($m2, $i, $j))) {
                $msg = "Vui lòng chỉ nhập số!";
                $hienKetQua = false;
                break;
            }
        }
    }
    if ($hienKetQua) {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $tong[$i][$j] = $m1[$i][$j] + $m2[$i][$j];
                $hieu[$i][$j] = $m1[$i][$j] - $m2[$i][$j];
                $tich[$i][$j] = 0;
                for ($k = 0; $k < 3; $k++) {
                    $tich[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
                }
            }
        }
    }
}
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>
<h3>Sử dụng mảng để tính: tổng, hiệu, tích 2 ma trận</h3>
<?php if ($msg): ?><p style="color:red"><?= $h($msg) ?></p><?php endif; ?>
<form method="POST" action="">
    <div class="matrix-container">
        <?php foreach (['m1' => ['Nhập ma trận 1', $m1], 'm2' => ['Nhập ma trận 2', $m2]] as $name => [$tieuDe, $data]): ?>
            <div class="matrix-input">
                <b><?= $tieuDe ?></b>
                <table>
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <tr>
                            <?php for ($j = 0; $j < 3; $j++): ?>
                                <td><input type="text" name="<?= $name ?>[<?= $i ?>][<?= $j ?>]" value="<?= $h(layGiaTri($data, $i, $j)) ?>" required></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:10px;">
        <input type="button" value="Nhập Lại" onclick="window.location.href='index.php?page=array1'">
        <input type="submit" name="btnTinh" value="Tính">
    </div>
</form>
<?php if ($hienKetQua): ?>
    <div class="result-box">
        <h3>KẾT QUẢ:</h3>
        <?php
        hienThiMaTran("Ma trận Tổng", $tong);
        echo "<br>";
        hienThiMaTran("Ma trận Hiệu", $hieu);
        echo "<br>";
        hienThiMaTran("Ma trận Tích", $tich);
        ?>
    </div>
<?php endif; ?>
