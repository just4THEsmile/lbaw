<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Content;
use App\Models\Notification;
use App\Models\VoteNotification;
use App\Models\CommentNotification;
use App\Models\AnswerNotification;
use App\Models\BadgeAttainmentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    function cmp($a, $b) {
        return strcmp($a->date, $b->date);
    }
    public function getnotifications(Request $request)
    {
        if( Auth::check()){
            $results = Notification::select('comment_content.content as comment_content','badge.name as badge_name','question.title as title','voteuser.profilepicture as vote_user_profile_pick','voteuser.username as vote_username','comment.commentable_id as commentable_id','commentuser.profilepicture as comment_user_profile_pick','commentuser.username as comment_username','answeruser.profilepicture as answer_user_picture','answeruser.username as answer_username', 'answercontent.content as answer_content', 'notification.id as notification_id', 'notification.date as date', 'notification.viewed as viewed', 'answer.question_id as question_id',   'badgeattainmentnotification.badge_id as badge_id', 'badgeattainmentnotification.notification_id as badge_notification_id', 'votenotification.vote as vote', 'votenotification.notification_id as vote_notification_id', 'commentnotification.comment_id as comment_id', 'commentnotification.notification_id as comment_notification_id', 'answernotification.answer_id as answer_id')
            ->leftJoin('badgeattainmentnotification', 'notification.id', '=', 'badgeattainmentnotification.notification_id')
            ->leftJoin('badge', 'badge.id', '=', 'badgeattainmentnotification.badge_id')
            //answer notifications
            ->leftJoin('answernotification', 'notification.id', '=', 'answernotification.notification_id')
            ->leftJoin('answer', 'answernotification.answer_id', '=', 'answer.id')
            ->leftJoin('content as answercontent', 'answernotification.answer_id', '=', 'answercontent.id')
            ->leftJoin('question', 'question.id', '=', 'answer.question_id')
            ->leftJoin('appuser as answeruser' , 'answercontent.user_id', '=', 'answeruser.id')
            //vote notifications
            ->leftJoin('votenotification', 'notification.id', '=', 'votenotification.notification_id')
            ->leftJoin('appuser as voteuser' , 'voteuser.id', '=', 'votenotification.user_id')
            //comment notifications
            ->leftJoin('commentnotification', 'notification.id', '=', 'commentnotification.notification_id')
            ->leftJoin('comment', 'comment.id', '=', 'commentnotification.comment_id')
            ->leftJoin('content as comment_content' , 'comment_content.id', '=', 'comment.id')
            ->leftJoin('appuser as commentuser' , 'commentuser.id', '=', 'comment_content.user_id')
            ->where('notification.user_id', Auth::user()->id)
            ->orderBy('notification.viewed', 'asc')
            ->orderBy('notification.date', 'desc')
            ->paginate(5);
            $notifications = $results->items();
            foreach($notifications as $notification){
                if($notification->badge_id !== null){
                    $notification->type = 'Badge Attainment';
                }else if($notification->answer_id !== null){
                    $notification->type = 'Answer';
                }else if($notification->vote !== null){
                    $notification->type = 'Vote';
                }else if($notification->comment_id !== null){
                    $notification->type = 'Comment';
                }
                //echo $notification;
                $someDate = Carbon::parse($notification->date);
                $notification->notification_date = $someDate->diffForHumans(); 
            }
            Notification::where('notification.user_id', Auth::user()->id)->update(['viewed' => true]);
            return view('pages.notifications', ['notifications' => $notifications,'PaginationController' => $results]);
        } else {
            return redirect('/login');
        }
    }
    public function SeeNotifications(Request $request)
    {
        if( Auth::check()){
            $user = auth()->user();
            Notification::where('user_id', $user->id)
            ->where('viewed', false)
            ->update(['viewed' => True]);
        } else {
            return redirect('/login');
        } 
    }
    public function DeleteNotifications(Request $request)
    {
        if( Auth::check()){
            $result = TransactionsController::deleteNotifications(Auth::user()->id);
            if($result === true){
                return redirect('/notifications');
            } else {
                return redirect()->route('notifications_page')->withErrors(['notifications' => 'Something went wrong!']); 
            }
        } else {
            return redirect('/login');
        }
    }
    public function deleteNotification(Request $request)
    {
        if( !Auth::check()){
            redirect('/login'); 
        }
        $notification_id = $request->input('notification_id');
        $notification = Notification::find($notification_id)->first();
        if($notification === null){
            return redirect()->route('notifications_page')->withErrors(['notifications' =>'The provided Notification does not exist']); 
        }
        $result = TransactionsController::deleteNotification($notification_id);
        if($result === true){
            return redirect('/notifications');
        } else {
            return redirect()->route('notifications_page')->withErrors(['notifications' => 'Something went wrong!']);
        }

    }
    public function number_of_notifications()
    {
        if( !Auth::check()){
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
        $id = Auth::user()->id;
        if(Auth::user()->id !== $id){
            return response()->json([
                'message' => 'Not authorized',
            ], 302);
        }
        $result = Notification::where('user_id', $id)->where('viewed','false')->count();
        return response()->json($result);

    }
}

