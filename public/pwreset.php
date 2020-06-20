<?php
require '../core/db_connect.php';
require '../core/functions.php';
require '../core/sessions.php';
require '../config/keys.php';
require '../vendor/autoload.php';

use Mailgun\Mailgun;

$message = null;

$input = filter_input_array(INPUT_POST,['email'=>FILTER_SANITIZE_EMAIL]);
$email = $input[email];

// $get = filter_input_array(INPUT_POST);
// $email = $get['email'];

if(!empty($input)){

    // 4. Query the database for the requested user
    $input = array_map('trim', $input);
    //$sql='SELECT id, hash FROM users WHERE email LIKE ".$input[email]"';
    $sql="SELECT id, hash FROM users WHERE email=:email";
    $stmt=$pdo->prepare($sql);
    // $stmt->execute([
    //     'email'=>$input['email']
    //     //'email' => $email
    //     ]);
    $stmt->execute(['email'=> $email]);
    $row=$stmt->fetch();

    

    if($row){
        echo 'user found';
        // function random_password( $length = 8 ) {
        //     $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        //     $password = substr( str_shuffle( $chars ), 0, $length );
        //     return $password;
        // }
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, 8 );
     
        //sleep(10);

        $mgClient = Mailgun::create(MG_KEY,MG_API); //MailGun key 
        $domain = MG_DOMAIN; //API Hostname

        $from = "Mailgun Sandbox <postmaster@{$domain}>";
        $text = 'Congratulations  password reset completed new password is: ' . $password;

        $result = $mgClient->messages()->send($domain,
        array   (  
                    'from'    => $from,      
                    'to'      => 'soboli <soboli2c@comcast.net>',
                    'subject' => 'Password reset',
                    'text'    => $text
                )
            );   
        header('Location: /example.com/public/login.php');
        }
          else {
            echo 'Email doesnt exist';
            echo $email;
          }
}

$meta=[];
$meta['title']="Password Reset";

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
    
    <input type="submit" class="btn btn-primary">
</form>
EOT;

require '../core/layout.php';