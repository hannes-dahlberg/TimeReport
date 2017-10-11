<?php namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Log;

class LogController extends Controller {
    public function store(Request $request) {
        Log::create($request->all());
    }
}
