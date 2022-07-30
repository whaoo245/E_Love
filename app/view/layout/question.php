<?php
$questions = new \Controller\Question();
$answer = new \Controller\Answer();
$timestamp = $questions->get_time($question['time_posted']); ?>
<article class="layout__question dialog">
     <div class="layout__question-vote-container" data-question-id="<?php echo htmlspecialchars($question['question_id']); ?>">
          <i class="layout__question-vote fa-solid fa-arrow-up fa-lg up" id="upvote"></i>
          <p class="layout__question-point" id="vote"><?php echo htmlspecialchars($question['point']); ?></p>
          <i class="layout__question-vote fa-solid fa-arrow-down fa-lg down" id="downvote"></i>
     </div>
     <div class="layout__question-header">
          <h3 class="layout__question-title">
               <?php echo htmlspecialchars($question['title']); ?>
          </h3>
          <?php if ($_SESSION['userId'][0] == "A") { ?>
                    <button class="layout__question-remove-btn" onclick="confirmDeletion('<?php echo htmlspecialchars($question['question_id']); ?>')">Remove</button>
               <?php } ?>
     </div>

     <a class="layout__question-body" href="../student/question.php?id=<?php echo htmlspecialchars($question['question_id']); ?>">
          <p class="layout__question-content"><?php echo htmlspecialchars($question['content']); ?></p>
     </a>

     <p class="layout__question-tag"><?php echo htmlspecialchars($question['tag']); ?></p>

     <div class="layout__question-footer">
          <div class="layout__question-poster">
               <img class="layout__question-profile-img profile-icon" src="../../../public/img/profile1.jpg" alt="Profile Image">
               <p class="layout__question-post-info">
                    <span class="layout__question-posted-by">Posted by</span>
                    <a class="layout__question-username" href="../student/profile.php?id=<?php echo htmlspecialchars($question['user_id']); ?>"><?php echo htmlspecialchars($question['username']); ?></a>
                    <!-- <span class="layout__question-posted-time"><?php //echo htmlspecialchars($timestamp); ?></span> -->
               </p>
          </div>
          <div class="layout__question-action-continer">
               <?php if ($_SESSION['userId'] == $question['user_id']) : ?>
                    <a class="layout__question-edit" href="<?php echo htmlspecialchars("editQuestion.php?id=" . $question['question_id']); ?>">
                         <i class="question-edit-icon fa-solid fa-edit"></i>
                         <p>Edit</p>
                    </a>
                    <div class="layout__question-delete" onclick="confirmDeletion('<?php echo htmlspecialchars($question['question_id']); ?>')">
                         <i class="question-delete-icon fa-solid fa-trash-can"></i>
                         <p>Delete</p>
                    </div>
               <?php endif; ?>
               <?php if ($_SESSION['userId'][0] == "U") : ?>
                    <div class="layout__question-bookmark" data-bookmark-id="<?php echo htmlspecialchars($question['question_id']); ?>">
                         <i class="question-bookmark-icon fa-solid fa-bookmark"></i>
                         <p>Save</p>
                    </div>
               <?php endif; ?>
          </div>
     </div>
</article>