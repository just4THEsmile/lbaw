<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Content;
use App\Models\Vote;
use App\Models\UnblockRequest;
use App\Models\UnblockAccount;
use Illuminate\Auth\Access\AuthorizationException;


class ContentController extends Controller
{
    public function reportContent(Request $request, $content_id)
    {   
        

        $user = auth()->user();
        if($user === null){
            return response()->json([
                'message' => 'not logged in',
            ], 500);
        }
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
    public function voteContent( Request $request, $content_id )
    {   

        $user = auth()->user();
        $vote = Vote::where('user_id', $user->id)->where('content_id', $content_id)->first();
        if($vote != null){
            if($vote->vote == True){
                if($request->input('value') == "up"){
                    $transaction = TransactionsController::deletevote($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting up',
                        ], 500);
                    }else{
                        return response()->json([
                            'id' => $content_id,
                            'votes' => $transaction,
                            'message' => 'none',
                        ], 200);
                    }
                }
                else{
                    $transaction = TransactionsController::deletevote($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting down',
                        ], 500);
                    }
                    $transaction = TransactionsController::votedowncontent($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting down',
                        ], 500);
                    }else{
                        return response()->json([
                            'id' => $content_id,
                            'votes' => $transaction,
                            'message' => 'down',
                        ], 200);
                    }
                }
            }else{
                if($request->input('value') == "up"){
                    $transaction=TransactionsController::deletevote($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting up',
                        ], 500);
                    }
                    $transaction= TransactionsController::voteupcontent($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting up',
                        ], 500);
                    }else{
                        return response()->json([
                            'id' => $content_id,
                            'votes' => $transaction,
                            'message' => 'up',
                        ], 200);
                    }

                    return response()->json("up");
                }else{
                    $transaction = TransactionsController::deletevote($user->id, $content_id);
                    if($transaction === null or !is_int($transaction)){
                        return response()->json([
                            'message' => 'error voting down',
                        ], 500);
                    }else{
                        return response()->json([
                            'id' => $content_id,
                            'votes' => $transaction,
                            'message' => 'none',
                        ], 200);
                    }
                }
            }
        }else{

            if($request->input('value') == "up"){
                $transaction = TransactionsController::voteupcontent($user->id, $content_id);
                if($transaction === null or !is_int($transaction)){
                    return response()->json([
                        'message' => 'error voting up',
                    ], 500);
                }else{
                    return response()->json([
                        'id' => $content_id,
                        'votes' => $transaction,
                        'message' => 'up',
                    ], 200);
                }

            }else{

                $transaction = TransactionsController::votedowncontent($user->id, $content_id);
                if($transaction === null or !is_int($transaction)){
                    return response()->json([
                        'message' => 'error voting down',
                    ], 500);
                }else{
                    return response()->json([
                        'id' => $content_id,
                        'votes' => $transaction,
                        'message' => 'down',
                    ], 200);
                }
            }
        }
    }    

    public function unblockrequest(Request $request, $id)
    {
        try {
            $this->authorize("unblock", Content::find($id));
        } catch (AuthorizationException $e) {
            if (Auth::check()) {
                return redirect()->route('myblocked',['id' => Auth::user()->id])->withErrors(['content' => 'The provided content does not exist or doesn']);
            } else {
                return redirect()->route('login');
            }
        }
        $userId = $request->query('user_id');
        $content = Content::where('id', $id)
        ->with(['comment', 'question', 'answer'])->first();
        if($content === null){
            return redirect()->route('myblocked', ['id' => $userId])->withErrors(['content' => 'The provided content does not exist']);
        }
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
        if(Content::find($request->input('content_id')) === null){
            return redirect()->route('myblocked', ['id' => $user_id])->withErrors(['content' => 'The provided content does not exist']);
        }
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
    public function moderateusers() {
        $user = auth()->user();
        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(($user->usertype === 'admin' || $user->usertype === 'moderator')){
            $unblockAccounts = UnblockAccount::with(['user'])->paginate(5);
            return view('pages.moderateusers', ['unblockAccounts' => $unblockAccounts]);
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
            if($unblockRequest === null){
                return redirect()->route('moderatecontent')->withErrors(['unblockrequest' => 'The unblock request does not exist']);
            }
            $content = Content::where('id', $unblockRequest->content_id)
            ->with(['comment', 'question', 'answer'])->first();
            if($content === null){
                return redirect()->route('moderatecontent')->withErrors(['content' => 'The provided content does not exist']);
            }
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
            if($action === null or $unblockRequestId === null or $contentId === null){
                return redirect()->route('moderatecontent')->withErrors(['unblockrequest' => 'The provided unblock request does not exist']);
            }
            if ($action === 'unblock') {
                $content = Content::find($contentId);
                $content->blocked = false;
                $content->deleted = false;
                $content->reports = 0;
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
