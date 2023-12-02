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
            $results = Notification::select('*')
            ->leftJoin('badgeattainmentnotification', 'notification.id', '=', 'badgeattainmentnotification.notification_id')
            ->leftJoin('answernotification', 'notification.id', '=', 'answernotification.notification_id')
            ->leftJoin('votenotification', 'notification.id', '=', 'votenotification.notification_id')
            ->leftJoin('commentnotification', 'notification.id', '=', 'commentnotification.notification_id')
            ->where('notification.user_id', Auth::user()->id)
            ->orderBy('notification.viewed', 'asc')
            ->orderBy('notification.date', 'desc')
            ->paginate(5);
            $notifications = $results->items();
            foreach($notifications as $notification){
                if($notification->badge_id != null){
                    $notification->type = 'Badge Attainment';
                }else if($notification->answer_id != null){
                    $notification->type = 'Answer';
                }else if($notification->vote != null){
                    $notification->type = 'Vote';
                }else if($notification->comment_id != null){
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
            if(TransactionsController::deleteNotifications(Auth::user()->id)){
                return redirect('/notifications');
            } else {
                return redirect('/notifications');
            }
        } else {
            return redirect('/login');
        }
    }
    public function deleteNotification(Request $request)
    {
        if( Auth::check()){
            $notification_id = $request->input('notification_id');
            if(TransactionsController::deleteNotification($notification_id)){
                return redirect('/notifications');
            } else {
                return redirect('/notifications');
            }
        } else {
            return redirect('/login');
        }
    }
}

