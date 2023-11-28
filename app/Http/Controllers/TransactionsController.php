<?php
namespace App\Http\Controllers;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use App\Models\Commentable;
use App\Models\Comment;
use App\Models\Answer;
use App\Models\User;
use App\Models\Notification;
use App\Models\AnswerNotification;
use App\Models\CommentNotification;
class TransactionsController extends Controller
{
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
            $question->save();
            $content1->save();
            // Commit the transaction
            DB::commit();
            return $question;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
            return $e->getMessage();
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
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
}