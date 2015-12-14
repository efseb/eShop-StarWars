<?php ob_start(); ?>
<nav id="wrapper" id="nav-bar">
    <h1>Star Wars</h1>
    <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Sabres</a></li>
        <li><a href="#">Casques</a></li>
        <li><a></a></li>
        <li><a></a></li>
    </ul>
</nav>
<div class="wrapper">
    <ul>
        <?php foreach($products as $product): ?>

            <li class="produit">
                <h2><a href="<?php echo url('product', $product->id); ?>"><?php echo $product->title; ?></a></h2>
                <?php if($image->productImage($product->id)): ?>
                    <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>" alt=""/>
                <?php endif; ?>
                <p><?php echo $product->abstract; ?><br><strong>Prix <?php echo $product->price?> Euros</strong></p>
                <p class="content"><?php echo $product->content; ?></p>

                <?php if($tags = $tag->productTags($product->id)):?>
                    <?php foreach($tags as $t): ?>
                        <p class="tag"><?php echo $t->name; ?><p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </li>

        <?php endforeach; ?>
    </ul>
</div>
<?php
    $content = ob_get_clean();
    include __DIR__.'/../layouts/master.php';
