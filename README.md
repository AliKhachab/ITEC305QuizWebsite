# Our project

## What it was for

This project was a quiz website we were tasked to do for our final project in our Internet Programming class. We used HTML, CSS, and PHP to create a basic quiz website frontend and MySQL for the backend to store all quiz information.

If you want to view us demoing this project, please [click here](https://www.youtube.com/watch?v=O3OaLHsYLLI).

## Setup

We used PHPStorm, HTML, CSS, PHP, and MySQL for this project. If you do not have access to a way to run a MySQL project, here is a [runbook](https://docs.google.com/document/d/1itFSaInpJJfDxH6B7g8i1mY5333OUUlOFSx6d5sj_jc/edit?tab=t.0) by Ali on how to set up LAMP (Linux, Apache, MySQL, PHP). Note that you do not need Linux to run the code, but be sure you at least install MySQL on whatever OS you have and can get it working.   
Once that is done, BEFORE YOU DO ANYTHING, be sure you create the database in our quiz.sql file. You can copy paste the code into the MySQL terminal, or (if you have PHPStorm/another code editor that can run MySQL code), run the quiz.sql file directly in the code editor you are using. The code will only run if you get the database running, otherwise you will get database errors because you did not create the database. You can edit the config.php file to have your MySQL username and password if you need to, but we used “root” for the user with no password (as in, literally an empty string) that had access privileges to all of our databases by default.

## How we split up the work

For this project, we decided it would be good practice if we could focus on things we usually do not work while developing. We all worked to a great extent on certain screens, but since most of them were based on homework assignments we already did prior, once those were done, we decided to focus on our weak points as programmers for practice. This means Ali did a lot more database related code, while Alan and David did more frontend related code once we got our sections of the work done, since Ali had more experience as a frontend developer prior to this semester while David and Alan were more used to programming backend-related features. More will be explained below.

## The screens and who did what

### 1\) index.php, home.php, and register.php (landing and auth screens) – Ali (HTML, PHP, some CSS) and David (CSS)

The landing page, index.php, is the first page the user will be introduced to when they open the web app. The page has two buttons, leading to a register and login page. These were based on the homework assignments/in-class code we did testing out creating login and register features manually, using MySQL to store user data.

We decided to go with a sunset color scheme featuring colors like orange and light pink. We used a container to hold the login and a register button stacked vertically, surrounded by a white border for cleaner visibility. Bootstrap classes such as d-grid will allow us to stack these buttons with a grid system and the gap class was added to space these buttons slightly. If the user is already logged in, the $\_SESSION superglobal array will hold that they are still logged in ($\_SESSION\[‘loggedin’\] \= true), and upon clicking login, will be routed straight to home.php. For the CSS in index.php and the authentication pages, we decided to use a background image instead of a solid plain color background to relate to one of the quizzes we had, the Pokemon quiz. Above the section containing our navigation buttons is the title of our website, TriviaCentral.

Login and registration work as you’d expect – there is a users table in the MySQL database which will be queried against to check if the user is making valid registration/log-in attempts, assuming they can get past the PHP constraints first (i.e. password has more than 8 characters). The bulk of this code was taken straight from our homework assignment pertaining to logging in and registration, but we modified it to match our table in the database. Registration will check if a user exists, the passwords match, and the password is valid – if everything works, the user will make their account and be redirected to the login screen. Logging in requires the user to insert their username and password, and if the password hash matches the one stored in the database, then they are logged in (as mentioned above with the $\_SESSION array) and allowed to go straight to home.php. All pages listed below have a session\_start() above all other code to ensure this variable is passed through all pages.

### 2\) home.php (screen where you select your quizzes) \- Ali (HTML, PHP to create the buttons and route to quiz) and David (PHP to handle POST requests, CSS)

For reference, this is our “quizSelect”. The $\_SESSION superglobal array variable is used to ensure the status of the user being logged in, as mentioned in the above section. We used a SQL query to dynamically fetch all quiz information from the database and link them to the cards containing their information specifically via an associative array. This way, if we added another quiz, we did not need to change any PHP code – just the database itself. 

For the HTML components, we added a red logout button that would be located on the top right of the page for users to log out of their accounts. This page is easily navigable to, as once the user completes a quiz, they can head back to home.php whenever they want. We then added a heading prompt which tells users to choose their quiz. As said above, we used a dynamically sized array to display cards only based on the number of quizzes that exist in the database. We kept the CSS styling on this page consistent, using Bootstrap to keep the same feel of the CSS throughout the navigation.

### 3\) Database – Ali (everything but INSERT INTO (questions and answers)), David (creating questions and answers)

We used a MySQL relational database to hold all information. The following explanation will not be talking about IDs unless needed to or as a foreign key, as they all have IDs as primary keys (except for the scores table):

- The users table holds all relevant user data like the hashed password, id, and username. The id is carried around the session for easy queries later on.
- The quizzes table holds the quiz name to easily relate them to their navigation buttons on the home.php screen.
- The questions table holds all of the question text and the quiz ID that it relates to (ID 1 being capitals and 2 being Pokemon).
- The answers table holds all of the answers for each question and relates themselves to each question via the question’s ID. It also holds an int (1 or 0\) where 1 is true and 0 is false to indicate correct answers. We have 3 answers for each question.
- The score table has a composite primary key of user ID and quiz ID, since both the user’s ID and the ID of the quiz they took is a unique identifier for all other columns in the table. We do not add more user scores depending on if they take the quiz numerous times, but rather update the table based on whether or not they get a better score (if no score in the table, then we put their first score in – otherwise, update their score if they have a new high score).

### 4\) leaderboard.php – Alan (HTML, CSS, PHP)

A huge inspiration was taken from a homework assignment where we used Bootstrap for CSS and Postman to take fake JSON data and link it to users on a screen. Alan was able to modify it originally by using seeding data (fake data) to display the top 10 users with the highest scores.  Displaying the ranking, name, and score for the respective leaderboard.

We decided to approach the extra credit portion of this assignment and provide a leaderboard page to display users' high scores. This PHP file displays two separate leaderboards for each of the quizzes, displaying what the users scored for the two quizzes (Pokémon and Capitals). We start off by joining the scores, users, and quiz tables in order to select scores in descending order. After running the query, we store the results temporarily to display later. We used bootstrap tables to display the data collected with our query. We used a loop to display each user's result in a row, separated by username, quiz name, and their respective score.   
You can also choose to take another quiz at the bottom of the page.

### 5\) quiz.php – Ali (PHP for linking to database to get quiz questions),  Alan(Displaying the questions/answers and sending info to result.php)(HTML, PHP/HTML to create the quiz itself, CSS)

The reason why you came to use this website in the first place. This page dynamically gets quiz information based on what the user clicked and sends it through a POST request in the home.php page. If the user clicks the capitals quiz, the POST request sends an ID of 1, which is used to get all the questions from quiz 1 (the capitals quiz questions stored in the database) and relate them to all the answers thanks to the foreign key question\_id that the answers table uses. The same applies to ID 2 and the Pokémon trivia quiz. There are 15 questions for each quiz, and the user can answer the randomly selected 10 questions based on the three answers each question has. The user must complete the quiz to go to the results.php page, which carries all of the quiz information (the question information and how they were answered) in the $\_POST superglobal array.

### 6\) results.php – Ali (update table for user’s score SQL code), Alan (everything else)

Results.php receives all of the information through the form on quiz.php, then takes that information to be displayed. The code first checks through the array of all questions that were asked and the answers the user gave, cross-referencing the database to determine if the answers were correct or incorrect. It then marks them as correct or incorrect and displays that to the user, counting the number of correct answers, displaying a percentage score of your quiz once you finish, as well as showing what answer you chose and what the correct answer was if you chose wrong. This is also where the code will take the user’s score and update the scores table accordingly. If the user has had no score before for this quiz, it will give them a new row in the table. If the user has taken this quiz before, it will update the table with their new score if that score is higher than their previous one, otherwise, nothing happens.  
At the bottom of the page, you can also navigate to take another quiz or go straight to the leaderboard to see the top 10\.
