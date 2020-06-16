<!-- Set session in php -->
<?php
function active($name){
  $current = $_SERVER['REQUEST_URI'];
  if($current === $name){
    return 'active';
  }

  return null;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
      <!-- Add sanitized content -->
        <?php if(!empty($meta)): ?>

        <?php if(!empty($meta['title'])): ?>
        <title><?php echo $meta['title']; ?></title>
        <?php endif; ?>

        <?php if(!empty($meta['description'])): ?>
        <meta name="description" content="<?php echo $meta['description']; ?>">
        <?php endif; ?>

        <?php if(!empty($meta['keywords'])): ?>
        <meta name="keywords" content="<?php echo $meta['keywords']; ?>">
        <?php endif; ?>

        <?php endif; ?>
        <!-- End sanitized content -->
      <meta charset="UTF-8">
      <title>About me</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" type="text/css" href="/example.com//public/dist/css/main.min.css">
  </head>
  <body>
   
        <header>
                <a id="toggleMenu">Menu<a>
                <span class="logo">My WebSite</span>
            <nav>
                    <!--<a href="index.html" class="logo" href="/">Site Logo</a> -->
                <ul role="navigation">
                    <li><a href="../public/index.php">Home</a></li>
                    <li><a href="resume.php">Resume</a></li>
                    <li><a href="contact.php">Contact</a></li>
                  <li><a  href="../public/logout.php">Logout</a></li>
                    <li><a  href="../public/login.php">Login</a></li>
                    <li><a href="../public/register.php">Register</a></li> 
                </ul>
            </nav>  
        </header>
        <div id="Wrapper">    

        <div class="row">
            <div id="Content">
                <?php echo $content; ?>
            </div>
            <!-- <div id="Sidebar">
              <div id="AboutMe">
                <div class="header">Hello, I am Iliya Sobolev</div>
                <img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" class="img-circle">
              </div>
            </div>
        </div> -->

        <div id="Footer" class="clearfix">
            <small>&copy; 2020 - MyAwesomeSite.com</small>
            <ul role="navigation">
                <li><a href="terms.html">Terms</a></li>
                <li><a href="privacy.html">Privacy</a></li>
            </ul>
        </div>
  </div>
  <script>
  var toggleMenu = document.getElementById('toggleMenu');
  var nav = document.querySelector('nav');
  toggleMenu.addEventListener(
    'click',
    function(){
      if(nav.style.display=='block'){
        nav.style.display='none';
      }else{
        nav.style.display='block';
      }
    }
  );
</script>       
</body>
</html>