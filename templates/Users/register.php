<h1>Register</h1>

<?= $this->Form->create($user, [
    'type' => 'file' // imprescindible para subir archivos
]) ?>

<?= $this->Form->control('username', [
    'required' => true,
        'autocomplete' => 'username'

]) ?>

<?= $this->Form->control('email', [
    'required' => true
]) ?>

<?= $this->Form->control('password', [
    'type' => 'password',
    'required' => true,
    'autocomplete' => 'new-password'

]) ?>

<?= $this->Form->control('password_confirm', [
    'type' => 'password',
    'required' => true,
    'label' => 'Repeat password',
    'autocomplete' => 'new-password'

]) ?>

<?= $this->Form->control('avatar', [
    'type' => 'file',
    'label' => 'Profile image',
    'accept' => 'image/*'
]) ?>

<?= $this->Form->button(__('Register')) ?>
<?= $this->Form->end() ?>