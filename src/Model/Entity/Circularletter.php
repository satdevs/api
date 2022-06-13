<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Circularletter Entity
 *
 * @property int $id
 * @property int|null $template_id
 * @property string|null $sub_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $tipus
 * @property string|null $link
 * @property string|null $tmp
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $sent
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Template $template
 * @property \App\Model\Entity\Sub $sub
 */
class Circularletter extends Entity
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
        'template_id' => true,
        'sub_id' => true,
        'name' => true,
        'email' => true,
        'tipus' => true,
        'link' => true,
        'tmp' => true,
        'status' => true,
        'sent' => true,
        'created' => true,
        'modified' => true,
        'template' => true,
        'sub' => true,
    ];
}
