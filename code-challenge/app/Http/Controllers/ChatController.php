<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\Comments;

class ChatController extends Controller
{
    /**
     * Shows all comments and form.
     *
     * @return Response
     */
    public function index()
    {
        $comments = Comments::all();

        return view('chat.index', ['comments' => $comments]);
    }

    /**
     * Posts comment to database and updates the view.
     *
     * @return Response
     */
    public function postComment()
    {
        $username = Input::get('username');
        $commentText = Input::get('comment');

        // Check if user already exists, create it if not
        $user = Users::firstOrCreate(['username' => $username]);
        $user->increment('count_comments');

        // Post comment
        $comment = new Comments;
        $comment->user_id = $user->id;
        $comment->text = $commentText;

        $comment->save();

        // Update view
        return view('chat.comment', ['comment' => $comment]);
    }
}
