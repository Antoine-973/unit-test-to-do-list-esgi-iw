#unit-test-to-do-list-esgi-iw

##Endpoints :

###create user : /user/new
```json
method : POST
body  
{  
  lastname: "",    
  firstname : "", 
  password: "",  
  email: "",
  birthdate :"" //yyyy/mm/dd
}
```

###get user : /user/{user_id}
```json
method : GET
body : none
```

###create todo list for a user : /user/{user_id}/todo-list/new
```json
method : POST
body : 
{
  name:""
}
```

###get todo list from user : /user/{user_id}/todo-list
```json
method : GET
```

###ajouter un item dans la list : /user/{user_id}/todo-list/addItem
```json
method : POST
body :
{
  name : "",
  content : ""
}
```

###get one item in todo list : /user/{user_id}/todo-list/item/{item_id}
```json
method : GET
body : none
```