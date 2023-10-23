<?php

namespace App\Http\Controllers;

use App\Contracts\NameServiceInterface;
use Illuminate\Http\Request;

class FamousNamesController extends Controller
{
    protected $nameService;

    public function __construct(NameServiceInterface $nameService)
    {
        $this->nameService = $nameService;
    }

    public function index()
    {
        $names = $this->nameService->getNames();
        return view('famous-names', compact('names'));
    }
}
