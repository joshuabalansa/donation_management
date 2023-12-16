<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<div class="header">
    <div class="edonatemo"><h1>E - DONATE MO </h1></div>
    <div class="main">
    <img class="logo" src="images/edlogo.png">
        <nav>
            <?php
            $isAdmin = $_SESSION['user']['access_type'] == 'admin';
            ?>
            <ul class="nav1">
                <li><a href="posts-feed.php">Home</a></li>
                <?php if($isAdmin) { ?>
                <li><a href="user.php">Users</a></li>
                <?php } ?>
                <?php if($isAdmin) { ?>
                <li><a href="reports.php">Reports</a></li>
                <?php } ?>
                <li><a href="donation.php">Donations</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="javascript:void(0)">Profile</a></li>
            </ul>
        </nav>
        <a class="start" href="javascript:void(0)" onclick="logoutBtn()">Logout</a>
    </div>
</div>

<script>
    function logoutBtn() {
        const confirmation = confirm('Are you sure you want to logout?')
        if(confirmation) {
            window.location.href = "logout.php"
        }
    }
</script>