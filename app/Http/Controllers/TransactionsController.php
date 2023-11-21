<?php
namespace App\Http\Controllers;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use App\Models\Commentable;
use App\Models\Comment;
use App\Models\Answer;
class TransactionsController extends Controller
{
    public static function createQuestion($user_id,$title,$content1)
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
        
    public static function editQuestion($question_id,$title,$content)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
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
            $commentable = commentable::find($commentable_id);

            $content1->save();
            // Insert Answer

            $comment = new Comment([
                'id' => $content1->id,
                'commentable_id' => $commentable_id,
            ]);


            $comment->save();
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
    public static function deleteUser($user_id){
        try {
            // Start the transaction
            DB::beginTransaction();
            $user = User::find($user_id);
            $user->username = "Deleted";
            $user->email = "Deleted";
            $user->password = "Deleted";
            $user->bio = "Deleted";
            $user->points = 0;
            $user->nquestion = 0;
            $user->nanswer = 0;
            $user->profilepicture = "Deleted";
            $user->paylink = "Deleted";
            $user->usertype = "Deleted";
            $user->save();
            DB::table('content')
            ->join('commentable', 'commentable.id', '=', 'content.id')
            ->join('question', 'question.id', '=', 'commentable.id')
            ->where('content.user_id', $user_id)
            ->update(['content.content' => 'Deleted', 'question.title' => 'Deleted' , 'content.deleted' => true]);
            DB::table('content')
            ->join('commentable', 'commentable.id', '=', 'content.id')
            ->join('answer', 'answer.id', '=', 'commentable.id')
            ->where('content.user_id', $user_id)
            ->update(['content.content' => 'Deleted', 'content.deleted' => true]);
            // Commit the transaction
            DB::table('content')
            ->join('comment', 'comment.id', '=', 'content.id')
            ->where('content.user_id', $user_id)
            ->update(['content.content' => 'Deleted', 'content.deleted' => true]);
            DB::commit();
            return $user;
        
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
        
            // Handle the exception (log it, show an error message, etc.)
            // For example, you might log the error like this:
            \Log::error('Transaction failed: ' . $e->getMessage());
        }
    }
}