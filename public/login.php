<?php
//require '../bootstrap.php';
// 1. Connect to the database
require '../core/db_connect.php';
require '../core/functions.php';
require '../core/sessions.php';



// 2. Filter the user inputs
$input = filter_input_array(INPUT_POST,[
    'email'=>FILTER_SANITIZE_EMAIL,
    'password'=>FILTER_UNSAFE_RAW
]);

// 3. Check for a POST request
if(!empty($input)){

    // 4. Query the database for the requested user
    $input = array_map('trim', $input);
    $sql='SELECT id, hash FROM users WHERE email=:email';
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        'email'=>$input['email']
    ]);
    $row=$stmt->fetch();
    $selected=$stmt->rowCount();
    // echo $selected; //print("Selected $selected rows");
    // echo $row['hash'];
    // echo $input['password'];

    $message = null;

    if($row){
        // 5. Attempt a password match
        $match = password_verify($input['password'], $row['hash']);
        if($match){
            // 6.1 Set a session
            $_SESSION['user'] = [];
            $_SESSION['user']['id']=$row['id'];
            $message = 'Logon successful';

            // 6.2 Redirect the user
            //header('Location: /example.com/public/users/');header('LOCATION: ' . $_POST['goto']);
            header('Location: /example.com/public/index.php');
        }
          else {
            echo 'Login fail';
          }
    }
}
$meta=[];
$meta['title']="Login";
echo $message; 

$content=<<<EOT
<h1>{$meta['title']}</h1>
 {$message}
<form method="post" autocomplete="off">
    <div class="form-group">
        <label for="email">Email</label>
        <input 
            class="form-control"
            id="email"
            name="email"
            type="email"
        >
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="password" 
            type="password"
        >
    </div>
    <input type="submit" class="btn btn-primary">
    
</form>
    <div>
    <form action = "pwreset.php">
       <input type="submit" value="Reset password" class="btn btn-primary">
    </form>
    </div>
EOT;
 echo $message; 
require '../core/layout.php';