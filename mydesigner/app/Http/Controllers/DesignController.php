<?php

namespace MyDesigner\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use MyDesigner\Models\Team;
use MyDesigner\Models\User;
use MyDesigner\Models\Role;
use MyDesigner\Models\Package;
use MyDesigner\Models\Design;

class DesignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|designer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function packages()
    {
        $team_id = Auth::user()->teams()->first()['id'];
        $team_name = Auth::user()->teams()->first()['team_name'];

        $packages = Package::whereHas('teams', function($q) use($team_id){
            $q->where('team_id', $team_id);
        })->get();

        if( Auth::user()->hasRole('user') ){
            return view('user.designs.packages', compact( 'team_name', 'team_id', 'packages' ));
        }
        else if( Auth::user()->hasRole('designer') ){
            return view('designer.designs.packages', compact( 'team_name', 'team_id', 'packages' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function design_request($package_id)
    {
        if( Auth::user()->hasRole('user') ){

            $team_id = Auth::user()->teams()->first()['id'];
            $team_name = Auth::user()->teams()->first()['team_name'];

            $package = Package::findOrFail($package_id);

            return view('user.designs.new', compact( 'team_name', 'team_id', 'package' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Auth::user()->hasRole('user') ){
            $package = Package::findOrFail($request->package_id);

            /* Save Design Request */
            $newdesign = $request->all();
            $newdesign['status'] = 'pending';
            $newdesign['details'] = $request->details;
            $newdesign['completion_date'] = null;
            $design = Design::create($newdesign);
            
            /* Save the user id of the user who submitted the request */
            $design
               ->users()->attach(User::where('id', Auth::id())->first(), ['type' => 'user']);

            /* Save Package ID for the Design */
            $design->package()->associate($package);
            
            /* Set Account Manager ID for the Design Request */
            $account_manager = User::whereHas('roles', function($q){
                $q->where('role_name', 'manager');
            })->first();

            $design
               ->users()->attach($account_manager, ['type' => 'manager']);
            
            $design->save();

            return redirect()->route('user.designs.requests.view', $design->id)->with('success', 'Design request successfully submitted.');
        }
        else{
            return redirect('/dashboard');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list_design_request()
    {
        $current_user_id = Auth::user()->id;
        
        if( Auth::user()->hasRole('user') ){
            $designs = Design::whereHas('users', function($q) use($current_user_id){
                $q->where('user_id', $current_user_id);
            })->get();

            return view('user.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else if( Auth::user()->hasRole('designer') ){
            $designs = Design::whereHas('users', function($q) use($current_user_id){
                $q->where('user_id', $current_user_id);
            })->get();

            return view('designer.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function view_design_request($id)
    {
        $current_user_id = Auth::user()->id;
        if( Auth::user()->hasRole('user') ){
            
            $design = Design::where('id', $id)->first();

            return view('user.designs.view', compact( 'design' ));
        }
        else if( Auth::user()->hasRole('designer') ){

            $design = Design::where('id', $id)->first();

            return view('designer.designs.view', compact( 'design' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function team_design_request($package_id)
    {
        $current_user_id = Auth::user()->id;
        
        if( Auth::user()->hasRole('designer') ){

            $team_id = Auth::user()->teams()->first()['id'];

            $packages_team_check = Team::whereHas('packages', function($q) use($package_id, $team_id){
                $q->where(['package_id' => $package_id, 'team_id' => $team_id]);
            })->count();

            if( $packages_team_check >= 1 ){       
                $designs = Design::where(['package_id' => $package_id, 'status' => 'pending'])->get();

                return view('designer.designs.requests', compact( 'team_name', 'team_id', 'designs', 'packages_team_check' ));
            }
            else{
                return redirect()->route('user.packages.list');            
            }
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function assign_design_request(Request $request, $design_id)
    {
        $design = Design::findOrFail($design_id);

        $design->status = 'in-progress';

        /* Assign Designer to Design Request */
        $designer = Auth::user();

        $design
            ->users()->attach($designer, ['type' => 'designer']);

        $design->save();

        return redirect()->route('user.designs.requests.view', $design->id)->with('success', 'Design request is now in progress.');
    }
}