<?php
session_start();
require '../../helper/redirector.php';
include '../../helper/autoloader.php';
$path = '../../../';

$question = new \Controller\Question();
$questionInfo = isset($_GET['id']) ? $question->read($_GET['id'])[0] : null;
$answer = !empty($_POST) ? new \Controller\Answer($_POST) : new \Controller\Answer();
$user = new \Controller\User();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../config/head.php' ?>
     <title><?php echo htmlspecialchars($questionInfo['title']); ?> | E Love</title>
     <link rel="stylesheet" href="<?php echo $path; ?>public/css/student/question.css?v=<?php echo time(); ?>">
     <link rel="stylesheet" href="<?php echo $path; ?>public/css/layout/sidebar.css?v=<?php echo time(); ?>">
</head>

<body>

     <?php include '../layout/header.php'; ?>

     <div class="main-sidebar-wrapper">

          <?php include '../layout/sideNavbar.php' ?>

          <main class="question--main main-content">

               <!-- Question Content -->
               <h2 class="question__title main-title"><?php echo htmlspecialchars($questionInfo['title']); ?></h2>
               <div class="question__user">
                    <img class="question__user-profile-img" src="../../../public/img/profile1.jpg" alt="Profile Image">
                    <div class="question__user-info">
                         <h3><?php echo htmlspecialchars($questionInfo['username']); ?></h3>
                         <p><?php echo htmlspecialchars($question->get_time($questionInfo['time_posted'])); ?></p>
                    </div>
               </div>
               <p class="question__content">
                    <?php echo htmlspecialchars($questionInfo['content']); ?>
               </p>

               <!-- Question Action -->
               <div class="question__action-container">
                    <div class="question__action question__action--vote" data-vote-id="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                         <i class="vote-icon fa-solid fa-arrow-up fa-lg" id="upvote"></i>
                         <p class="question__point">
                              <?php echo htmlspecialchars($questionInfo['point']); ?>
                         </p>
                         <i class="vote-icon fa-solid fa-arrow-down fa-lg" id="downvote"></i>
                    </div>
                    <div class="question__action question__action--comment" data-reply-id="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                         <i class="action--comment-icon fa-solid fa-comment"></i>
                         <p>Comment</p>
                    </div>
                    <?php if ($_SESSION['userId'] == $questionInfo['user_id']) : ?>
                         <a class="question__action question__action--edit" href="<?php echo htmlspecialchars("editQuestion.php?id=" . $questionInfo['question_id']); ?>">
                              <i class="action--edit-icon fa-solid fa-edit"></i>
                              <p>Edit</p>
                         </a>
                         <div class="question__action question__action--delete" onclick="confirmDeletion('<?php echo htmlspecialchars($questionInfo['question_id']); ?>')">
                              <i class="action--delete-icon fa-solid fa-trash-can"></i>
                              <p>Delete</p>
                         </div>
                    <?php endif; ?>
                    <div class="question__action question__action--bookmark" data-bookmark-id="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                         <i class="action--bookmark-icon fa-solid fa-bookmark"></i>
                         <p>Save</p>
                    </div>
                    <?php
                    // Check if the user has already answer the question.
                    $isAnswered = false;
                    $viewAnsLink = '../student/question.php?id=' . $questionInfo['question_id'] . '#';

                    $answersInfo = $answer->read($questionInfo['question_id']);

                    foreach ($answersInfo as $answerInfo) {

                         if ($answerInfo['user_id'] == $_SESSION['userId']) {
                              $viewAnsLink .= $answerInfo['answer_id'];
                         }

                         $userInfo = $user->read($answerInfo['user_id']);
                         if ($userInfo['user_id'] == $_SESSION['userId']) {
                              $isAnswered = true;
                         }
                    }
                    ?>
<!--                     
                    <?php //if ($_SESSION['userId'] != $questionInfo['user_id']) : ?>
                         <?php //if (!$isAnswered) : ?>
                              <div class="question__action question__action--ans">
                                   <i class="action--ans-icon fa-solid fa-pen"></i>
                                   <p>Comment</p>
                              </div>
                         <?php //elseif ($isAnswered) : ?>
                              <a class="question__action question__action--view-ans" href="<?php //echo $viewAnsLink; ?>">
                                   <i class="action--view-ans-icon fa-solid fa-user-pen"></i>
                                   <p>My Answer</p>
                              </a>
                         <?php //endif; ?>
                    <?php //endif; ?> -->
               </div>

               <!-- Post answer for question -->
               <?php if ($_SESSION['userId'] != $questionInfo['user_id']) : ?>
                    <form class="question__post-ans-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . $questionInfo['question_id']) ?>" method="POST">
                         <textarea class="question__post-ans-input" name="ansContent" placeholder="Type here to answer <?php echo htmlspecialchars($questionInfo['username']); ?> ..."></textarea>
                         <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_SESSION['userId']); ?>">
                         <input type="hidden" name="questionId" value="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                         <div class="post-ans__btn-container">
                              <button class="question__cancel-ans-btn" type="button">Cancel</button>
                              <button class="question__post-ans-btn" name="postAns" type="submit">Post Answer</button>
                         </div>
                    </form>
               <?php endif; ?>

               <!-- Comments of the question -->
               <div class="question__comment-container--question">

               </div>

               <!-- Add comment for question -->
               <form class="question__add-comment-form" data-comment-id="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                    <textarea class="question__add-comment-input" name="content" placeholder="Add a comment ..."></textarea>
                    <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_SESSION['userId']); ?>">
                    <input type="hidden" name="replyId" value="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                    <div class="add-comment__btn-container" data-reply-id="<?php echo htmlspecialchars($questionInfo['question_id']); ?>">
                         <button class=" question__cancel-comment-btn" type="button">Cancel</button>
                         <button class="question__add-comment-btn" name="addComment" type="submit">Add comment</button>
                    </div>
               </form>

          </main>

          <?php include '../layout/sidebar.php'; ?>

     </div>

     <?php include '../layout/footer.php'; ?>

     <script src="<?php echo $path; ?>public/js/script.js"></script>
     <script src="<?php echo $path; ?>public/js/student/question.js"></script>
</body>

</html>