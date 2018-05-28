<!doctype html>
<html>
    <head>

        <title>Creative Market Chat</title>

        <!-- Styles -->
        <style>
            html, body {
                font-family: helvetica;
            }
        </style>

    </head>
    <body>
        <div class="content">
            @foreach ($comments as $comment)
                <p>Date: {{$comment->timestamp}} <br> Text: {{ $comment->text }}</p>
            @endforeach
        </div>
    </body>
</html>
