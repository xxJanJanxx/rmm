<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SalesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SalesController Test Case
 */
class SalesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sales',
        'app.users',
        'app.branches',
        'app.branch_products',
        'app.products',
        'app.cart',
        'app.orders',
        'app.sale_items',
        'app.inventory_summary',
        'app.audit'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
