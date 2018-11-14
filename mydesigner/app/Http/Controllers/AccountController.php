<?php

namespace MyDesigner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use MyDesigner\Models\User;
use MyDesigner\Models\Attachment;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|designer|user|manager');
    }

    /**
     * Display the specified resource.
     *
     * @param  \MyDesigner\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        $user = Auth::user();
        return view('account', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \MyDesigner\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $user = Auth::user();
        $current_user_id = $user->id;
        $avatar = $user->avatar;
        return view('edit-account', compact('user', 'current_user_id', 'avatar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $current_user_id = $user->id;

        if(Auth::user()->email != request('email')) {

            $validator = $request->validate([
                'email' => 'required|email|max:255|unique:users'
            ]);

            $user->email = request('email');
        }

        if( ! empty(request('password')) ) {

            $validator = $request->validate([
                'password'     => 'min:8|confirmed',
            ]);

            $user->password = Hash::make(request('password'));
        }

        if ( ! empty(request('avatar')) ) {
            $validator = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $avatar = $request->file('avatar');
            $extension = $avatar->getClientOriginalExtension();
            if( !Storage::disk('public')->has($current_user_id.'/avatar/') ){
                Storage::disk('public')->makeDirectory($current_user_id.'/avatar/');
            }
            Storage::disk('public')->put($current_user_id.'/avatar/'.$avatar->getFilename().'.'.$extension,  File::get($avatar));


            // delete existing avatar
            $get_attachments = $user->attachments()->where(['attachments_id' => $user->id, 'filename_original' => $user->avatar]);
            
            if( Storage::disk('public')->has($current_user_id.'/avatar/'.$get_attachments->first()['filename']) ){
                Storage::disk('public')->delete($current_user_id.'/avatar/'.$get_attachments->first()['filename']);
            }
            
            $get_attachments->delete();
            
            $attachment = new Attachment;
            $attachment['mime'] = $avatar->getClientMimeType();
            $attachment['filename_original'] = time().'-'.$avatar->getClientOriginalName();
            $attachment['filename'] = $avatar->getFilename().'.'.$extension;
            $avatar = time().'-'.$avatar->getClientOriginalName();
            $user->avatar = $avatar;


            $user->attachments()->save($attachment);
        }

        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $user->first_name = request('first_name');
        $user->last_name = request('last_name');

        $user->save();

        return redirect()->back()->with('success', 'Account updated.');

    }
}
