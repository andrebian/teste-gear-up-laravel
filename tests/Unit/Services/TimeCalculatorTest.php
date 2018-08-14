<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 14/08/18
 * Time: 13:22
 */

namespace Tests\Unit\Services;

use App\Models\TimeResult;
use App\Services\TimeCalculatorService;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeCalculatorTest
 * @package Tests\Unit\Services
 */
class TimeCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('00:00', '11:00', 10);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertCount(6, $result->getContent());
        $this->assertArrayHasKey('time_result', $result->getContent());
        $this->assertArrayHasKey('occurrences_per_hour', $result->getContent());
        $this->assertArrayHasKey('hour_with_more_occurrences', $result->getContent());
        $this->assertArrayHasKey('average_results_per_hour', $result->getContent());
        $this->assertArrayHasKey('smallest_interval', $result->getContent());
        $this->assertArrayHasKey('greatest_interval', $result->getContent());
    }

    public function testCalculateInvalidMinTime()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('test', '11:00', 10);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(400, $result->getCode());
    }

    public function testCalculateInvalidMaxTime()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('00:00', 'test', 10);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(400, $result->getCode());
    }

    public function testCalculateMaxTimeSmallerThanMinTime()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('08:00', '05:00', 10);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(400, $result->getCode());
    }

    public function testCalculateInvalidQuantityForTimeRange()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('08:00', '09:15', 95);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(400, $result->getCode());
    }

    public function testCalculateInvalidQuantityIncompatibleWithTheMinimum()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('08:00', '09:15', 2);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(400, $result->getCode());
    }

    public function testCalculateWithMiniumAvailable()
    {
        $timeCalculatorService = new TimeCalculatorService();
        $result = $timeCalculatorService->calculate('08:00', '08:04', 4);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TimeResult::class, $result);
        $this->assertEquals(200, $result->getCode());
    }
}
