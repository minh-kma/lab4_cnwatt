<h3>Trang Home - Function</h3>
<p>Các hàm được định nghĩa trong thư mục <code>libs/</code> và gọi từ các trang trong <code>pages/function/</code> bằng <code>require_once</code>.</p>
<ul>
    <li><b>libs/xuLyMangSo.php</b>: minDay, maxDay, tongDay, avgDay, sortDay, daoNguocDay.</li>
    <li><b>libs/xuLyMatran.php</b>: maxMatran, minMatran, tongTrenCheoChinh, tongTrenCheoPhu, tinhMatranTong, tinhMatranHieu, tinhMatranTich.</li>
</ul>
<h4>Ví dụ gọi hàm</h4>
<?php
$mang = [10, 2, 8, 6, 4, 1, 9];
echo '<p>Mảng: ' . h(implode(', ', $mang)) . '</p>';
echo '<p>Tổng: ' . tongDay($mang) . ' | Min: ' . minDay($mang) . ' | Max: ' . maxDay($mang) . '</p>';
echo '<p>Tăng dần: ' . h(implode(', ', sortDay($mang))) . '</p>';
echo '<p>Đảo ngược: ' . h(implode(', ', daoNguocDay($mang))) . '</p>';
