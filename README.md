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
Integer assigned to each user, unique for everyone, a simple variable that increases by 1 each time a new registration is made.
### username
String up to 50 characters that contains the username inserted in the registration page, it must be unique for everyone.
### password
String up to 255 characters that contains an hashed string of the password inserted by user concatenated with the **salt**, the hash is made with the php function password_hash() (default hash option).
### salt
Random string of length 8 that is appended to the password inserted by the user before hashing it, used to prevent hash reversing by rainbow tables.  
### score
ELO rating of the user, it is updated each time the user competes in a rated contest using the same formula of  [codeforces](https://codeforces.com/blog/entry/20762).
# 3.Other

## Error management
Append all errors in array $err, then stamp all errors at the end.

