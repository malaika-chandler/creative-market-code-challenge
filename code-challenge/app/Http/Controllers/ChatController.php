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

        return view('chat', ['comments' => $comments]);
    }
}
