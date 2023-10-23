<?php

namespace App\Http\Controllers;

use App\Services\FamousNamesService;
use Illuminate\Http\Request;

/**
 * The FamousNamesController class handles HTTP requests related to famous names.
 */
class FamousNamesController extends Controller
{
    /**
     * The FamousNamesService instance.
     *
     * @var FamousNamesService
     */
    protected $nameService;

    /**
     * Create a new controller instance.
     *
     * @param  FamousNamesService  $nameService
     * @return void
     */
    public function __construct(FamousNamesService $nameService)
    {
        $this->nameService = $nameService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $names = $this->nameService->getNames();
        return view('famous-names/index', compact('names'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $names = $this->nameService->getNames();
        $name = collect($names)->firstWhere('id', $id);
        return view('famous-names.edit', compact('name', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'location.lat' => 'required|numeric',
            'location.lng' => 'required|numeric',
        ]);

        $this->nameService->updateName($id, $validatedData);
        return redirect()->route('famous-names.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->nameService->deleteName($id);
        return redirect()->route('famous-names.index');
    }
}
