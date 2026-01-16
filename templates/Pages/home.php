<!--mostrar los productos, pero solo los pueden comprar los usuarios logeados -->
<!--los usuario logeados no ves sus productos -->
<h1 class="shop-title">Products</h1>
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

                <p class="shop-price
">
                    <?= number_format($product->price, 2) ?> €
                </p>
                <p class="shop-description">
                    <?= h($this->Text->truncate($product->description, 80)) ?>
                </p>
            </div>
            <!--añadir boton comprar solo si el usuario esta logeado-->
            <!-- mostrar boton deshabilitado si no esta logeado, con info de logear para comparr -->

            <?php if ($this->request->getAttribute('identity')): ?>
                <div class="shop-actions">
                    <?= $this->Form->postLink(
                        'Buy Now',
                        ['controller' => 'Purchases', 'action' => 'add', $product->id],
                        ['class' => 'btn-buy']
                    ) ?>
                </div>

            <?php else: ?>
                <div class="shop-actions">
                    <button class="btn-buy disabled" disabled>Log in to buy</button>
                </div>  
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
