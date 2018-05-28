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
	- Assuming 1000 character limit for now
- User sees their question at the top of the list of comments
	- Nice To Have:
		- They see their post without reloading
		- User can see which posts are responding to which questions
		- They see the reply without reloading

## Architecture

#### Using Laravel 5.6
#### Using Homestead 7.6.2

There will be a:
- Chat Controller
	- Method to load the view with initial comments data from the model
	- Method where new comments are posted, along with usernames, and sent to the model
		- Returns formatted comment just posted using view method for comment html
	- Method to create new user using User Model
	- Method to create new comment linked to newly-created user or existing user using Comment model, while incrementing the count in the User model
- Chat View
	- Method to load the HTML used to structure the comments and the javascript to handle page actions, ie validation
	- Loads form elements and javascript used to post new comments via ajax to controller then update the page
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
	- (TODO varchar or text) `text` (Assuming 1000 character limit)
