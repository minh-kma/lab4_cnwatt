<?php
const N = 3;

$m1 = [[1, 1, 1], [2, 2, 2], [3, 3, 3]];
$m2 = [[0, 0, 0], [0, 0, 0], [0, 0, 0]];
$msg = '';
$coKetQua = false;

function docMaTran($raw): ?array
{
    if (!is_array($raw) || count($raw) !== N) {
        return null;
    }
    $kq = [];
    for ($i = 0; $i < N; $i++) {
        if (!isset($raw[$i]) || !is_array($raw[$i]) || count($raw[$i]) !== N) {
            return null;
        }
        for ($j = 0; $j < N; $j++) {
            $v = $raw[$i][$j] ?? null;
            if (!is_string($v) || trim($v) === '' || !is_numeric(trim($v))) {
                return null;
            }
            $kq[$i][$j] = trim($v) + 0;
        }
    }
    return $kq;
}

function inMaTran(string $ten, array $m): void
{
    echo '<p><b>' . h($ten) . ':</b></p><table class="ma-tran">';
    foreach ($m as $dong) {
        echo '<tr>';
        foreach ($dong as $v) {
            echo '<td>' . h($v) . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

if (isset($_POST['btnTinh'])) {
    $a = docMaTran($_POST['m1'] ?? null);
    $b = docMaTran($_POST['m2'] ?? null);
    if ($a === null || $b === null) {
        $msg = 'Vui lòng nhập đủ 9 số hợp lệ cho mỗi ma trận.';
        // giữ lại giá trị đã nhập (dạng chuỗi) để người dùng sửa
        foreach (['m1', 'm2'] as $ten) {
            $raw = $_POST[$ten] ?? [];
            for ($i = 0; $i < N; $i++) {
                for ($j = 0; $j < N; $j++) {
                    $v = (is_array($raw) && isset($raw[$i][$j]) && is_string($raw[$i][$j])) ? $raw[$i][$j] : '';
                    if ($ten === 'm1') { $m1[$i][$j] = $v; } else { $m2[$i][$j] = $v; }
                }
            }
        }
    } else {
        $m1 = $a;
        $m2 = $b;
        $coKetQua = true;
    }
}
?>
<p>Sử dụng mảng để tính: hiệu, tổng, tích 2 ma trận.</p>
<?php if ($msg !== ''): ?><p class="error"><?= h($msg) ?></p><?php endif; ?>
<form method="post" action="function.php?page=matrix">
    <div class="matrix-container">
        <?php foreach (['m1' => ['Nhập Ma trận 1', $m1], 'm2' => ['Nhập Ma trận 2', $m2]] as $name => [$tieuDe, $data]): ?>
            <div class="matrix-input">
                <b><?= $tieuDe ?></b>
                <table>
                    <?php for ($i = 0; $i < N; $i++): ?>
                        <tr>
                            <?php for ($j = 0; $j < N; $j++): ?>
                                <td><input type="text" name="<?= $name ?>[<?= $i ?>][<?= $j ?>]" value="<?= h($data[$i][$j]) ?>" required></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:8px;">
        <input type="button" value="Nhập Lại" onclick="window.location.href='function.php?page=matrix'">
        <input type="submit" name="btnTinh" value="Tính">
    </div>
</form>
<?php if ($coKetQua): ?>
    <div class="result-box">
        <p><b>KẾT QUẢ:</b></p>
        <?php
        inMaTran('Ma trận Tổng', tinhMatranTong($m1, $m2));
        inMaTran('Ma trận Hiệu', tinhMatranHieu($m1, $m2));
        inMaTran('Ma trận Tích', tinhMatranTich($m1, $m2));
        ?>
        <hr>
        <p>Ma trận 1: Max = <?= h(maxMatran($m1)) ?>, Min = <?= h(minMatran($m1)) ?>,
            tổng đường chéo chính = <?= h(tongTrenCheoChinh($m1)) ?>, tổng đường chéo phụ = <?= h(tongTrenCheoPhu($m1)) ?></p>
        <p>Ma trận 2: Max = <?= h(maxMatran($m2)) ?>, Min = <?= h(minMatran($m2)) ?>,
            tổng đường chéo chính = <?= h(tongTrenCheoChinh($m2)) ?>, tổng đường chéo phụ = <?= h(tongTrenCheoPhu($m2)) ?></p>
    </div>
<?php endif; ?>
