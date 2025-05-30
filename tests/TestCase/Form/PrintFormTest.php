<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\PrintForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PrintForm Test Case
 */
class PrintFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\PrintForm
     */
    protected $Print;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Print = new PrintForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Print);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Form\PrintForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
