<h1>Login</h1>

<?= $this->Form->create(null, [
    'url' => [
        'controller' => 'Users',
        'action' => 'login',
    ]
]) ?>

<?= $this->Form->control('email', [
    'label' => 'Email',
    'required' => true,
    'autocomplete' => 'username'
]) ?>

<?= $this->Form->control('password', [
    'type' => 'password',
    'required' => true,
    'autocomplete' => 'current-password'
]) ?>

<?= $this->Form->button(__('Login')) ?>

<?= $this->Form->end() ?>
