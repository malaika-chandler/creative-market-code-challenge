<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $comments = DB::table('comments')
                ->select('comments.*', 'users.username')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->orderBy('comments.created_at', 'desc')
                ->get();

        return view('chat.index', ['comments' => $comments]);
    }

    /**
     * Posts comment to database and updates the view.
     *
     * @return Response
     */
    public function postComment(Request $request)
    {
        $username = $request->input('username');
        $commentText = $request->input('comment');

        // Check if user already exists, create it if not
        $user = Users::firstOrCreate(['username' => $username]);

        // Increment the number of comments for the user
        $user->increment('count_comments');

        // Post comment
        $comment = new Comments;
        $comment->user_id = $user->id;
        $comment->text = $commentText;
        $comment->save();

        $comment->username = $user->username;

        // Update view
        return view('chat.comment', ['comment' => $comment]);
    }
}
