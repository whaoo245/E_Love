<?php
session_start();
require '../../helper/redirector.php';
include '../../helper/autoloader.php';

$path = '../../../';

$admin = new \Controller\User();
$question = new \Controller\Question();
$answer = new \Controller\Answer(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../config/head.php' ?>
    <title>Dashboard | E Love</title>
    <link rel="stylesheet" href="<?php echo $path; ?>public/css/admin/dashboard.css">
</head>

<body>
    <?php include '../layout/header.php'; ?>

    <div class="main-sidebar-wrapper">
        <?php include '../layout/sideNavbar.php' ?>

        <main class="dashboard--main main-content">
            <h2 class="dashboard__title main-title">Admin Dashboard</h2>

            <div class="panel dialog">
                <div class="panel-card-stats">
                    <p class="panel-title">Verified Ratio</p>
                    <p class="panel-title-stat"><?php echo htmlspecialchars($admin->verifiedRatio()); ?></p>
                </div>
                <div class="panel-detail verified-users">
                    <div class="panel-card-stats">
                        <p class="panel-card-stat-count"><?php echo htmlspecialchars($admin->userCount()); ?></p>
                        <p class="panel-card-title">Total User</p>
                    </div>
                </div>
                <div class="panel-detail total-users">
                    <div class="panel-card-stats">
                        <p class="panel-card-stat-count"><?php echo htmlspecialchars($admin->userCount('verified')); ?></p>
                        <p class="panel-card-title">Verified user</p>
                    </div>
                </div>
            </div>

            
        </main>

    </div>



    <?php include '../layout/footer.php'; ?>

    <script src="<?php echo $path; ?>public/js/script.js"></script>
</body>

</html>