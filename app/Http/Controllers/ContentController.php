<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Content;
use App\Models\UnblockRequest;


class ContentController extends Controller
{
    public function reportContent(Request $request, $content_id)
    {
        
        $user = auth()->user();
        $content = Content::find($content_id);
        $this->authorize("report", $content);
        if(Report::where('user_id', $user->id)->where('content_id', $content_id)->exists()){
            Report::where('user_id', $user->id)->where('content_id', $content_id)->delete();
            $content->reports--;
        }
        else{
            $report = new Report([
                'user_id' => $user->id,
                'content_id' => $content_id
            ]);

            $report->save();
            $content->reports++;
        }
        $content->save();
        return redirect()->back();
    }

    public function unblockrequest(Request $request, $id)
    {
        $this->authorize("unblock", Content::find($id));
        $userId = $request->query('user_id');
        $content = Content::where('id', $id)
        ->with(['comment', 'question', 'answer'])->first();
        if ($content->comment) {
            $content->type = 'comment';
            $content->content_id = $content->comment->id;
        } elseif ($content->answer) {
            $content->type = 'answer';
            $content->content_id = $content->answer->id;
        } elseif ($content->question) {
            $content->type = 'question';
            $content->content_id = $content->question->id;
        }
        

        return view('pages.unblockrequest', ['content' => $content, 'user_id' => $userId]);
    }

    public function sendunblock(Request $request)
    {   
        $content_id = $request->input('content_id');
        $user_id = $request->input('user_id');
        $reason = $request->input('reason');
        $this->authorize("unblock", Content::find($request->input('content_id')));

        $unblockRequest = new UnblockRequest;
        $unblockRequest->user_id = $user_id;
        $unblockRequest->content_id = $content_id;
        $unblockRequest->description = $reason;
        $unblockRequest->save();

        return redirect()->route('myblocked', ['id' => $user_id]);
    }

    public function moderatecontent() {
        $user = auth()->user();
        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(($user->usertype === 'admin' || $user->usertype === 'moderator')){
            $unblockRequests = UnblockRequest::with(['content', 'user'])->with(['comment', 'question', 'answer'])->paginate(5);

            foreach($unblockRequests as $unblockRequest){
                if ($unblockRequest->comment) {
                    $unblockRequest->type = 'comment';
                    $unblockRequest->content_id = $unblockRequest->comment->id;
                } elseif ($unblockRequest->answer) {
                    $unblockRequest->type = 'answer';
                    $unblockRequest->content_id = $unblockRequest->answer->id;
                } elseif ($unblockRequest->question) {
                    $unblockRequest->type = 'question';
                    $unblockRequest->content_id = $unblockRequest->question->id;
                }
            }
            return view('pages.moderatecontent', ['unblockRequests' => $unblockRequests]);
        }
        return redirect()->route('home');
    }

    public function reviewcontent(){
        $user = auth()->user();
        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(($user->usertype === 'admin' || $user->usertype === 'moderator')){
            $unblockRequest = UnblockRequest::find(request()->route('id'));
            $content = Content::where('id', $unblockRequest->content_id)
            ->with(['comment', 'question', 'answer'])->first();
            if ($content->comment) {
                $content->type = 'comment';
                $content->content_id = $content->comment->id;
            } elseif ($content->answer) {
                $content->type = 'answer';
                $content->content_id = $content->answer->id;
            } elseif ($content->question) {
                $content->type = 'question';
                $content->content_id = $content->question->id;
            }
            return view('pages.reviewcontent', ['unblockRequest' => $unblockRequest, 'content' => $content]);
        }
        return redirect()->route('home');
    }


    public function processRequest(Request $request)
    {
        $user = auth()->user();
        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(($user->usertype === 'admin' || $user->usertype === 'moderator')){
            $action = $request->input('action');
            $unblockRequestId = $request->input('unblock_request_id');
            $contentId = $request->input('content_id');

            if ($action === 'unblock') {
                $content = Content::find($contentId);
                $content->blocked = false;
                $content->deleted = false;
                $content->save();
            } else if ($action === 'keep_blocked') {
            }

            $unblockRequest = UnblockRequest::find($unblockRequestId);
            $unblockRequest->delete();

            return redirect()->route('moderatecontent');
        }
        return redirect()->route('home');
    }
}
