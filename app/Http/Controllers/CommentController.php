<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Content;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Commentable;

class CommentController extends Controller
{
    /**
     * Creates a new Comment.
     */
    public function createform(string $id){
        if (!Auth::check()) {
            redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $commentable = Commentable::find($id);
        if($commentable === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided Answer or question does not exist.']);
        }
        return view('pages.commentcreate', [
            'commentable_id' => $id
        ]);

    }
    public function create(Request $request,string $id)
    {
        // Check if the current user is authorized to create this Comment.
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $request->validate(['content' => 'required|string|min:8|max:255',
    ]);
        $commentable = Commentable::find($id);
        if($commentable === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided Answer or question does not exist.']);
        }
        // Save the Comment and return it as JSON.
        $result = TransactionsController::createComment(Auth::user()->id,$id,$request->input('content'));
        if($result=== False){
            return redirect()->route('home')->withErrors(['page' => 'There was an error when creating the comment.']);
        }
        $answer = Answer::find($result->commentable_id);
        if($answer === null){
            $question = Question::find($result->commentable_id);
            return redirect("/question/". $question->id);
        }else{
            return redirect("/question/". $answer->question_id);
        }  
    }

    /**
     * Delete a Comment.
     */
    public function delete(Request $request, string $id,string $comment_id)
    {
        // Find the Comment.
        $comment = Comment::find($comment_id);
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $comment = Comment::find($comment_id);
        if($comment === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided Comment does not exist.']);
        }
        // Check if the current user is authorized to delete this Comment.
        $this->authorize('delete', $comment);
        $content1 = Content::find($comment->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content ="Deleted";
        $content1->deleted = true;
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
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $comment = Comment::find($comment_id);
        if($comment === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided Comment does not exist.']);
        }
        return view('pages.commentedit', [
            'comment' => $comment
        ]);
    }

    public function edit(Request $request, string $id , string $comment_id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        // Find the Comment.
        $comment = Comment::find($comment_id);
        if($comment === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided Comment does not exist.']);
        }
        // Check if the current user is authorized to delete this Comment.
        $this->authorize('edit', $comment);
        $request->validate(['content' => 'required|string|min:8|max:255',
    ]);
        $content1 = Content::find($comment->id);

        $content1->content =$request->input('content');
        $content1->edited = true;
        $content1->date = now();
        $content1->save();
        $answer = Answer::find($comment->commentable_id);
        if($answer === null){
            $question = Question::find($comment->commentable_id);
            return redirect("/question/". $question->id);
        }else{
            return redirect("/question/". $answer->question_id);
        } 
    }
}