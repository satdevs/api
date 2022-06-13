<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property string|null $user_id
 * @property int $template_id
 * @property string $sub_id
 * @property string|null $invoiceNumber
 * @property string|null $name
 * @property string|null $email
 * @property string $filename
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $sent
 * @property string|null $hash
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\MyUser $user
 * @property \App\Model\Entity\Template $template
 * @property \App\Model\Entity\Sub $sub
 */
class Invoice extends Entity
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
        'user_id' => true,
        'template_id' => true,
        'sub_id' => true,
        'invoiceNumber' => true,
        'name' => true,
        'email' => true,
        'filename' => true,
        'date' => true,
        'status' => true,
        'sent' => true,
        'hash' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'template' => true,
        'sub' => true,
    ];
}
