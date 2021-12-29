# unit-test-to-do-list-esgi-iw

## Get Started :

### Initialize the project :

```bash
docker-compose build --pull --no-cache
docker-compose up -d
docker-compose exec php php bin/console d:s:u --force
```

### Run tests
```bash
# run all tests of the application
php ./vendor/bin/phpunit

# run all tests in the Form/ directory
php ./vendor/bin/phpunit tests/Form

# run tests for the UserController class
php ./vendor/bin/phpunit tests/Controller/UserControllerTest.php
```

## Endpoints :

### create user : /user/new
method : POST  
```json
{  
  "lastname": "",    
  "firstname" : "", 
  "password": "",  
  "email": "",
  "birthdate" :"yyyy/mm/dd"
}
```

### get user : /user/{user_id}
method : GET
```json
"body" : "none"
```

### create todo list for a user : /user/{user_id}/todo-list/new
method : POST
```json
{
  "name":""
}
```

### get todo list from user : /user/{user_id}/todo-list
method : GET
```json
"body" : "none"
```

### add item in a list : /user/{user_id}/todo-list/addItem
method : POST
```json
{
  "name" : "",
  "content" : ""
}
```

### get one item in todo list : /user/{user_id}/todo-list/item/{item_id}
method : GET
```json
"body" : "none"
```
