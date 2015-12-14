<?php ob_start(); ?>
<div class="wrapper" id="cart">
    <ul>
        <?php foreach($products as $product): ?>

        <?php echo token(); ?>

        <?php endforeach; ?>
    </ul>

    <form method="post">
        <label>Email </label>
        <?php echo (!empty($_SESSION['error']['email']))?
            '<small class="error">'.$_SESSION['error']['email'].'</small>' : ''; ?>
        <input type="email" name="email" value="<?php echo (!empty($_SESSION['old']['email']))?
            '<small class="error">'.$_SESSION['old']['email'].'</small>' : '' ; ?>"/>

        <label>Card Number </label>
        <?php echo (!empty($_SESSION['error']['number']))?
            '<small class="error">'.$_SESSION['error']['number'].'</small>' : ''; ?>
        <input type="text" name="card" />

        <label>Address </label>
        <?php echo (!empty($_SESSION['error']['address']))?
            '<small class="error">'.$_SESSION['error']['address'].'</small>' : ''; ?>
        <textarea name="address"></textarea>

        <input type="submit" value="submit">
    </form>
</div>
<?php
$content = ob_get_clean();
include __DIR__.'/../layouts/master.php';