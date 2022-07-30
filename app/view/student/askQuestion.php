<?php
session_start();
require '../../helper/redirector.php';
include '../../helper/autoloader.php';
$path = '../../../';
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../config/head.php' ?>
     <title>Add Post | E Love</title>
     <link rel="stylesheet" href="<?php echo $path; ?>public/css/student/askQuestion.css?v=<?php echo time(); ?>">
     <link rel="stylesheet" href="<?php echo $path; ?>public/css/layout/questionForm.css?v=<?php echo time(); ?>">
</head>

<body>

     <?php include '../layout/header.php'; ?>

     <div class="main-sidebar-wrapper">

          <?php include '../layout/sideNavbar.php' ?>

          <main class="ask-question--main main-content">
               <h2 class="ask-question__title main-title">Add Post</h2>
               <?php include '../layout/questionForm.php' ?>
          </main>

     </div>

     <?php include '../layout/footer.php'; ?>

     <script src="<?php echo $path; ?>public/js/script.js"></script>
     <script src="<?php echo $path; ?>public/js/student/askQuestion.js"></script>
     <script src="<?php echo $path; ?>public/js/layout/questionForm.js"></script>
</body>

</html>