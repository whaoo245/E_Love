<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../app/config/head.php' ?>
     <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    
     <title>E Love | Malaysia</title>
</head>

<body>

     <?php include '../app/view/layout/header.php'; ?>

     <main>
          <section class="section--home">
               <img class="section--home__img" src="img/home3.jpg" alt="Illustration of collaboration among peers">
               <div class="section--home__container">
                    <h2 class="section--home__title section__title">
                         Meet 
                         <span class="highlighted-title">big and beautiful </span>love here
                    </h2>
                    <p class="section--home__content">
                    Whether you’re new to a city or looking to expand your social circle,
                    E Love is a simplified way to create meaningful friendships.
                    </p>
                    <button class="section--home-cta-btn">
                         <a class="section--home-cta-link" href="../app/view/verification/signup.php">Get started</a>
                    </button>
               </div>
          </section>
          <section class="section--features">
               <h2 class="section--features__title section__title">
                    Our
                    <span class="highlighted-title">Features</span>
               </h2>
               <div class="section--features__card-container">
                     
                    <div class="section--features__card dialog">
                         <img class="section--features__card-icon" src="img/q&a.jpg" alt=" Q&A Icon">
                         <h3 class="section--features__card-title"><span class="highlighted-title">In-app Chat</span></h3>
                         <p class="section--features__card-content">
                         Although text messaging is critical to a dating app, users are hungry for full-featured 
                         chat such as voice notes, video messages, image filters. 
                         </p>
                    </div>
                    <div class="section--features__card dialog">
                         <img class="section--features__card-icon" src="img/chat.jpg" alt=" Chat Icon">
                         <h3 class="section--features__card-title"><span class="highlighted-title">Social Media Integrations</span></h3>
                         <p class="section--features__card-content">
                         To make user profiles feel more real and authentic, your dating app would do well to
                         integrate with popular social media platforms such as Facebook and Instagram. 
                         </p>
                    </div>
                    <div class="section--features__card dialog">
                         <img class="section--features__card-icon" src="img/podium.jpg" alt=" Podium IconF">
                         <h3 class="section--features__card-title"><span class="highlighted-title">Point Awarded</span></h3>
                         <p class="section--features__card-content">
                         Wondering how much the people like you? Start gaining points by posting many post and interating with each others.
                         </p>
                    </div>
                
               </div>
          </section>
     </main>

     <?php include '../app/view/layout/footer.php'; ?>
     <script src="js/script.js"></script>
</body>

</html>