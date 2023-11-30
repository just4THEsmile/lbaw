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
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    function cmp($a, $b) {
        return strcmp($a->date, $b->date);
    }
    public function getnotifications(Request $request)
    {
        if( Auth::check()){
            $limit = 10;
            $currentPage = $request->input('currpage');
            $offset = $currentPage * $limit;
            $sql = "
            SELECT 
                'Vote' AS notification_type,
                n.id AS notification_id,
                n.user_id,
                vn.content_id,
                vn.vote,
                n.date AS notification_date,
                n.viewed
            FROM 
                Notification n
            LEFT JOIN 
                VoteNotification vn ON n.id = vn.notification_id

            UNION

            SELECT 
                'Badge Attainment' AS notification_type,
                n.id AS notification_id,
                ban.user_id,
                ban.badge_id AS content_id,
                NULL AS vote,
                n.date AS notification_date,
                n.viewed
            FROM 
                Notification n
            LEFT JOIN 
                BadgeAttainmentNotification ban ON n.id = ban.notification_id

            UNION

            SELECT 
                'Answer' AS notification_type,
                n.id AS notification_id,
                c.user_id,
                an.answer_id AS content_id,
                NULL AS vote,
                n.date AS notification_date,
                n.viewed
            FROM 
                Notification n
            LEFT JOIN 
                AnswerNotification an ON n.id = an.notification_id
            LEFT JOIN 
                Content c ON an.answer_id = c.id
            UNION

            SELECT 
                'Comment' AS notification_type,
                n.id AS notification_id,
                c.user_id,
                cn.comment_id AS content_id,
                NULL AS vote,
                n.date AS notification_date,
                n.viewed
            FROM 
                Notification n
            LEFT JOIN 
                CommentNotification cn ON n.id = cn.notification_id
            LEFT JOIN 
                Content c ON cn.comment_id = c.id
            ORDER BY
                notification_date DESC
        ";

        // Execute the raw SQL query and fetch the results
            $results = DB::select($sql);
            return view('pages.notifications', ['notifications' => $results ,'current_page' =>$currentPage]);
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

