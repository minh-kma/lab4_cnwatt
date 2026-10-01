<?php
$nLop  = count(lopAll());
$nHoso = hosoCount();
?>
<h3>Nhiệm vụ 11 - Kết nối và truy vấn CSDL cơ bản</h3>
<p>Database: <b>quanlyhocsinh</b> (MySQL/MariaDB trong XAMPP).</p>
<ul>
    <li>Số lớp (LOP): <b><?= $nLop ?></b></li>
    <li>Số hồ sơ (HOSO): <b><?= $nHoso ?></b></li>
</ul>
<p>Tab <b>LOP</b>: xem / thêm / sửa / xóa lớp.</p>
<p>Tab <b>HOSO</b>: xem (phân trang 10 bản ghi/trang) / thêm / sửa / xóa hồ sơ học sinh.</p>