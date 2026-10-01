<form name="form1" action="getform.php?page=registerProcess" method="post">
    <table class="form-table" width="90%" align="center">
        <tr><td colspan="2" align="center"><b>Form Đăng ký</b></td></tr>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="txtUsername" id="txtUsername" size="40" maxlength="50"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="txtPassword" id="txtPassword" size="40" autocomplete="new-password"></td>
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
                <select name="lstAddress" id="lstAddress" size="4">
                    <option value="Ha Noi">Ha Noi</option>
                    <option value="TP. HCM">TP. HCM</option>
                    <option value="Hue">Hue</option>
                    <option value="Da Nang">Da Nang</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Enable Programming Language:</td>
            <td>
                <label><input type="checkbox" name="chkLang[]" value="PHP"> PHP,</label>
                <label><input type="checkbox" name="chkLang[]" value="C#"> C#,</label>
                <label><input type="checkbox" name="chkLang[]" value="Java"> Java,</label>
                <label><input type="checkbox" name="chkLang[]" value="C++"> C++</label>
            </td>
        </tr>
        <tr>
            <td>Skill:</td>
            <td>
                <label><input type="radio" name="radSkill" value="Normal"> Normal</label><br>
                <label><input type="radio" name="radSkill" value="Good"> Good</label><br>
                <label><input type="radio" name="radSkill" value="Very Good"> Very Good</label><br>
                <label><input type="radio" name="radSkill" value="Excellent"> Excellent</label>
            </td>
        </tr>
        <tr>
            <td>Note:</td>
            <td><textarea name="taNote" id="taNote" cols="40" rows="3" maxlength="500"></textarea></td>
        </tr>
        <tr>
            <td>Marriage Status:</td>
            <td><label><input type="checkbox" name="chkMariageStatus" value="Da ket hon"></label></td>
        </tr>
        <tr>
            <td align="right"><input type="reset" value="Reset"></td>
            <td><input type="submit" name="btnRegister" value="Register"></td>
        </tr>
    </table>
</form>
