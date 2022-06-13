<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 */
class CategoriesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'note_count' => 1,
                'visible' => 1,
                'pos' => 1,
                'created' => '2022-04-28 11:40:31',
                'modified' => '2022-04-28 11:40:31',
            ],
        ];
        parent::init();
    }
}
