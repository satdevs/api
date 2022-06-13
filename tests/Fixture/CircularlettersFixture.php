<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CircularlettersFixture
 */
class CircularlettersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'template_id' => 1,
                'sub_id' => 'Lorem ip',
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'tipus' => 'Lorem ipsum dolor ',
                'link' => 'Lorem ipsum dolor sit amet',
                'tmp' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor ',
                'sent' => '2022-05-09 11:17:08',
                'created' => '2022-05-09 11:17:08',
                'modified' => '2022-05-09 11:17:08',
            ],
        ];
        parent::init();
    }
}
