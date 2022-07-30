let url = new URL(window.location);
/* -- Vote -- */
var userIsVerified = false;

async function checkVerifStatus() {
  // Get user id.
  let userIdRes = await fetch("../../helper/session.php");
  let userId = await userIdRes.json();

  // Get user info.
  let res = await fetch(`../../controller/user.php?userId=${userId}`);
  let userInfo = await res.json();

  // Verification with value of 1 will result in true in boolean and vice versa for 0.
  userIsVerified = parseInt(userInfo.verification) ? true : false;
}

// Wait for the checkVerifStatus async function to finish its update.
checkVerifStatus().then(() => {
  if (userIsVerified) {
    let votesIcon = document.querySelectorAll(".vote-icon");

    for (let voteIcon of votesIcon) {
      voteIcon.addEventListener("click", function () {
        let id = this.parentElement.dataset.voteId;

        let point = this.parentElement.children[1];
        let pointNum = parseInt(point.textContent.trim());

        let upvote = this.parentElement.children[0];
        let downvote = this.parentElement.children[2];

        if (this.id == "upvote") {
          if (voteIcon.classList.contains("upvote")) {
            point.textContent = pointNum - 1;
          } else if (downvote.classList.contains("downvote")) {
            point.textContent = pointNum + 2;
          } else {
            point.textContent = pointNum + 1;
          }
          updateVote(1, id);
        }
        if (this.id == "downvote") {
          if (voteIcon.classList.contains("downvote")) {
            point.textContent = pointNum + 1;
          } else if (upvote.classList.contains("upvote")) {
            point.textContent = pointNum - 2;
          } else {
            point.textContent = pointNum - 1;
          }
          updateVote(0, id);
        }
      });
    }

    async function updateVote(voteType, id) {
      try {
        await fetch(`../../controller/vote.php?voteType=${voteType}&id=${id}`);

        // Reset previous vote once the vote has been updated.
        if (id[0] == "Q") {
          setQuestionPrevVote();
        }
        if (id[0] == "A") {
          setAnsPrevVote();
        }
      } catch (e) {
        console.log("Error: ", e);
      }
    }
  }
});

// Select answer actions' vote by excluding the vote id of question Id.
let ansActionsVote = document.querySelectorAll(
  `[data-vote-id]:not([data-vote-id="${url.searchParams.get("id")}"])`
);

let questionActionVote = document.querySelector(
  `[data-vote-id=${url.searchParams.get("id")}]`
);

async function setQuestionPrevVote() {
  try {
    let res = await fetch(
      `../../controller/vote.php?voteFor=question&id=${url.searchParams.get(
        "id"
      )}`
    );
    let prevVote = await res.json();
    let upvoteIcon = questionActionVote.children[0];
    let downvoteIcon = questionActionVote.children[2];

    if (prevVote.question_id == url.searchParams.get("id")) {
      if (prevVote.vote == 1) {
        upvoteIcon.classList.add("upvote");
        if (downvoteIcon.classList.contains("downvote")) {
          downvoteIcon.classList.remove("downvote");
        }
      }
      if (prevVote.vote == 0) {
        downvoteIcon.classList.add("downvote");
        if (upvoteIcon.classList.contains("upvote")) {
          upvoteIcon.classList.remove("upvote");
        }
      }
      return;
    }

    // Remove upvote or downvote icon color if there's no previous vote.
    if (upvoteIcon.classList.contains("upvote")) {
      upvoteIcon.classList.remove("upvote");
    }
    if (downvoteIcon.classList.contains("downvote")) {
      downvoteIcon.classList.remove("downvote");
    }
  } catch (e) {
    console.log("Error: ", e);
  }
}

async function setAnsPrevVote() {
  try {
    for (let ansActionVote of ansActionsVote) {
      let upvoteIcon = ansActionVote.children[0];
      let downvoteIcon = ansActionVote.children[2];

      let res = await fetch(
        `../../controller/vote.php?voteFor=answer&id=${ansActionVote.dataset.voteId}`
      );
      let prevVote = await res.json();

      if (ansActionVote.dataset.voteId == prevVote.answer_id) {
        if (prevVote.vote == 1) {
          upvoteIcon.classList.add("upvote");
          if (downvoteIcon.classList.contains("downvote")) {
            downvoteIcon.classList.remove("downvote");
          }
        }
        if (prevVote.vote == 0) {
          downvoteIcon.classList.add("downvote");
          if (upvoteIcon.classList.contains("upvote")) {
            upvoteIcon.classList.remove("upvote");
          }
        }
      }

      // Remove upvote or downvote icon color if there's no previous vote.
      if (ansActionVote.dataset.voteId != prevVote.answer_id) {
        if (upvoteIcon.classList.contains("upvote")) {
          upvoteIcon.classList.remove("upvote");
        }
        if (downvoteIcon.classList.contains("downvote")) {
          downvoteIcon.classList.remove("downvote");
        }
      }
    }
  } catch (e) {
    console.log("Error: ", e);
  }
}

