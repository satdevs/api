<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Template Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $title
 * @property string|null $body
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Circularletter[] $circularletters
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\InvoicesOld[] $invoices_old
 */
class Template extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'title' => true,
        'body' => true,
        'created' => true,
        'modified' => true,
        'circularletters' => true,
        'invoices' => true,
        'invoices_old' => true,
    ];
}
