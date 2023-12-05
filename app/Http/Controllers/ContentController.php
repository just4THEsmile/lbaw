<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Content;
use App\Models\Vote;
use App\Models\UnblockRequest;


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
        $this->authorize("unblock", Content::find($id));
        $userId = $request->query('user_id');
        $content = Content::find($id);
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

        return redirect()->route('profile', ['id' => $user_id]);
    }

    public function moderatecontent() {
        //$this->authorize("moderate", $Auth::user());
        $unblockRequests = UnblockRequest::with(['content', 'user'])->paginate(5);

        return view('pages.moderatecontent', ['unblockRequests' => $unblockRequests]);
    }

    public function reviewcontent(){
        //$this->authorize("moderate", Auth::user());
        $unblockRequest = UnblockRequest::find(request()->route('id'));
        $content = Content::find($unblockRequest->content_id);
        return view('pages.reviewcontent', ['unblockRequest' => $unblockRequest, 'content' => $content]);
    }


    public function processRequest(Request $request)
    {
        //$this->authorize("moderate", Auth::user());
        $action = $request->input('action');
        $unblockRequestId = $request->input('unblock_request_id');
        $contentId = $request->input('content_id');

        if ($action === 'unblock') {
            $content = Content::find($contentId);
            $content->blocked = false;
            $content->save();
        } else if ($action === 'keep_blocked') {
        }

        $unblockRequest = UnblockRequest::find($unblockRequestId);
        $unblockRequest->delete();

        return redirect()->route('moderatecontent');
    }
}
