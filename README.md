# severinoleague
A math competition oriented website

Link https://severinoleague.altervista.org/

# 1.Pages 

## Registration page 
For users without an account (lel), the user has to insert username (different for everyone), password and confirm password, after registration a new line is created in the database users.

Link: https://severinoleague.altervista.org/register.php


## Login page
It opens whenever a non logged in user tries to create a contest, register to a contest, submit an answer for a contest or simply login. It sends the user to the **Home page**.

Link: https://severinoleague.altervista.org/login.php

## Home page 
Here are displayed contests in the site and the ELO rank list of all participants. The first contests showed are ALL the running ones, then ALL the non started contests, then, if there aren't enough displayed contests, the remaining ones are picked from the **archive**, up to a total of 10.

Contests have a small description in the home page, that includes starting time, duration, link to the ranking, button to registration (if contest is not started, it will have a password insertion box if the contest requires it), link to the submissions page (if contest is started).

Link: https://severinoleague.altervista.org/index.php

# 2.Database

## users
In this table are saved all users info.
### id
Integer (like if we will ever have more than 30k registrations) assigned to each user, unique for everyone, a simple variable that increases by 1 each time a new registration is made.
### username
String up to 50 characters that contains the username inserted in the registration page, it must be unique for everyone.
### password
String up to 255 characters that contains an hashed string of the password inserted by user concatenated with the **salt**, the hash is made with the php function password_hash() (default hash option).
### salt
Random string of length 8 that is appended to the password inserted by the user before hashing it, used to prevent hash reversing by rainbow tables.  
### score
ELO rating of the user, it is updated each time the user competes in a rated contest using the same formula of  [codeforces](https://codeforces.com/blog/entry/20762).

## contests
In this table are saved the contests that are created in the site, we preferred using this table to store all main informations, the scoreboards are instead saved in different tables.

### id
The id number associated with the contest, unique for every contest.
### name
String up to 50 characters that contains the neme of the contest (not necessarily unique).
### password_str
String up to 50 characters that contains a non hashed password for the contest (if the creator wants to restrict the access). We considered to hash it, but then we realized that this site will not be used by many people, will it?
### created_at
A datetime variable that takes the value of the date and time when the contest is added to the database.
### n_problems
A smallint that contains the number of problems in the contest (up to 1000).
### start_time
A datetime variable that contains the starting time the creator set for the contest.
### length
A smallint that contains the length in minutes of the contest (up to 30240, 3 weeks).
### jolly_time
A smallint that contains the number of minutes that a contestant has to choose the jolly problem.
### derive (Deriva lel)
A smallint that contains the number of correct submissions from different contestants for the same problem that needs to be reached in order to stop the increment of points for that problem.
### stop_inc
A smallint that contains the time (in minutes) that needs to pass since the start of the contest in order to stop the increment of points for all problems.
### owner_id
An int that contains the id of the creator of the contest.
## scoreboard
All the scoreboards of the contests are saved in different tables with the name **scoreboard** + *contest_id* to identify each scoreboard. I this table each row contains the informations of a single contestant.
### user_id
An int that contains the id of the contestant.
### username
A String up to 50 characters that contains the username of the contestant.
### score
An int that contains the total score of the contestant as the sum of all scores of problem + the initial score, used to sort lines in database queries.
### score + *n_problem*
An int that contains the score that the user has on the problem n_number (might be negative).
# 3.Other

## Error management
Append all errors in array $err, then stamp all errors at the end.

