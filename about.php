<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
?> 
<html>
    <head>
        <title>About | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/profile.css">
        <style type="text/css">
            .profile h3 {
                margin-bottom: 10px;
            }
            .profile p {
                margin-bottom: 20px;
            }
            .img-banner {
                margin-bottom: 30px;
            }
        </style>
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="flex-center">
            <div class="profile">
                <img class="img-banner" src="images/Screenshot_53.png" width="721px" height="719px">
                <h3>About SBMA</h3>
                <p>St. Brother Miguel Academy (SBMA), guided by the esteemed Brothers of LaSalle, stands as a beacon of service and compassion. Committed to making a tangible difference, SBMA is driven by a deep-seated dedication to volunteerism and support for those in need. Through charitable initiatives and generous donations, we extend our hands to uplift communities, embodying the ethos of selflessness and empathy. At the core of our educational mission lies a holistic approach that not only imparts knowledge but also instills values rooted in the teachings of God, nurturing people to become compassionate individuals dedicated to creating a better world.</p>

                <h3>Mission</h3>
                <p>"At St. Brother Miguel Academy (SBMA), our mission is to cultivate a community of service, guided by the principles of the Brothers of LaSalle. We are dedicated to fostering empathy, compassion, and social responsibility through volunteer efforts and charitable endeavors. Rooted in the teachings of God, we provide holistic education that nurtures the mind, spirit, and character, empowering individuals to become conscientious leaders committed to making a positive impact in society."</p>

                <h3>Vision</h3>
                <p>to be a beacon of hope and transformation, where the spirit of service thrives. We aspire to create a world where every individual is empowered with education enriched by values faith, service and communion. Through our unwavering commitment to helping others and our steadfast belief in the potential of each person, we aim to build a society where kindness, generosity, and understanding reign, fostering a global community united in purposeful compassion and goodwill.</p>

                <h3>Contact</h3>
                <p>09XXXXXXXXX or 434 – XXXX</p>

                <h3>Address</h3>
                <p>La Salle Avenue, Bacolod 6100,Negros Occidental</p>

                <h3>Email</h3>
                <p>Voxusls@usls.edu.ph</p>

                <h3>Social Media</h3>
                <p>
                <a href="https://www.facebook.com/voxusls"><img src="images/facebook.png" width="25px" height="25px"></a>
                <a href="https://www.tiktok.com/@vox_usls?lang=en"><img src="images/tiktok.webp" width="25px" height="25px"></a>
                </p>
            </div>
          </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>