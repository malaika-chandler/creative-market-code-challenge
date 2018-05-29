# Creative Market Code Challenge

Small chat page where customers can ask questions and get answers

## Requirements

- User lands on page
	- At the top of the page, there is a text area for the username and one for the comment
	- Beneath existing comments in descending order, starting with the newest
- User posts a question
	- User enters username in first text area
	- User enters question in second
	- Validation ensuring no empty text fields
	- Assuming 2^16 (64kB) - 1 byte limit for now
	- They see their post without reloading
- User sees their question at the top of the list of comments
	- Nice To Have:
		- User can see which posts are responding to which questions (i.e. threads)
		- They see the reply without reloading (i.e. live chat)

## Setup

Run `php artisan migrate` to set up the database.

## Architecture

#### Using Laravel 5.6
#### Using Homestead 7.6.2 with MySQL

There will be a:
- Chat Controller
	- "Index" method
		- Load the view with initial comments data from the model
	- "Post" method
		- Save new comments
			- Username is created if it doesn't exist
			- Comment count is incremented on user
			- Comment is linked to newly-created user or existing user using Comment model
		- Returns formatted comment just posted using view method for comment html
- Views
	- Chat Index
		- Render a form to post a new comment
		- List existing comments (loop "Chat Comment" sub-view)
		- JavaScript to handle posting + rendering new comment, and reporting validation or other errors to the user
	- Chat Comment
		- Render a single comment and its user
- Comment Model
- User Model

### Database Schema

- User table columns:
	- int `id`
	- varchar `username` (Assuming 25 character limit)
	- int `count_comments`
- Comments table columns:
	- int `id`,
	- int `user_id` (foreign key)
	- timestamp `timestamp`
	- text `text` (Assuming 2^16 - 1 byte limit)
