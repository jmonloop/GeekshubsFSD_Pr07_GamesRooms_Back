# LFG Web Application Backend
This is my seventh project of GeeksHubs Academy FSD bootcamp.

The objective is to create an API restful backend simulating a "Look For Group" application like GamerLink or Discord.


[Architecture](#architecture)
    
[Installation](#installation)

[How to test the project](#how-to-test-the-project)

[Endpoints](#endpoints)

[Thanks](#thanks)




## Architecture

The database has 5 tables:

    1 Users: User profiles. Related:
        One-To-Many with Memberships table
        One-To-Many with Messages table

    2 Parties: The different groups of Users for the games. Related:
        One-To-Many with Memberships table
        Many-To-One with Games table

    3 Memberships: Relational table between Users and Parties.

    4 Games: Each game that contains different Parties. Related:
        One-To-Many with Parties table

    5 Messages: The messages that Users send into each Party. Related:
        Many-To-One with Users table
        Many-To-One with Parties table

![ScreenShot](https://raw.githubusercontent.com/jmonloop/GeekshubsFSD_Pr07_GamesRooms_Back/dev/resources/screenshots/relations.jpg)



## Installation
The project is fully deployed in Heroku server so you only need to download Postman application for testing it.

### Postman
1 Download and install [Postman](https://www.postman.com/downloads/)

2 Download the file ..resources/postman/gamesRoom Laravel.postman_collection.json from this respository

3 Open Postman and click on Import
![ScreenShot](https://raw.githubusercontent.com/jmonloop/GeekshubsFSD_Pr04_VideoStoreBackend/master/assets/postman_import.jpg)

4 Upload gamesRoom Laravel.postman_collection.json file and Import it

5 Expand the new videoStore tab and all the endpoints will be shown



## How to test the project 
In Postman, select the request you want to test from videoStore collection, configure the inputs if needed and click "Send".

You can also do it manually: select CRUD method, copy the endpoint URL, configure inputs if needed and click "Send".


### Token requests
* As Json Web Token authentication has been used, there are some requests that need a token to be present in header to authenticate that the user has been logged in. If you try to send this request without being login first, the request will not take place and an "Unauthorized" message will be shown.


To execute this type of requests you need to:

    1. Request login with a valid user and password registered in DB
    2. Copy the token responsed by Postman excluding the ""
    3. In the request which needs authetication, go to "Authorization", click in "Type" tab 
    and select "Bearer Token" option.
    4. Paste the token in the field.
    5. Send request
![ScreenShot](https://raw.githubusercontent.com/jmonloop/GeekshubsFSD_Pr04_VideoStoreBackend/master/assets/postman_auth.jpg)


### Admin role requests
* There is another type of request in which you need to be logged with an "isAdmin" role user profile for being executed.
* For that requests you only need to login with that user and copy the token in the autorization field. 


## Endpoints

* [USERS](#users)

* [PARTIES](#parties)

* [GAMES](#games)

* [MEMBERSHIPS](#memberships)

* [MESSAGES](#messages)


## USERS
### REGISTER

    https://games-rooms.herokuapp.com/api/register (post)

    Body example:
    {
        "nickname": "javi",
        "email": "javi@gmail.com",
        "password": "1234"
    }

### LOGIN

    https://games-rooms.herokuapp.com/api/login (post)

    {
        "email": "javi@gmail.com",
        "password": "1234"
    }

### UPDATE USER

    https://games-rooms.herokuapp.com/api/users/<userID> (put)

    {
        "email": "javiMOD@gmail.com"
    }

### DELETE USER

    https://games-rooms.herokuapp.com/api/users/<userID> (delete)


### GET ALL USERS

    https://games-rooms.herokuapp.com/api/users (get)

### GET USER BY ID

    https://games-rooms.herokuapp.com/api/users/<userID> (get)


## PARTIES

### CREATE PARTY

    https://games-rooms.herokuapp.com/api/parties (post)

    {
        "title": "test",
        "game_id": 11,
        "ownerNickname":"test",
        "private":true,
        "password":"1234"
    }

### GET PARTY BY ID

    https://games-rooms.herokuapp.com/api/parties/<partyID> (get)

### GET ALL PARTIES

    https://games-rooms.herokuapp.com/api/parties (get)

### GET PARTIES BY USER NICKNAME

    https://games-rooms.herokuapp.com/api/parties/getByUser/<userNickname> (get)

### GET PARTIES BY GAME ID

    https://games-rooms.herokuapp.com/api/parties/getByGame/<gameID> (get)

### UPDATE PARTY

    https://games-rooms.herokuapp.com/api/parties/getByGame/<partyID> (put)

    {
    "title": "testMOD",
    "ownerNickname": "another"
    }

### DELETE PARTY

    https://games-rooms.herokuapp.com/api/parties/<partyID> (delete)


## GAMES

### CREATE GAME

    https://games-rooms.herokuapp.com/api/games (post)

    {
        "title": "GTA 5",
        "image": "https://fakeimgurl.com"
    }

### GET GAME BY ID

    https://games-rooms.herokuapp.com/api/games/<gameID> (get)

### GET ALL GAMES

    https://games-rooms.herokuapp.com/api/games (get)

### UPDATE GAME

    https://games-rooms.herokuapp.com/api/games/<gameID> (put)

    {
    "image": "https://fakeimgurlMOD.com"
    }

### DELETE GAME

    https://games-rooms.herokuapp.com/api/games/<gameID> (delete)


## MEMBERSHIPS

### CREATE MEMBERSHIP

    https://games-rooms.herokuapp.com/api/memberships (post)

    {
        "user_id":51,
        "party_id":11
    }

### GET ALL MEMBERSHIPS

    https://games-rooms.herokuapp.com/api/memberships (get)

### GET MEMBERSHIPS BY USER ID

    https://games-rooms.herokuapp.com/api/memberships/user/<userID> (get)

### GET MEMBERSHIPS BY PARTY ID

    https://games-rooms.herokuapp.com/api/memberships/party/<partyID> (get)

### GET MEMBERSHIP BY ID

    https://games-rooms.herokuapp.com/api/memberships/<partyID> (get)

### DELETE MEMBERSHIP

    https://games-rooms.herokuapp.com/api/memberships/<partyID> (delete)


## MESSAGES

### CREATE MESSAGE

    https://games-rooms.herokuapp.com/api/messages (post)

    {
        "party_id":11,
        "user_id":51,
        "text":"I am the message content"
    }

### GET MESSAGE BY ID

    https://games-rooms.herokuapp.com/api/messages/<messageID> (get)

### GET ALL MESSAGES

    https://games-rooms.herokuapp.com/api/messages (get)

### UPDATE MESSAGE

    https://games-rooms.herokuapp.com/api/messages/<messageID> (put)

### DELETE MESSAGE

    https://games-rooms.herokuapp.com/api/messages/<messageID> (delete)


## Thanks

* Thanks to GeeksHubs Academy for the training received (https://github.com/GeeksHubsAcademy)

* Thanks to everyone who spends time spreading their knowledge in Stack Overflow.

* Created by Javier Monleón López (https://github.com/jmonloop)


