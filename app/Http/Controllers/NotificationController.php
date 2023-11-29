<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Notification;
use App\Models\VoteNotification;
use App\Models\CommentNotification;
use App\Models\AnswerNotification;
use App\Models\BadgeAttainmentNotification;

class NotificationController extends Controller
{
    function cmp($a, $b) {
        return strcmp($a->date, $b->date);
    }
    public function getNewNotifications(Request $request)
    {
        if( Auth::check()){
            $user = auth()->user();
            $badgesNotifications = Notification::select('badge.name as name')
            ->where('user_id', $user->id)
            ->where('viewed', false)
            ->join('badgeattainmentnotification', 'badgeattainmentnotification.id', '=', 'notification.id')
            ->join('badge', 'badge.id', '=', 'badgeattainmentnotification.badge_id')
            ->get();
            $answernotifications = Notification::select('appuser.username as username', 'answer.question_id as question_id')
            ->where('user_id', $user->id)
            ->where('viewed', false)
            ->join('answernotification', 'notification.id', '=', 'answernotification.id')
            ->join('content', 'content.id', '=', 'answernotification.answer_id')
            ->join('appuser', 'appuser.id', '=','content.user_id' )
            ->get();
            $commentnotifications = Notification::select('appuser.username as username', 'content.content as content', 'content.id as contentid') 
            ->where('user_id', $user->id)
            ->where('viewed', false)
            ->join('commentnotification', 'notification.id', '=', 'commentnotification.id')
            ->join('comment', 'comment.id', '=', 'commentnotification.comment_id')
            ->join('content', 'content.id', '=', 'commentnotification.comment_id')
            ->join('appuser', 'appuser.id', '=','content.user_id' )
            ->get();
            $result = [];
            foreach($badgesNotifications as $notification){
                $string = 'You have earned the badge ' . $notification->name;
                array_push($result, ['date' => $notification->date, 'content' => $string , 'link' => "/profile/" . $user->id]);
            }
            foreach($answernotifications as $notification){
                $string = 'You have new Answer from ' . $notification->username;
                array_push($result, ['date' => $notification->date, 'content' => $string ,'link' => "/question/" . $notification->question_id ]);
            }
            foreach($commentnotifications as $notification){
                $string = 'You have new Comment from ' . $notification->username;
                array_push($result, ['date' => $notification->date, 'content' => $string ,'link' => null ]);
            }
                
            usort($result, "cmp");
            return view('pages/notifications', ['notifications' => $result]);
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
            $user = auth()->user();
            Notification::where('user_id', $user->id)
            ->delete();
            VoteNotification::where('user_id', $user->id)           
            ->delete();
            AnswerNotification::join('answer', 'answer.id', '=', 'answernotification.answer_id')
            ->join('content', 'content.id', '=', 'answer.id')
            ->where('content.user_id', $user->id)
            ->delete();
            BadgeAttainmentNotification::where('user_id', $user->id)
            ->delete();
        } else {
            return redirect('/login');
        }
    }
}

