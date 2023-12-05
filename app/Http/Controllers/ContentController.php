<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Content;
use App\Models\Vote;


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
        }
        else{
            $report = new Report([
                'user_id' => $user->id,
                'content_id' => $content_id
            ]);

            $report->save();
        }

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
}
