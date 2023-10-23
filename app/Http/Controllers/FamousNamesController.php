<?php

namespace App\Http\Controllers;

use App\Services\FamousNameService;
use Illuminate\Http\Request;

class FamousNamesController extends Controller
{
    protected $nameService;

    public function __construct(FamousNameService $nameService)
    {
        $this->nameService = $nameService;
    }

    public function index()
    {
        $names = $this->nameService->getNames();
        return view('famous-names/index', compact('names'));
    }
}
