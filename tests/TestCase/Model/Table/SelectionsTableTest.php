<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SelectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SelectionsTable Test Case
 */
class SelectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SelectionsTable
     */
    public $Selections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
//        'app.selections',
//        'app.casts',
//        'app.guests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Selections') ? [] : ['className' => SelectionsTable::class];
        $this->Selections = TableRegistry::get('Selections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Selections);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
