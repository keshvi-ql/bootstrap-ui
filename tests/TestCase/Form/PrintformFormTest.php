<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\PrintformForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PrintformForm Test Case
 */
class PrintformFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\PrintformForm
     */
    protected $Printform;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Printform = new PrintformForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Printform);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Form\PrintformForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
