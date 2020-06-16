<?php
//require '../../config/keys.php';
//include '../../core/db_connect.php';
//require '../core/sessions.php';

//$content="<h1>Blog Posts</h1>";
//$stmt = $pdo->query('SELECT * FROM posts');

//while ($row = $stmt->fetch())
//{
//    $content .= "<div><a href=\"view.php?slug={$row['slug']}\">{$row['title']}</a></div>";
//}
$meta=[];
$meta['title']='Microtrain';
$meta['description']='Stuff';

$content .= <<<EOT
<div class="jumbotron">
  <h1>Hello</h1> 
</div>
EOT;


require '../core/layout.php';