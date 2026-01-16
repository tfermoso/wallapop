<!-- templates/Products/add.php -->
<h1>Add Product</h1>

<div class="products form content">
    <?= $this->Form->create($product, [
        'type' => 'file'
    ]) ?>

    <fieldset>
        <legend><?= __('Add Product') ?></legend>

        <?= $this->Form->control('title') ?>
        <?= $this->Form->control('description') ?>
        <?= $this->Form->control('price') ?>

        <?= $this->Form->control('image', [
            'type' => 'file',
            'label' => 'Product image',
            'accept' => 'image/*'
        ]) ?>

      
    </fieldset>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