/* -- Opening and closing of comment form -- */
let commentActions = document.querySelectorAll(".question__action--comment");
let cancelCommentBtns = document.querySelectorAll(
  ".question__cancel-comment-btn"
);

for (let commentAction of commentActions) {
  commentAction.addEventListener("click", () => {
    commentAction.classList.toggle("action-btn-click");
    toggleCommentForm(commentAction.dataset.replyId);
  });
}

for (let cancelCommentBtn of cancelCommentBtns) {
  cancelCommentBtn.addEventListener("click", () => {
    // Select the comment action that has same dataset with the cancel button.
    let commentAction = document.querySelector(
      `[data-reply-id='${cancelCommentBtn.parentElement.dataset.replyId}']`
    );

    // Toggle the click effect of the matching comment action.
    commentAction.classList.toggle("action-btn-click");

    toggleCommentForm(cancelCommentBtn.parentElement.dataset.replyId);
  });
}

// Get and toggle the comment form through the dataset being passed.
function toggleCommentForm(dataset) {
  let commentForm = document.querySelector(`[data-comment-id='${dataset}']`);

  commentForm.classList.toggle("show");

  if (ansAction) {
    if (
      ansAction.classList.contains("action-btn-click") &&
      postAnsForm.classList.contains("show") &&
      /* Only toggle the answer form and action if the comment
         action being clicked is for question. */
      dataset == url.searchParams.get("id")
    ) {
      ansAction.classList.toggle("action-btn-click");
      postAnsForm.classList.toggle("show");
    }
  }
}

/* -- Get comment -- */
async function getComment($replyId) {
  try {
    // Get user id.
    let userIdRes = await fetch("../../helper/session.php");
    let userId = await userIdRes.json();

    let res = await fetch(
      `../../controller/comment.php?replyId=${$replyId}&userId=${userId}`
    );
    return await res.json();
  } catch (e) {
    console.log("Error: ", e);
  }
}

// Set answers' comment into comment container of answers.
async function setAnsComment() {
  for (let commentContainerAn of commentsContainerAn) {
    let answer = await getComment(commentContainerAn.dataset.ansId);

    if (commentContainerAn.dataset.ansId == answer.id) {
      commentContainerAn.innerHTML = answer.comment;
    }
  }
}

// Set question's comment into comment container of question.
async function setQnComment() {
  let question = await getComment(url.searchParams.get("id"));
  commentContainerQn.innerHTML = question.comment;
}

// Comment container of question.
let commentContainerQn = document.querySelector(
  ".question__comment-container--question"
);

// Comment container of answer.
let commentsContainerAn = document.querySelectorAll(
  ".question__comment-container--ans"
);

/* -- Add comment -- */
let questionCommentForm = document.querySelector(
  `form[data-comment-id=${url.searchParams.get("id")}]`
);

questionCommentForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  try {
    await fetch("../../controller/comment.php", {
      method: "POST",
      body: formData,
    });
  } catch (error) {
    console.log("Error: ", e);
  }

  // Get and toggle comment action of the question.
  let commentAction = document.querySelector(
    `[data-reply-id=${url.searchParams.get("id")}]`
  );
  commentAction.classList.toggle("action-btn-click");

  // Get latest comment once user submitted.
  setQnComment();

  // Reset comment form.
  this.reset();

  toggleCommentForm(url.searchParams.get("id"));
});

// Select all answers comment form by excluding the comment id of question Id.
let answerCommentForms = document.querySelectorAll(
  `form[data-comment-id]:not([data-comment-id="${url.searchParams.get("id")}"])`
);

for (let answerCommentForm of answerCommentForms) {
  answerCommentForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    try {
      await fetch("../../controller/comment.php", {
        method: "POST",
        body: formData,
      });
    } catch (error) {
      console.log("Error: ", e);
    }

    // Get and toggle comment action of the answer.
    let commentAction = document.querySelector(
      `[data-reply-id=${this.dataset.commentId}]`
    );
    commentAction.classList.toggle("action-btn-click");

    // Get latest comment once user submitted.
    setAnsComment();

    // Reset comment form.
    this.reset();

    toggleCommentForm(this.dataset.commentId);
  });
}

function toggleEditArea(id) {
  let editArea = document.querySelector(
    `.question__comment-edit-area[data-comment-id=${id}]`
  );
  let comment = document.querySelector(
    `.question__comment[data-comment-id=${id}]`
  );
  let commentAction = document.querySelector(
    `.question__comment-action[data-comment-id=${id}]`
  );
  comment.classList.toggle("hide");
  commentAction.classList.toggle("hide");
  editArea.classList.toggle("show");
}

async function saveComment(id) {
  let editBox = document.querySelector(
    `.question__comment-edit-box[data-comment-id=${id}]`
  );
  try {
    await fetch(
      `../../controller/comment.php?id=${id}&content=${editBox.value}`
    );
    toggleEditArea(id);
    setQnComment();
    setAnsComment();
  } catch (e) {
    console.log("Error: ", e);
  }
}

