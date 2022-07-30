<?php
session_start();
require '../../helper/redirector.php';
include '../../helper/autoloader.php';
$path = '../../../';

$user = new Controller\User();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../config/head.php' ?>
     <title>Chat | E Love</title>
     <link rel="stylesheet" href="<?php echo $path; ?>public/css/student/chat.css?v=<?php echo time(); ?>">
</head>

<body>

     <?php include '../layout/header.php'; ?>

     <div class="main-sidebar-wrapper">

          <?php include '../layout/sideNavbar.php' ?>

          <main class="chat--main main-content">
               <section class="chat-section__chat-area">
                    <div class="chat-section__chat-area-header">
                         <button class="chat-section__back-btn">
                              <i class="fa-solid fa-arrow-left"></i>
                         </button>
                         <img class="chat-section__chat-area-header-img chat-profile-img" src="<?php echo $path; ?>public/img/profile1.jpg">
                         <h2 class="chat-section__chatting-username"></h2>
                    </div>
                    <div class="chat-section__chat-box " id="chat">


                    </div>
                    <form class="chat-section__typing-form" autocomplete="off">
                         <input class="chat-section__typing-box" type="text" name="msgContent" placeholder="Type your message here...">
                         <button class="chat-section__send-msg-btn" data-sender-id="<?php echo htmlspecialchars($_SESSION['userId']) ?>">
                              <i class=" chat-section__send-msg-icon fab fa-telegram-plane"></i>
                         </button>
                    </form>
               </section>
               <section class="chat-section__user-list">
                    <div class="chat-section__user-search-wrapper">
                         <input class="chat-section__user-search-bar" type="text" placeholder="Search user" autocomplete="off">
                         <button class="chat-section__user-search-btn" type="submit">
                              <i class="fas fa-search"></i>
                         </button>
                    </div>
                    <div class="chat-section__user-container">

                    </div>
               </section>
          </main>

     </div>

     <script src="<?php echo $path; ?>public/js/script.js"></script>
     <script src="<?php echo $path; ?>public/js/student/chat.js"></script>
</body>

</html>