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
				displayError: function(errorMessage) { // FIXME: in a real project, errors would be displayed inline or in some formatted way. Using `alert` for now.
					alert(errorMessage);
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
                        Comments.displayError("Please enter your username.");
                        return;
                    }
                    var comment = commentInput.value;
                    if (!comment) {
                        Comments.displayError("Please enter your comment.");
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
					xhr.setRequestHeader("Accept", "application/json");
                    var formData = new FormData();
                    formData.append("username", username);
                    formData.append("comment", comment);
                    formData.append("_token", token);
                    xhr.addEventListener("readystatechange", function(event) {
                        if (xhr.readyState === 4) {
							var response;

							try {
								response = JSON.parse(xhr.responseText);
							} catch (ignore) {}

                            if (response) {
								if (!response.errors) {
									Comments.prependMarkupToList(response.data);
									Comments.clearForm();
								} else {
									Comments.displayError(Object.values(response.errors).join("\n"));
								}
                            } else {
                                console.error("Unexpected response when posting new comment.", xhr.responseText);
                                Comments.displayError("There was a problem posting your comment. Please try again or contact support.");
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
