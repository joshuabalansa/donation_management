<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<div class="header">
    <div class="edonatemo"><h1>E - DONATE MO | Admin page</h1></div>
    <div class="main">
    <img class="logo" src="images/edlogo.png">
        <nav>
            <ul class="nav1">
                <li><a href="user.php">Users</a></li>
                <li><a href="donation.php">Donations</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="about.php">About</a></li>
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