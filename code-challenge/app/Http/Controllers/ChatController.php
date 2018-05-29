<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;
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
     * Posts comment to database and creates an element to send
     * to the view.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postComment(Request $request)
    {
        $response = [
            'data' => null,
            'errors' => null
        ];

        $validated = $request->validate([
            'username' => 'bail|required|max:' . Users::MAX_USERNAME_LENGTH,
            'comment' => 'bail|required|max:' . Comments::MAX_COMMENT_LENGTH,
        ]);

        $username = $validated['username'];
        $commentText = $validated['comment'];

        try {
            // Check if user already exists, create it if not
            $user = Users::firstOrCreate(['username' => $username]);

            // Increment the number of comments for the user
            $user->increment('count_comments');

        } catch(\Illuminate\Database\QueryException $ex) {
            $response['errors'] = ['username' => $ex->getMessage()];
            return response()->json($response);
        }

        try {
            // Post comment
            $comment = new Comments;
            $comment->user_id = $user->id;
            $comment->text = $commentText;
            $comment->save();

            $comment->username = $user->username;

        } catch(\Illuminate\Database\QueryException $ex) {
            $response['errors'] = ['comment' => $ex->getMessage()];
            return response()->json($response);
        }

        $view = View::make('chat.comment', ['comment' => $comment]);
        $response['data'] = $view->render();

        return response()->json($response);
    }
}
