<?php
require '../../core/functions.php';
require '../../config/keys.php';
require '../../core/db_connect.php';
//require '../../core/sessions.php';
//checkSession();

$message=null;

$args = [
    'first_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'last_name'=>FILTER_SANITIZE_STRING, //strips HMTL	    
    'email'=>FILTER_SANITIZE_EMAIL,	    
    'password'=>FILTER_UNSAFE_RAW
    //'title'=>FILTER_SANITIZE_STRING, //strips HMTL
    //'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
    //'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
    //'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    //Strip white space, begining and end
    $input = array_map('trim', $input);

    //Allow only whitelisted HTML
    //$input['body'] = cleanHTML($input['body']);

    //Create the slug
    //$slug = slug($input['title']);

    //Sanitiezed insert
    $sql = 'INSERT INTO users SET id=uuid(), first_name=?, last_name=?, email=?';

    if($pdo->prepare($sql)->execute([
        $input['first_name'],
        $input['last_name'],
        $input['email']
        //$hash
    ])){
       header('LOCATION:/example.com/public/users/view.php?email=' . $input['email']);
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Add a New user</h1>
{$message}
<form method="post">

<div class="form-group">
    <label for="first_name">First name</label>
    <input id="first_name" name="first_name" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="last_name">Last name</label>
    <input id="first_name" name="last_name" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input id="email" name="email" type="text" class="form-control">
</div>

   
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;

//include '../../core/layout.php';
require '../../core/layout.php';