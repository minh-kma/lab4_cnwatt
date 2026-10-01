<?php
$addresses = ['Ha Noi', 'TP. HCM', 'Hue', 'Da Nang'];
$chuoi = fn($k) => (isset($_POST[$k]) && is_string($_POST[$k])) ? $_POST[$k] : '';

if (isset($_POST['btnContact'])):
    $username = trim($chuoi('txtUsername'));
    $gender   = $chuoi('radGender');
    $address  = $chuoi('lstAddress');
    $note     = trim($chuoi('taNote'));

    $gender  = $gender === 'Male' ? 'Nam' : ($gender === 'Female' ? 'Nữ' : '(chưa chọn)');
    $address = in_array($address, $addresses, true) ? $address : '(chưa chọn)';
?>
    <div class="box">
        <h3 style="text-align:center;">Thông tin liên hệ</h3>
        <table class="info-table" width="90%" align="center">
            <tr><td>Username:</td><td><?= h($username) ?></td></tr>
            <tr><td>Gender:</td><td><?= h($gender) ?></td></tr>
            <tr><td>Address:</td><td><?= h($address) ?></td></tr>
            <tr><td>Note:</td><td><?= nl2br(h($note)) ?></td></tr>
        </table>
        <p style="text-align:center;"><a href="getform.php?page=contact1Page">Nhập lại</a></p>
    </div>
<?php else: ?>
    <form action="getform.php?page=contact1Page" method="post">
        <table class="form-table" width="90%" align="center">
            <tr><td colspan="2" align="center"><b>Form Liên hệ</b></td></tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="txtUsername" size="40" maxlength="50"></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    <label><input type="radio" name="radGender" value="Male"> Male</label><br>
                    <label><input type="radio" name="radGender" value="Female"> Female</label>
                </td>
            </tr>
            <tr>
                <td>Address:</td>
                <td>
                    <select name="lstAddress" size="4">
                        <?php foreach ($addresses as $a): ?>
                            <option value="<?= h($a) ?>"><?= h($a) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Note:</td>
                <td><textarea name="taNote" cols="40" rows="3" maxlength="500"></textarea></td>
            </tr>
            <tr>
                <td align="right"><input type="reset" value="Reset"></td>
                <td><input type="submit" name="btnContact" value="Contact"></td>
            </tr>
        </table>
    </form>
<?php endif; ?>
