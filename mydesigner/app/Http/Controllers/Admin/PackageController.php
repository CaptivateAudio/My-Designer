<?php

namespace MyDesigner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use MyDesigner\Http\Controllers\Controller;

use MyDesigner\Models\Package;
use MyDesigner\Models\Team;

class PackageController extends Controller
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
        $packages = Package::all();        

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return view('admin.packages.create', [ 'teams' => $teams ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$team = Team::findOrFail($request->team);
        $validator = $request->validate([
            'package_name' => 'required|string|max:255|unique:packages',
            'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'teams' => 'required'
        ]);

        $packages = Package::create($request->all());

        $packages->teams()->sync($request->get('teams'));
        
        return redirect()->route('admin.packages.create')->with('success', 'Package added successfully.');
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
        $package = Package::findOrFail($id);

        $teams = Team::all();
        $assigned_teams = $package->teams()->get()->pluck('id')->toArray();

        return view('admin.packages.edit', compact('package', 'teams', 'assigned_teams'));
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
        $package = Package::findOrFail($id);
        
        if(strtolower($package->package_name) != strtolower($request->package_name)) {
            $validator = $request->validate([
                'package_name' => 'required|string|max:255|unique:packages'
            ]);
        }
        
        $package->package_name = $request->package_name;

        $validator = $request->validate([
            'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'teams' => 'required'
        ]);

        $package->save();

        $package->teams()->sync($request->get('teams'));

        return redirect()->route('admin.packages.edit', $package->id)->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        $package->teams()->detach();

        $package->delete();
        return redirect()->route('admin.packages.index')->with(['message' => 'Package deleted successfully']);
    }
}
