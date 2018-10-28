<?php

namespace MyDesigner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use MyDesigner\Http\Controllers\Controller;

use MyDesigner\Models\Team;
use MyDesigner\Models\User;
use MyDesigner\Models\Packages;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'team_name' => 'required|string|max:255|unique:teams'
        ]);

        $teams = Team::create($request->all());

        return redirect()->route('admin.teams.index')->with('success', 'Team added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
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
        $team = Team::findOrFail($id);
        
        if($team->team_name != $request->team_name) {
            $validator = $request->validate([
                'team_name' => 'required|string|max:255|unique:teams'
            ]);

            $team->team_name = $request->team_name;
        }

        $team->save();

        return redirect()->route('admin.teams.edit', $team->id)->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('admin.teams.index')->with(['message' => 'Team deleted successfully']);
    }
}
