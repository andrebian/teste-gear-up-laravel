<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 14/08/18
 * Time: 13:36
 */

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class TimeCalculatorTest
 * @package Tests\Feature
 */
class TimeCalculatorTest extends TestCase
{
    public function testApiEndpoint()
    {
        $response = $this->get('/api/time-calculator?start_time=03:00&end_time=23:00&quantity=40');

        $response->assertStatus(200);
        $response->assertSee('code');
        $response->assertSee('status');
        $response->assertSee('message');
        $response->assertSee('content');
        $response->assertJsonCount(4);
        $response->assertJsonCount(6, 'content');
    }
}
