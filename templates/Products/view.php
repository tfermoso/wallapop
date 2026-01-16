<!--Vista de un producto individual-->
<div class="shop-product-detail">
    <div class="shop-product-image">
        <?= $this->Html->image(
            $product->image
            ? 'products/' . h($product->image)
            : 'products/default.png',
            ['alt' => h($product->title)]
        ) ?>
    </div>

    <div class="shop-product-info">
        <h1 class="shop-product-title">
            <?= h($product->title) ?>
        </h1>

        <p class="shop-product-price">
            <?= number_format($product->price, 2) ?> €
        </p>

        <p class="shop-product-description">
            <?= h($product->description) ?>
        </p>

        <div class="shop-product-actions">
            <?= $this->Form->postLink(
                'Buy Now',
                ['controller' => 'Purchases', 'action' => 'add', $product->id],
                ['class' => 'btn-buy']
            ) ?>
        </div>
    </div>