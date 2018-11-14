<?php

namespace MyDesigner\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use MyDesigner\Models\User;
use MyDesigner\Models\Design;
use MyDesigner\Models\Feedback;
use MyDesigner\Models\Attachment;

class FeedbackController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function feedback_submit(Request $request, $design_id)
    {
        $design = Design::findOrFail($design_id);

        $current_user_data = Auth::user();

        $feedback_status = 'approved';
        if( $current_user_data->hasRole('designer') ){
            $feedback_status = 'pending';
        }

        $current_user_id = $current_user_data->id;

        $validator = $request->validate([
            'comment' => 'required|max:1000',
            'attachment' => 'max:20480|mimes:jpeg,png,jpg,pdf,docx,doc,psd,zip,JPEG,PNG,JPG,PDF,DOCX,DOC,PSD,ZIP',
        ]);

        $feedback = new Feedback;
        $feedback->user()->associate($current_user_data);
        $feedback->design()->associate($design);

        $feedback['comment'] = $request->comment;
        $feedback['version'] = $request->version;
        $feedback['status'] = $feedback_status;
        $feedback->save();
        
        if( $request->file('attachment') ){
            $feedback_attachment = $request->file('attachment');
            $extension = $feedback_attachment->getClientOriginalExtension();
            if( !Storage::disk('public')->has($current_user_id.'/feedback-attachment/') ){
                Storage::disk('public')->makeDirectory($current_user_id.'/feedback-attachment/');
            }
            Storage::disk('public')->put($current_user_id.'/feedback-attachment/'.$feedback_attachment->getFilename().'.'.$extension,  File::get($feedback_attachment));
            
            $attachment = new Attachment;
            $attachment['mime'] = $feedback_attachment->getClientMimeType();
            $attachment['filename_original'] = time().'-'.$feedback_attachment->getClientOriginalName();
            $attachment['filename'] = $feedback_attachment->getFilename().'.'.$extension;

            $feedback->attachments()->save($attachment);
        }

        return redirect()->route('user.designs.requests.view', $design_id)->with('success', 'Message submitted.');
    }

    public function approve_feedback($design_id, $feedback_id)
    {
        $design = Design::findOrFail($design_id);
        $feedback = Feedback::findOrFail($feedback_id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;

        if( $current_user_data->hasRole('manager') ){
            $manager = $design->users()->wherePivot('type', 'manager');
            if( $manager->count() >= 1 ):
                if( $manager->first()->id == $current_user_id ):
                    $feedback->status = 'approved';

                    $feedback->save();

                    return redirect()->route('user.designs.requests.view', $design_id)->with('success', 'Feedback Approved.');
                endif;
            endif;
        }

        return redirect('/dashboard');
    }
    
    public function delete_feedback($design_id, $feedback_id)
    {
        $design = Design::findOrFail($design_id);
        $feedback = Feedback::findOrFail($feedback_id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;

        if( $current_user_data->hasRole('manager') ){
            $feedback_lists = Feedback::where(['design_id' => $design_id])->latest()->get();

            $manager = $design->users()->wherePivot('type', 'manager');
            if( $manager->count() >= 1 ):
                if( $manager->first()->id == $current_user_id ):
                    $feedback->delete();

                    return redirect()->route('user.designs.requests.view', $design_id)->with('success', 'Feedback Deleted.');
                endif;
            endif;
        }

        return redirect('/dashboard');
    }

    public function update_feedback(Request $request, $design_id, $feedback_id)
    {
        $design = Design::findOrFail($design_id);
        $feedback = Feedback::findOrFail($feedback_id);

        $current_user_data = Auth::user();
        $current_user_id = $current_user_data->id;

        if( $current_user_data->hasRole('manager') ){
            $feedback_lists = Feedback::where(['design_id' => $design_id])->latest()->get();

            $manager = $design->users()->wherePivot('type', 'manager');
            if( $manager->count() >= 1 ):
                if( $manager->first()->id == $current_user_id ):

                    $validator = $request->validate([
                        'comment' => 'required|max:1000',
                    ]);

                    $feedback['comment'] = $request->comment;
                    $feedback['version'] = $request->version;
                    $feedback['status'] = 'approved';

                    $feedback->save();

                    mail('lesz_03@yahoo.com', 'My Designer Notification', 'New Feedback.');

                    return redirect()->route('user.designs.requests.view', $design_id)->with('success', 'Feedback Approved.');
                endif;
            endif;
        }

        return redirect('/dashboard');
    }
}
