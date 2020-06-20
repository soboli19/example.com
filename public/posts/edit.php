<?php
require '../../core/functions.php';
require '../../config/keys.php';
require '../../core/db_connect.php';
//checkSession();

$get = filter_input_array(INPUT_GET);
$id = $get['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=:id");
$stmt->execute(['id'=>$id]);
$row = $stmt->fetch();

if(empty($row)){
     http_response_code(404);     //If id can not be found
     die('Page Not Found <a href="/">Home</a>');
   }

   $meta=[];
   $meta['title']= "Edit: {$row['title']}";
   $message=null;

 $args = [
     'id'=>FILTER_SANITIZE_STRING, //strips HMTL
     'title'=>FILTER_SANITIZE_STRING, //strips HMTL
     'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
     'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
     'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
  ];

   $input = filter_input_array(INPUT_POST, $args);

   if(!empty($input)){

     //Strip white space, begining and end
    $input = array_map('trim', $input);

     //Allow only whitelisted HTML
     $input['body'] = cleanHTML($input['body']);

     //Create the slug
     $slug = slug($input['title']);

     $sql = 'UPDATE  posts
     SET title=:title,
     slug=:slug,
     body=:body,
     meta_description=:meta_description,
     meta_keywords=:meta_keywords
     WHERE id=:id';


//     //Sanitiezed insert
//     //$sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';
//     //  $sql = 'UPDATE  posts SET  title=title, slug=slug, body=body  WHERE id=:id';

     if($pdo->prepare($sql)->execute([
         $input['title'],
         $slug,
        $input['body'],
         $input['meta_description'],
         $input['meta_keywords'],
         $input['id']
     ])){
        header('LOCATION:view.php?slug='. $row['slug']);
     }else{
         $message = 'Something bad happened';
    }
 }

 $content = <<<EOT
 <h1>EDIT: {$row['title']}</h1>

 {$message}
 <form method="post">
     <input id="id" name="id" value="{$row['id']}" type="hidden">

    <div class="form-group">
        <label for="title">Title</label>
        <input id="title" value="{$row['title']}" name="title" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea id="body" name="body" rows="8"
        class="form-control"
        >{$row['body']}
        </textarea>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="meta_description">Description</label>
            <textarea id="meta_description" name="meta_description" rows="2"
            class="form-control"
            >{$row['meta_description']}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="meta_keywords">Keywords</label>
            <textarea id="meta_keywords" name="meta_keywords" rows="2"
            class="form-control"
            >{$row['meta_keywords']}</textarea>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" class="btn btn-primary">
        <br><br>
        <input type="reset" value="Reset" class="btn btn-secondary">
    </div>
</form>
EOT;

include '../../core/layout.php';