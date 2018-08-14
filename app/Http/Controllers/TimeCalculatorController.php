<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class TimeCalculatorController
 * @package App\Http\Controllers
 */
class TimeCalculatorController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'ok']);
    }
}
