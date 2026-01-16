<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Purchase Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $buyer_id
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\User $buyer
 */
class Purchase extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'product_id' => true,
        'buyer_id' => true,
        'created' => true,
        'product' => true,
        'buyer' => true,
    ];
}
