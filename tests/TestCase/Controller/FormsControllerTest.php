<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FormsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\FormsController Test Case
 *
 * @uses \App\Controller\FormsController
 */
class FormsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Forms',
    ];
}
