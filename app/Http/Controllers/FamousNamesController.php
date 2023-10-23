<?php

namespace App\Http\Controllers;

use App\Services\FamousNamesService;
use Illuminate\Http\Request;

class FamousNamesController extends Controller
{
    protected $nameService;

    public function __construct(FamousNamesService $nameService)
    {
        $this->nameService = $nameService;
    }

    public function index()
    {
        $names = $this->nameService->getNames();
        return view('famous-names/index', compact('names'));
    }

    public function delete($id)
    {
        $this->nameService->deleteName($id);
        return redirect()->route('famous-names.index');
    }
}
