<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'shop']) ?>
    <!--añadir bootstrap-->
    <?= $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', [
        'integrity' => 'sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn
9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z',
        'crossorigin' => 'anonymous'
    ]) ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Formacom</span>SHOP</a>
        </div>
        <div class="top-nav-links">
            <!-- Si estoy logeado email y enlace a logout, sino nada -->
            <?php if ($identity = $this->request->getAttribute('identity')): ?>
                <span><?= $this->request->getAttribute('identity')->username ?></span>
                <?= $this->Html->link(
                    'Logout',
                    ['controller' => 'Users', 'action' => 'logout'],
                    ['class' => 'button button-outline']
                ) ?>
            <?php else: ?>
                <?= $this->Html->link(
                    'Login',
                    ['controller' => 'Users', 'action' => 'login'],
                    [
                        'class' => 'button
    button-outline'
                    ]

                ) ?>
            <?php endif; ?>

        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>