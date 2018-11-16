<?php

namespace MyDesigner\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use MyDesigner\Notifications\NewDesignRequest;
use MyDesigner\Notifications\PickupDesignRequest;
use MyDesigner\Notifications\ApprovedDesignRequest;

use MyDesigner\Models\Team;
use MyDesigner\Models\User;
use MyDesigner\Models\Role;
use MyDesigner\Models\Package;
use MyDesigner\Models\Design;
use MyDesigner\Models\Feedback;

class DesignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|designer|manager');
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
        $current_user_data = Auth::user();

        $team_id = $current_user_data->teams()->first()['id'];
        $team_name = $current_user_data->teams()->first()['team_name'];

        $packages = Package::whereHas('teams', function($q) use($team_id){
            $q->where('team_id', $team_id);
        })->get();

        if( $current_user_data->hasRole('user') ){
            return view('user.designs.packages', compact( 'team_name', 'team_id', 'packages' ));
        }
        else if( $current_user_data->hasRole('designer') ){
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
        $package = Package::findOrFail($package_id);

        $current_user_data = Auth::user();

        if( $current_user_data->hasRole('user') ){

            $team_id = $current_user_data->teams()->first()['id'];
            $team_name = $current_user_data->teams()->first()['team_name'];

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
        $current_user_data = Auth::user();

        if( $current_user_data->hasRole('user') ){
            $package = Package::findOrFail($request->package_id);

            /* Save Design Request */
            $newdesign = $request->all();
            $newdesign['status'] = 'request';
            $newdesign['details'] = $request->details;
            $newdesign['completion_date'] = null;
            $newdesign['package_name'] = $package->package_name;
            $newdesign['amount'] = $package->amount;
            $design = Design::create($newdesign);
            
            /* Save the user id of the user who submitted the request */
            $design
               ->users()->attach(User::where('id', $current_user_data->id)->first(), ['type' => 'user']);

            /* Save Package ID for the Design */
            $design->package()->associate($package);
            
            /* Set Account Manager ID for the Design Request */
            $account_manager = User::whereHas('roles', function($q){
                $q->where('role_name', 'manager');
            })->first();

            $design
               ->users()->attach($account_manager, ['type' => 'manager']);
            
            $design->save();

            /* Admin User */
            $admin_user = User::findOrFail(1);

            /* Array of data to use to notification message */
            $emailContent = array(
                'heading' => 'A new design request has been sent.',
                'user_name' => $current_user_data->first_name.' '.$current_user_data->last_name,
                'package_name' => $package->package_name,
                'button_text' => 'View full details',
                'button_url' => route('user.designs.requests.view', $design->id),
            );

            Notification::send($admin_user, new NewDesignRequest($emailContent));
            Notification::send($account_manager, new NewDesignRequest($emailContent));

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

    public function admin_list_design_request()
    {
        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;
        
        if( $current_user_data->hasRole('admin') ){
            $designs = Design::get();

            return view('admin.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function list_design_request()
    {
        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;
        
        if( $current_user_data->hasRole('user') ){
            $designs = Design::whereHas('users', function($q) use($current_user_id){
                $q->where(['user_id' => $current_user_id, 'type' => 'user']);
            })->get();

            return view('user.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else if( $current_user_data->hasRole('designer') ){
            $designs = Design::whereHas('users', function($q) use($current_user_id){
                $q->where(['user_id' => $current_user_id, 'type' => 'designer']);
            })->get();

            return view('designer.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else if( $current_user_data->hasRole('manager') ){
            $designs = Design::whereHas('users', function($q) use($current_user_id){
                $q->where(['user_id' => $current_user_id, 'type' => 'manager']);
            })->get();

            return view('manager.designs.requests', compact( 'current_user_id', 'designs' ));
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function admin_view_design_request($id)
    {
        $design = Design::findOrFail($id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;


        if( $current_user_data->hasRole('admin') ){
            $feedback_lists = Feedback::where(['design_id' => $id, 'status' => 'approved'])->latest()->get();

            return view('admin.designs.view', compact( 'design', 'current_user_id', 'feedback_lists' ));

        }
        else{
            return redirect('/dashboard');
        }
    }

    public function view_design_request($id)
    {
        $design = Design::findOrFail($id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;


        if( $current_user_data->hasRole('user') ){
            $feedback_lists = Feedback::where(['design_id' => $id, 'status' => 'approved'])->latest()->get();

            $user = $design->users()->wherePivot('type', 'user');
            if( $user->count() >= 1 ):
                if( $user->first()->id == $current_user_id ):
                    return view('user.designs.view', compact( 'design', 'current_user_id', 'feedback_lists' ));
                endif;
            endif;
            
            return redirect('/dashboard');
        }
        else if( $current_user_data->hasRole('designer') ){
            $feedback_lists = Feedback::where(['design_id' => $id])->latest()->get();

            $designer = $design->users()->wherePivot('type', 'designer');
            if( $designer->count() >= 1 ):
                if( $designer->first()->id == $current_user_id ):
                    return view('designer.designs.view', compact( 'design', 'current_user_id', 'feedback_lists' ));
                endif;
            endif;
            
            return redirect('/dashboard');
        }
        else if( $current_user_data->hasRole('manager') ){
            $feedback_lists = Feedback::where(['design_id' => $id])->latest()->get();

            $manager = $design->users()->wherePivot('type', 'manager');
            if( $manager->count() >= 1 ):
                if( $manager->first()->id == $current_user_id ):
                    return view('manager.designs.view', compact( 'design', 'current_user_id', 'feedback_lists' ));
                endif;
            endif;
            
            return redirect('/dashboard');
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function team_design_request($package_id)
    {
        $current_user_data = Auth::user();
        
        if( $current_user_data->hasRole('designer') ){

            $team_id = $current_user_data->teams()->first()['id'];

            $packages_team_check = Team::whereHas('packages', function($q) use($package_id, $team_id){
                $q->where(['package_id' => $package_id, 'team_id' => $team_id]);
            })->count();

            if( $packages_team_check >= 1 ){       
                $designs = Design::where(['package_id' => $package_id, 'status' => 'request'])->get();

                return view('designer.designs.pickup', compact( 'team_name', 'team_id', 'designs', 'packages_team_check' ));
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

        $in_progress_count = Auth::user()->designs()->where('status', 'in-progress')->count();

        if( $in_progress_count >= 3 ){
            return redirect()->back()->withErrors('You already have '.$in_progress_count.' in-progress design requests. Please complete it to pick more designs.');
        }

        $validator = $request->validate([
            'completion_date' => 'required|date|date_format:Y-m-d'
        ]);

        $design->status = 'in-progress';
        $design->completion_date = $request->completion_date;

        /* Assign Self to Design Request */
        $designer = Auth::user();

        $design
            ->users()->attach($designer, ['type' => 'designer']);

        $design->save();

        /* Array of data to use to notification message */
        $emailContent = array(
            'heading' => $design->package_name.' design request has been picked up and now in-progress.',
            'designer' => $designer->first_name.' '.$designer->last_name,
            'completion_date' => $design->completion_date,
            'button_text' => 'View design request',
            'button_url' => route('user.designs.requests.view', $design->id),
        );

        /* Get User */
        $user = $design->users()->wherePivot('type', 'user');
        if( $user->count() >= 1 ):
            Notification::send($user->first(), new PickupDesignRequest($emailContent));
        endif;

        /* Get Manager */
        $manager = $design->users()->wherePivot('type', 'manager');
        if( $manager->count() >= 1 ):
            Notification::send($manager->first(), new PickupDesignRequest($emailContent));
        endif;

        return redirect()->route('user.designs.requests.view', $design->id)->with('success', 'Design request is now in progress.');
    }

    public function approve_design_request($design_id)
    {
        $design = Design::findOrFail($design_id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;

        if( $current_user_data->hasRole('user') ){
            $user = $design->users()->wherePivot('type', 'user');
            if( $user->count() >= 1 ):
                if( $user->first()->id == $current_user_id ):
                    $design->status = 'approved';

                    $design->save();

                    /* Array of data to use to notification message */
                    $emailContent = array(
                        'heading' => 'Design request '.$design->package_name.' has been approved by '.$current_user_data->first_name.' '.$current_user_data->last_name.'.',
                        'button_text' => 'View design request',
                        'button_url' => route('user.designs.requests.view', $design->id),
                    );

                    $users = $design->users()->get();
                    if( $users->count() >= 1 ):
                        foreach( $users as $user ){
                            Notification::send($user, new ApprovedDesignRequest($emailContent));
                        }
                    endif;

                    return redirect()->route('user.designs.requests.view', $design_id)->with('success', 'Design Request Approved.');
                endif;
            endif;
        }

        return redirect('/dashboard');
    }
}
