<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoicesFixture
 */
class InvoicesFixture extends TestFixture
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
                'user_id' => 'Lorem ipsum dolor sit amet',
                'template_id' => 1,
                'sub_id' => 'Lorem ipsum dolor ',
                'invoiceNumber' => 'Lorem ipsum dolor ',
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'filename' => 'Lorem ipsum dolor sit amet',
                'date' => '2022-05-06',
                'status' => 'Lorem ipsum dolor sit amet',
                'sent' => '2022-05-06 08:00:49',
                'hash' => 'Lorem ipsum dolor sit amet',
                'created' => '2022-05-06 08:00:49',
                'modified' => '2022-05-06 08:00:49',
            ],
        ];
        parent::init();
    }
}
