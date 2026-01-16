<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; 
use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = [
        'username' => true,
        'email' => true,
        'password' => true,
        'avatar' => true,
        'created' => true,
        'modified' => true,
    ];

    protected array $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password)) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
