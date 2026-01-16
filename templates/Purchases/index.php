<!--Mostrar los productos comprados-->
<h1 class="purchases-title">My Purchases</h1>
<div class="purchases-list">
    <?php foreach ($purchases as $purchase): ?>
        <div class="purchase-card">
            <div class="purchase-image">
                <?= $this->Html->image(
                    $purchase->product->image
                    ? 'products/' . h($purchase->product->image)
                    : 'products/default.png',
                    ['alt' => h($purchase->product->title)]
                ) ?>    
            </div>
            <div class="purchase-body">
                <h2 class="purchase-product-title">
                    <?= h($purchase->product->title) ?>
                </h2>
<!--mostrar vendedor-->
                <p class="purchase-seller">
                    Sold by: <?= h($purchase->product->user->username) ?>   
                </p>
                
                <p class="purchase-price">
                    <?= number_format($purchase->product->price, 2) ?> €
                </p>
                <p class="purchase-date">
                    Purchased on: <?= h($purchase->created->format('Y-m-d H:i')) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>    
</div>
