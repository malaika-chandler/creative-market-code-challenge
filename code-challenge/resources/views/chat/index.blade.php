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

        <!-- Form Behavior -->
        <script type="text/javascript">
            var Comments = {
                init: function() {
                    var formElement = document.getElementById("commentsForm");
                    if (!formElement) {
                        console.error("Missing comment form.");
                        return;
                    }
                    formElement.addEventListener("submit", Comments.handleFormSubmit);
                },
                handleFormSubmit: function(event) {
                    event.preventDefault();
                    var formElement = event.target;
                    var usernameInput = formElement.querySelector('[name="username"]');
                    var commentInput = formElement.querySelector('[name="comment"]');
                    var tokenInput = formElement.querySelector('[name="_token"]');
                    if (!usernameInput || !commentInput) {
                        console.error("Missing username or comment inputs");
                        return;
                    }
                    var username = usernameInput.value;
                    if (!username) {
                        alert("Please enter your username.");
                        return;
                    }
                    var comment = commentInput.value;
                    if (!comment) {
                        alert("Please enter your comment.");
                        return;
                    }
                    var token = tokenInput.value;
                    if (!token) {
                        console.error("Missing CSRF token.");
                        return;
                    }
                    Comments.postNew(username, comment, token);
                },
                postNew: function(username, comment, token) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "/postComment");
                    var formData = new FormData();
                    formData.append("username", username);
                    formData.append("comment", comment);
                    formData.append("_token", token);
                    xhr.addEventListener("readystatechange", function(event) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200 && xhr.responseText) {
                                Comments.prependMarkupToList(xhr.responseText);
                                Comments.clearForm();
                            } else {
                                console.error("Error posting new comment", xhr.responseText);
                            }
                        }
                    });
                    xhr.send(formData);
                },
                prependMarkupToList: function(markup) {
                    if (!markup || "string" !== typeof markup) {
                        console.error("Empty or non-string markup", markup);
                        return;
                    }
                    var listElement = document.querySelector("ul.comments");
                    if (!listElement) {
                        console.error("Missing comments list.");
                        return;
                    }
                    var temporaryElement = document.createElement("div");
                    temporaryElement.innerHTML = markup;
                    // assuming markup consists of 1 <li>
                    listElement.insertBefore(temporaryElement.firstChild, listElement.firstChild);
                },
                clearForm: function() {
                    var formElement = document.getElementById("commentsForm");
                    formElement.querySelector('[name="username"]').value = "";
                    formElement.querySelector('[name="comment"]').value = "";
                }
            };

            window.addEventListener("load", Comments.init);
        </script>

    </head>
    <body>
        <div class="content">
            <form class="commentForm" id="commentsForm">
                @csrf
                <input type="text" name="username">
                <textarea name="comment" class="commentTextarea"></textarea>
                <button>Submit</button>
            </form>
            <ul class="comments">
                @each('chat.comment', $comments, 'comment')
            </ul>
        </div>
    </body>
</html>
