<?php ob_start(); ?>
<div class="wrapper">
    <ul>
        <li class="produit">
            <h2><a href="<?php echo url('product', $product->id); ?>"><?php echo $product->title; ?></a></h2>
            <?php if($image->productImage($product->id)): ?>
                <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>" alt=""/>
            <?php endif; ?>
            <p><?php echo $product->abstract; ?><br><strong>Prix <?php echo $product->price?> Euros</strong></p>
            <p class="content"><?php echo $product->content; ?></p>
        </li>

        <form action="<?php echo url('command'); ?>" method="post">
            <input type="hidden" name="name" value="<?php echo $product->id; ?>"/>
            <input type="hidden" name="price" value="<?php echo $product->price; ?>"/>
            <select name="quantity" id="quantity">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <input class="button-primary" type="submit" value="Submit">
        </form>

    </ul>
</div>
<?php
    $content = ob_get_clean();
    include __DIR__.'/../layouts/master.php';
