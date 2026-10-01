<?php
if (!isset($_POST['btnRegister'])) {
    echo '<p>Chưa có dữ liệu. <a href="getform.php?page=register">Quay lại form đăng ký</a></p>';
    return;
}

$genders   = ['Male', 'Female'];
$addresses = ['Ha Noi', 'TP. HCM', 'Hue', 'Da Nang'];
$langs     = ['PHP', 'C#', 'Java', 'C++'];
$skills    = ['Normal', 'Good', 'Very Good', 'Excellent'];

$chuoi = fn($k) => (isset($_POST[$k]) && is_string($_POST[$k])) ? $_POST[$k] : '';

$username = trim($chuoi('txtUsername'));
$password = $chuoi('txtPassword');
$gender   = $chuoi('radGender');
$address  = $chuoi('lstAddress');
$skill    = $chuoi('radSkill');
$note     = trim($chuoi('taNote'));
$married  = $chuoi('chkMariageStatus') !== '';

$chonLang = array_values(array_intersect(
    $langs,
    array_filter((array)($_POST['chkLang'] ?? []), 'is_string')
));

if ($username === '' || $password === '') {
    echo '<p style="color:red;">Vui lòng nhập Username và Password.</p>';
    echo '<p><a href="getform.php?page=register">Quay lại</a></p>';
    return;
}

$gender  = in_array($gender, $genders, true) ? $gender : '(chưa chọn)';
$address = in_array($address, $addresses, true) ? $address : '(chưa chọn)';
$skill   = in_array($skill, $skills, true) ? $skill : '(chưa chọn)';
?>
<h3 style="text-align:center;">Form Đăng ký</h3>
<table class="info-table" width="90%" align="center">
    <tr><td>Username:</td><td><?= h($username) ?></td></tr>
    <tr><td>Password:</td><td>******** (đã ẩn)</td></tr>
    <tr><td>Gender:</td><td><?= h($gender) ?></td></tr>
    <tr><td>Address:</td><td><?= h($address) ?></td></tr>
    <tr><td>Enable Programming Language:</td><td><?= $chonLang ? h(implode(', ', $chonLang)) : '(không chọn)' ?></td></tr>
    <tr><td>Skill:</td><td><?= h($skill) ?></td></tr>
    <tr><td>Note:</td><td><?= nl2br(h($note)) ?></td></tr>
    <tr><td>Marriage Status:</td><td><?= $married ? 'Đã kết hôn' : 'Chưa kết hôn' ?></td></tr>
</table>
