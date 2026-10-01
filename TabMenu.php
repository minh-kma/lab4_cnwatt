<?php $current = basename($_SERVER['SCRIPT_NAME']); ?>
<nav class="tabs">
    <a href="Register.php" class="<?= $current === 'Register.php' ? 'active' : '' ?>">Register</a>
    <a href="ResultRegister.php" class="<?= $current === 'ResultRegister.php' ? 'active' : '' ?>">ResultRegister</a>
    <a href="Calculate.php" class="<?= $current === 'Calculate.php' ? 'active' : '' ?>">Calculate</a>
</nav>
