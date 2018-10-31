<?php

namespace MyDesigner\Http\Controllers\Style;

use Illuminate\Http\Request;
use MyDesigner\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use MyDesigner\Models\Style;
use MyDesigner\Models\User;
use MyDesigner\Models\Attachment;

class StyleController extends Controller
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
    public function index(Request $request)
    {
        $current_user_id = Auth::id();
        $styles = Style::where('users_id', '=', Auth::id())->get();

        if( $request->user()->hasRole('user') ){
            return view('user.styles.index', compact('current_user_id', 'styles'));
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
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_user_id = Auth::id();
        
        $validator = $request->validate([
            'style_name' => 'required|string|max:255',
            'type' => 'required|string|max:255|',
            //'filevalue' => 'required|string|max:255',
        ]);

        $request_type = 'text';
        $style_value = $request->filevalue;

        if( $request->type == 'url' ){
            $request_type = 'url';
            
            $validator = $request->validate([
                'filevalue' => 'required|max:10000|mimes:png,jpeg',
            ]);
            
            $filevalue = $request->file('filevalue');
            $extension = $filevalue->getClientOriginalExtension();
            Storage::disk('public')->put($filevalue->getFilename().'.'.$extension,  File::get($filevalue));

            $attachment = new Attachment;
            $attachment['mime'] = $filevalue->getClientMimeType();
            $attachment['filename_original'] = $filevalue->getClientOriginalName();
            $attachment['filename'] = $filevalue->getFilename().'.'.$extension;
            $style_value = $filevalue->getFilename().'.'.$extension;
            
        }

        $user = User::where('id', $current_user_id)->firstOrFail();
        $style = new Style;
        $style->users()->associate($user);

        $style['style_name'] = $request->style_name;
        $style['type'] = $request_type;
        $style['value'] = $style_value;
        $style->save();

        if( $request_type == 'url' ){
            //$attachment['attachments_id'] = $style->id;
            $attachment = $style->attachments()->save($attachment);
        }

        return redirect()->route('style.settings.index')->with('success', 'Style added successfully.');
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

    /**
     * Display a listing of the resource for Admin Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_view(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $styles = Style::where('users_id', '=', $user_id)->get();

        if( $request->user()->hasRole('admin') ){
            return view('admin.styles.index', compact('user', 'styles'));
        }
        else{
            return redirect('/dashboard');
        }

    }
}
