<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CircularlettersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CircularlettersTable Test Case
 */
class CircularlettersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CircularlettersTable
     */
    protected $Circularletters;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Circularletters',
        'app.Templates',
        'app.Subs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Circularletters') ? [] : ['className' => CircularlettersTable::class];
        $this->Circularletters = $this->getTableLocator()->get('Circularletters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Circularletters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CircularlettersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CircularlettersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
