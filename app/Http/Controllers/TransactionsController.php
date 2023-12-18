<?php
namespace App\Http\Controllers;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use App\Models\Commentable;
use App\Models\Comment;
use App\Models\Answer;
use App\Models\User;
use App\Models\Vote;
use App\Models\Notification;
use App\Models\AnswerNotification;
use App\Models\CommentNotification;
use App\Models\VoteNotification;
use App\Models\BadgeAttainmentNotification;
use App\Models\Tag;
use App\Models\QuestionTag;
use App\Models\FollowTag;
class TransactionsController extends Controller
{
    public static function votedowncontent($user_id,$content_id)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            $vote = new vote([
                'user_id' => $user_id,
                'content_id' => $content_id,
                'vote' => False,
            ]);
            $vote->save();
            $content = Content::find($content_id);
            

            // Commit the transaction
            DB::commit();
            return ($content->votes);
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            return $e->getMessage();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
        }
    }

    public static function voteupcontent($user_id, $content_id)
    {
        try {
             // Start the transaction
             DB::beginTransaction();
             $vote = new vote([
                 'user_id' => $user_id,
                 'content_id' => $content_id,
                 'vote' => True,
             ]);
             $vote->save();
             $content = Content::find($content_id);
             // Commit the transaction
             DB::commit();
            return ($content->votes);
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            return $e->getMessage();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
        }
    }
    public static function deletevote($user_id, $content_id)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            $vote = Vote::where('user_id', $user_id)->where('content_id', $content_id)->first();
            if($vote->vote){
                $content = Content::find($content_id);
                $vote->delete();
                DB::commit();
                return ($content->votes-1);
            }
            else{
                $content = Content::find($content_id);

                $vote->delete();
                DB::commit();
                
                return ($content->votes+1);
            }
        
        } catch (\Exception $e) {
            dd($e);
            // An error occurred, rollback the transaction
            DB::rollback();
            return $e->getMessage();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
        }
    }
    public static function createQuestion($user_id,$title,$content1,$tag_ids)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            // Insert Content
            $content = new Content([
                'user_id' => $user_id,
                'content' => $content1,
            ]);
            $content->save();

            // Insert Commentable
            $commentable = new Commentable(['id' => $content->id]);
            $commentable->save();
            // Insert Question
            $question = new Question([
                'id' => $content->id,
                'title' => $title,
            ]);
            $question->save();
            if($tag_ids !== null){
                $array =explode(",", $tag_ids);
                foreach($array as $tag_id){
                    DB::table('questiontag')->insert(
                        ['question_id' => $question->id, 'tag_id' => $tag_id]
                    );
                }
            }
            // Commit the transaction
            DB::commit();
            return $question;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
        
    public static function editQuestion($question_id,$title,$content,$tag_ids)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            DB::table('questiontag')->where('question_id', $question_id)->delete();
            if($tag_ids !== null){
                $array =explode(",", $tag_ids);
                foreach($array as $tag_id){
                    DB::table('questiontag')->insert(
                        ['question_id' => $question_id, 'tag_id' => $tag_id]
                    );
                }
            }
            $question = Question::find($question_id);
            $content1 = Content::find($question_id);
            // Delete the question and return it as JSON.
            //probably transaction
            $content1->content = $content;
            $question->title = $title;
            $content1->edited = true;
            $content1->date = now();
            $question->save();
            $content1->save();
            // Commit the transaction
            DB::commit();
            return $question;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }// Find the question.
    public static function deleteQuestion($question_id)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            $question = Question::find($question_id);

            $content1 = Content::find($question_id);
            // Delete the question and return it as JSON.
            //probably transaction

            $content1->content = " ";
            $question->title = "Deleted";
            $content1->deleted = true;

            $question->save();

            $content1->save();
            // Commit the transaction
            DB::commit();
            return $question;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }// Find the question.
    public static function createAnswer($user_id,$question_id,$content)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            // Insert Content
            $content1 = new Content([
                'user_id' => $user_id,
                'content' => $content,
            ]);
            $content1->save();

            // Insert Commentable
            $commentable = new Commentable(['id' => $content1->id]);
            $commentable->save();

            // Insert Answer
            $answer = new Answer([
                'id' => $content1->id,
                'question_id' => $question_id,
            ]);

            $answer->save();
            $notification = new Notification([
                'user_id' => $user_id,
            ]);
            $notification->save();

            $answerNotification = new AnswerNotification([
                'notification_id' => $notification->id,
                'answer_id' => $answer->id,
                'question_id' => $question_id,
            ]);
            $answerNotification->save();
            // Commit the transaction
            DB::commit();
            return $answer;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function createComment($user_id,$commentable_id,$content)
    {

        try {

            // Start the transaction
            DB::beginTransaction();
            // Insert Content
            $content1 = new Content([
                'user_id' => $user_id,
                'content' => $content,
            ]);
            $commentable = commentable::findOrFail($commentable_id);
            $content1->save();
            // Insert Answer

            $comment = new Comment([
                'id' => $content1->id,
                'commentable_id' => $commentable_id,
            ]);


            $comment->save();
            $notification = new Notification([
                'user_id' => $user_id,
            ]);
            $notification->save();

            $commentNotification = new CommentNotification([
                'notification_id' => $notification->id,
                'comment_id' => $comment->id,
            ]);
            $commentNotification->save();
            // Commit the transaction
            DB::commit();
            return $comment;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function deleteUser($user_id):bool {
        try {
            // Start the transaction
            DB::beginTransaction();
            $user = User::find($user_id);
            $user->username = null;
            $user->name = "Deleted";
            $user->email = null;
            $user->password = null;
            $user->bio = null;
            $user->profilepicture = null;
            $user->paylink = null;
            $user->save();

            DB::commit();
            echo "User deleted successfully.\n";

            return true;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
        
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function deleteNotifications($user_id):bool
    {
        try {
            // Start the transaction
            DB::beginTransaction();
            VoteNotification::join('notification', 'notification.id', '=', 'votenotification.notification_id')
            ->where('notification.user_id', $user_id)         
            ->delete();
            AnswerNotification::join('notification', 'notification.id', '=', 'answernotification.notification_id')
            ->where('notification.user_id', $user_id)
            ->delete();
            BadgeAttainmentNotification::join('notification', 'notification.id', '=', 'badgeattainmentnotification.notification_id')
            ->where('notification.user_id', $user_id)
            ->delete();
            CommentNotification::join('notification', 'notification.id', '=', 'commentnotification.notification_id')
            ->where('notification.user_id', $user_id)
            ->delete();
            Notification::where('user_id', $user_id)
            ->delete();
            DB::commit();
            return true;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function deleteNotification($notification_id):bool{
        try {
            // Start the transaction
            DB::beginTransaction();
            VoteNotification::where('notification_id', $notification_id)           
            ->delete();
            AnswerNotification::where('notification_id', $notification_id)
            ->delete();
            BadgeAttainmentNotification::where('notification_id', $notification_id)
            ->delete();
            CommentNotification::where('notification_id', $notification_id)
            ->delete();
            Notification::where('id', $notification_id)
            ->delete();
            DB::commit();

            return true;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function deleteTag(Tag $tag):bool{
        try {
            // Start the transaction
            DB::beginTransaction();
            FollowTag::where('tag_id', $tag->id)->delete();
            QuestionTag::where('tag_id', $tag->id)->delete();
            $tag->delete();
            DB::commit();
            return true;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
        
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function countPoints(User $user):bool{
        try{
            DB::beginTransaction();
            $points = 0;
            $questions = $user->questions();
            foreach($questions as $question){
                $points += $question->commentable->content->votes;
                $points += $question->answers->count();
            }
            $answers = $user->answers();
            foreach($answers as $answer){
                $points += $answer->commentable->content->votes;
            }
            $badges = $user->badges();
            $points += $badges->count()*20;
            $user->points = $points;
            $user->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
        
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
            return false;
        }
    }
}