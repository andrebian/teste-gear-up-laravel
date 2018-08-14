<?php

namespace App\Http\Controllers;

use App\Models\TimeResult;
use App\Services\TimeCalculatorService;
use Illuminate\Http\Request;

/**
 * Class TimeCalculatorController
 * @package App\Http\Controllers
 */
class TimeCalculatorController extends Controller
{
    /**
     * @var TimeCalculatorService
     */
    protected $timeCalculator;

    public function __construct($timeCalculator)
    {
        $this->timeCalculator = $timeCalculator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $startTime = $request->query('start_time') ?: date('H:i', strtotime('-2 hours'));
        $endTime = $request->query('end_time') ?: date('H:i');
        $quantity = (int)$request->query('quantity') ?: 50;

        /** @var TimeResult $result */
        $result = $this->timeCalculator->calculate($startTime, $endTime, $quantity);

        return response()->json($result->toArray());
    }
}
