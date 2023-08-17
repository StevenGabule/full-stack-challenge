# Otto Code Challenge
This coding challenge is designed to test your ability to work with the following skills:

- Git
- Docker
- PHP
- PHP PDO
- SQL
- Front end design

**Part 0**
Setup and run the docker container locally

**Part 1**
Within the `Challenge` class there are several empty method bodies and some comments detailing
what each method should do. There are a few unit tests included in this repo which will double 
check your code to make sure it fulfills the criteria.

**Part 2**
Using CSS and Javascript, rewrite and redesign the basic html view (localhost:8080) that currently displays basic 
database info. The new html view should allow a user to sort, search and filter the data which is 
displayed. Points will be given to the best looking and most extensive UI. You may use external css and js libraries.

Once you've finished and you're confident you have completed the code challenge create a pull
request with all of your code and reply to the email which asked you to complete the challenge with a link 
to your pull request. We'll check it over and get back to you with some feedback.

**Part 3 Bonus**
Comment something positive on someone else's pull request.

## Setup

1. Clone this repository
2. Review setup docker container section
3. View http://localhost:8080/

## Docker

### Setup

**Copy config files**

```
cp .env.example .env
cp config/database.config.php.dist config/database.config.php
```

**Set environment variables**

Double check .env and database config to make sure all variables are set.

### Start

**Run the php server and the mysql db**

```
docker-compose up -d
```

**Optionally also run phpmyadmin**

```
docker-compose --profile full up -d
```

### Run Tests

```
docker exec -it otto-demo composer run-script test
```

### Remove Docker Container (Optional Clean Up)

To remove the container and images run this command:

```
docker kill otto-admin otto-db otto-demo && docker rm  otto-admin otto-db otto-demo && docker rmi otto-demo-img:latest
```
