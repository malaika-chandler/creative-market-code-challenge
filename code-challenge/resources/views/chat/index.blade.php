<!doctype html>
<html>
    <head>

        <title>Creative Market Chat</title>

        <!-- Styles -->
        <style>
            html, body {
                font-family: "Helvetica";
            }
        </style>

    </head>
    <body>
        <div class="content">
            <ul class="comments">
                @each('chat.comment', $comments, 'comment')
            </ul>
        </div>
    </body>
</html>
