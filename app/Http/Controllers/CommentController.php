<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Content;
use App\Models\Commentable;

class CommentController extends Controller
{
    /**
     * Creates a new Comment.
     */
    public function createform(string $id){
        if (Auth::check()) {
            return view('pages.commentcreate', [
                'commentable_id' => $id
            ]);
        } else {
            return redirect('/login');
        }

    }
    public function create(Request $request,string $id)
    {
        // Create a blank new Comment.
        $comment = new Comment();

        // Check if the current user is authorized to create this Comment.
        $this->authorize('create', $comment);

        // Save the Comment and return it as JSON.
        $comment = TransactionsController::createComment(Auth::user()->id,$id,$request->input('content'));
        if($comment === null){
            //handle something
        }
        return redirect("/question/". $id);
    }

    /**
     * Delete a Comment.
     */
    public function delete(Request $request, string $id,string $comment_id)
    {
        // Find the Comment.
        $comment = Comment::find($comment_id);

        // Check if the current user is authorized to delete this Comment.
        $this->authorize('delete', $comment);
        $content1 = Content::find($comment->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content ="Deleted";
        $content1->edited = true;
        $content1->save();
        $answer = Answer::find($comment->commentable_id);
        if($answer === null){
            $question = Question::find($comment->commentable_id);
            return redirect("/question/". $question->id);
        }else{
            return redirect("/question/". $answer->question_id);
        }  
    }
    public function editform(string $id,string $comment_id){
        $comment = Comment::find($comment_id);
        if (Auth::check()) {
            return view('pages.commentedit', [
                'Comment' => $comment
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function edit(Request $request, string $id , string $comment_id)
    {
        // Find the Comment.
        $comment = Comment::find($comment_id);

        // Check if the current user is authorized to delete this Comment.
        $this->authorize('edit', $comment);
        $content1 = Content::find($comment->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content =$request->input('content');
        $content1->edited = true;
        $content1->save();
        $answer = Answer::find($comment->commentable_id);
        if($answer === null){
            $question = Question::find($comment->commentable_id);
            return redirect("/question/". $question->id);
        }else{
            return redirect("/question/". $answer->question_id);
        } 
    }
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    /*
    public function listuserComments()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.

            // Get Comments for user ordered by id.
            $comments = Comment::orderBy('id')->get();
            // Check if the current user can list the Comments.
            $this->authorize('list', Comment::class);

            // The current user is authorized to list Comments.

            // Use the pages.comments template to display all Comments.
            return view('pages.comments', [
                'Comment' => $comment,
                'Comments' => $comments
            ]);
        }
    }*/
}