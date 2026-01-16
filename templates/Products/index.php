<h1 class="shop-title">My Products</h1>
<!-- añadir enlace a add -->
<div class="shop-add-link">
    <?= $this->Html->link(
        'Add New Product',
        ['action' => 'add'],
        ['class' => 'btn-add']
    ) ?>    
<div class="shop-grid">
    <?php foreach ($products as $product): ?>
        <div class="shop-card">

            <div class="shop-image">
                <?= $this->Html->image(
                    $product->image
                    ? 'products/' . h($product->image)
                    : 'products/default.png',
                    ['alt' => h($product->title)]
                ) ?>
            </div>

            <div class="shop-body">
                <h2 class="shop-product-title">
                    <?= h($product->title) ?>
                </h2>

                <p class="shop-price">
                    <?= number_format($product->price, 2) ?> €
                </p>

                <p class="shop-description">
                    <?= h($this->Text->truncate($product->description, 80)) ?>
                </p>
            </div>

            <div class="shop-actions">
                <?= $this->Html->link(
                    'Edit product',
                    ['action' => 'edit', $product->id],
                    ['class' => 'btn-view']
                ) ?>
                <!--enlace para borrar-->
                <?= $this->Form->postLink(
                    'Delete product',
                    ['action' => 'delete', $product->id],
                    [
                        'confirm' => 'Are you sure you want to delete #' . $product->id . '?',
                        'class' => 'btn-delete'
                    ]
                ) ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>