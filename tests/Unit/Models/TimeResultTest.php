<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 14/08/18
 * Time: 13:14
 */

namespace Tests\Unit\Models;

use App\Models\TimeResult;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeResultTest
 * @package Tests\Unit\Models
 */
class TimeResultTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $model = new TimeResult([
            'code' => 200,
            'status' => 'success',
            'message' => 'Calculated 4 times between 03:00 and 23:00',
            'content' => [
                'time_result' => [
                    ['03:00'],
                    ['03:25'],
                    ['07:12'],
                    ['23:00']
                ],
                'occurrences_per_hour' => [
                    '03' => 2,
                    '07' => 1,
                    '23' => 1
                ],
                'hour_with_more_occurrences' => '03',
                'average_results_per_hour' => 1.33,
                'smallest_interval' => '00:25',
                'greatest_interval' => '15:48'
            ]
        ]);

        $this->assertNotNull($model->getCode());
        $this->assertNotNull($model->getStatus());
        $this->assertNotNull($model->getMessage());
        $this->assertNotNull($model->getContent());
        $this->assertNotNull($model->toArray());
        $this->assertInternalType('array', $model->toArray());
        $this->assertArrayHasKey('content', $model->toArray());
        $this->assertArrayHasKey('time_result', $model->toArray()['content']);
        $this->assertArrayHasKey('occurrences_per_hour', $model->toArray()['content']);
        $this->assertArrayHasKey('hour_with_more_occurrences', $model->toArray()['content']);
        $this->assertArrayHasKey('average_results_per_hour', $model->toArray()['content']);
        $this->assertArrayHasKey('smallest_interval', $model->toArray()['content']);
        $this->assertArrayHasKey('greatest_interval', $model->toArray()['content']);
    }
}