// Pop Up Display to ask if user wants to delete question, answer or comment.
function confirmDeletion(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      let deleteUrl = null;
      let item = null;
      if (id[0] == "Q") {
        deleteUrl = `../../controller/question.php?deleteId=${id}`;
        item = "Question";
      }
      if (id[0] == "A") {
        deleteUrl = `../../controller/answer.php?deleteId=${id}`;
        item = "Answer";
      }
      if (id[0] == "C") {
        deleteUrl = `../../controller/comment.php?deleteId=${id}`;
        item = "Comment";
      }
      deletes(deleteUrl);
      Swal.fire("Deleted!", `${item} has been deleted.`, "success").then(() => {
        if (item == "Question") {
          window.location = "../../view/student/home.php";
        } else {
          window.location = `../../view/student/question.php?id=${url.searchParams.get(
            "id"
          )}`;
        }
      });
    }
  });
}

// Execute function
async function deletes(deleteUrl) {
  try {
    await fetch(deleteUrl);
  } catch (e) {
    console.log(e);
  }
}

/* -- Add and remove Bookmark -- */
let bookmarkActions = document.querySelectorAll(".question__action--bookmark");

for (let bookmarkAction of bookmarkActions) {
  bookmarkAction.addEventListener("click", async function () {
    bookmarkAction.classList.toggle("action-btn-click");

    try {
      await fetch(
        `../../controller/bookmark.php?id=${this.dataset.bookmarkId}`
      );
    } catch (e) {
      console.log("Error: ", e);
    }
  });
}

/* -- Get Bookmark -- */
async function getBookmark(criteria) {
  try {
    let res = await fetch(`../../controller/bookmark.php?criteria=${criteria}`);
    return await res.json();
  } catch (e) {
    console.log("Error: ", e);
  }
}

async function setBookmark() {
  try {
    // Get user id.
    let userIdRes = await fetch("../../helper/session.php");
    let userId = await userIdRes.json();

    // Store all bookmark Id record of the user.
    let bookmarksId = [];

    let bookmarks = await getBookmark(userId);

    for (let bookmark of bookmarks) {
      bookmarksId.push(bookmark.id);
    }

    for (let bookmarkAction of bookmarkActions) {
      if (bookmarksId.includes(bookmarkAction.dataset.bookmarkId)) {
        bookmarkAction.classList.toggle("action-btn-click");
      }
    }
  } catch (e) {
    console.log("Error", e);
  }
}

/* -- Opening and closing of post answer form -- */
let ansAction = document.querySelector(".question__action--ans");
let postAnsForm = document.querySelector(".question__post-ans-form");
let postAnsInput = document.querySelector(".question__post-ans-input");
let cancelAnsBtn = document.querySelector(".question__cancel-ans-btn");

if (ansAction && cancelAnsBtn) {
  ansAction.addEventListener("click", toggleAnswerForm);
  cancelAnsBtn.addEventListener("click", toggleAnswerForm);

  function toggleAnswerForm() {
    ansAction.classList.toggle("action-btn-click");
    postAnsForm.classList.toggle("show");

    // Get comment action and form of the question.
    let commentAction = document.querySelector(
      `[data-reply-id=${url.searchParams.get("id")}]`
    );
    let commentForm = document.querySelector(
      `[data-comment-id=${url.searchParams.get("id")}]`
    );

    /* Close the comment form and disable the comment action if it's 
       being activated while the answer action is being clicked. */
    if (
      commentAction.classList.contains("action-btn-click") &&
      commentForm.classList.contains("show")
    ) {
      commentAction.classList.toggle("action-btn-click");
      commentForm.classList.toggle("show");
    }
  }
}

/* -- Accept answer -- */
let acceptActions = document.querySelectorAll(".question__action--accept");

for (let acceptAction of acceptActions) {
  acceptAction.addEventListener("click", async function () {
    try {
      let res = await fetch(
        `../../controller/answer.php?acceptId=${this.dataset.acceptId}`
      );
      setBestAns();
    } catch (e) {
      console.log("Error: ", e);
    }
  });
}

async function setBestAns() {
  try {
    // Get best/accepted answer.
    let res = await fetch(
      `../../controller/answer.php?questionId=${url.searchParams.get(
        "id"
      )}&status=1`
    );
    let data = await res.json();

    let bestAnswers = document.querySelectorAll(".question__best-answer");
    for (let bestAnswer of bestAnswers) {
      if (bestAnswer.classList.contains("show")) {
        bestAnswer.classList.remove("show");
      }
      if (bestAnswer.closest(".question__ans-container").id == data.answer_id) {
        bestAnswer.classList.add("show");
      }
    }
    for (let acceptAction of acceptActions) {
      if (acceptAction.classList.contains("action-btn-click")) {
        acceptAction.classList.remove("action-btn-click");
      }
      if (
        acceptAction.closest(".question__ans-container").id == data.answer_id
      ) {
        acceptAction.classList.add("action-btn-click");
      }
    }
  } catch (e) {
    console.log("Error: ", e);
  }
}

window.onload = () => {
  if (typeof setQuestionPrevVote === "function") {
    setQuestionPrevVote();
    setAnsPrevVote();
  }
  setBookmark();
  setQnComment();
  setAnsComment();
  setBestAns();
};
