<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- style css -->
    <link rel="stylesheet" href="css/aboutus.css">
    <!-- Remix icon cdn -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

</head>
<body>
    
        <header>
            <!-- Navigation Bar -->
            <nav id="navbar">
                <div class="logo">
                   <a href="#">Donate<span>Happiness</span></a>
                </div>
                <i class="ri-menu-fill" id="toggle"></i>
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="contactus.php">contact us</a></li>
                    <li><button class="btn">
                    <?php if (isset($_SESSION['user_email'])) { ?>
                        <a href="userpanel.php">User Panel</a>
                    <?php } else { ?>
                        <a href="login.php">Login</a>
                    <?php } ?>
                </button></li>
                      
    
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <h1>About Us</h1>
            <p>Welcome to Our Platform

              At Donatehappiness, we believe in the power of giving and sharing. We connect individuals who want to donate second-hand items like clothes, shoes, furniture, and stationery with those in need. Our mission is to promote sustainability and community support by making it easy for everyone to share their unused belongings. Join us in making a difference today!</p>
              <br><br><br><br>
        </div>
   

    <!-- how we work -->
    <section class="section" style="background-color: #1b1b1b;">
        <div class="container">
            <h2>How we work</h2>
            <div class="futuristic-border"></div>
            <p>

            <div class="we-work">
                <div class="work">
                    <img src="images/schedule.jpg" alt="we-work">
                    <h3>Schedule a Pickup</h3>
                    <p>Arrange for a convenient pickup from your location or choose to drop off your donations at our designated centers</p>
                </div>
                <div class="work">
                    <img src="images/pickup.jpg" alt="we-work">
                    <h3>Direct Distribution</h3>
                    <p>We ensure that your items reach those in need through our network of community partners.</p>
                </div>
                <div class="work">
                    <img src="images/reward.jpg" alt="we-work">
                    <h3>Happiness Box</h3>
                    <p>Enjoy the surprise of receiving a "happiness box" as a token of appreciation for your generosity.</p>
                   
                </div>
            </div>
        </div>
    </section>


    <!-- Why Us Section -->
    <section class="section" style="background-color: #1b1b1b;">
        <div class="container">
            <h2>Why Donate Through Us</h2>
            <div class="futuristic-border"></div>
          

            <div class="services">
                <div class="service-item">
                    <h3>Reduce Waste</h3>
                    <p>Contribute to reducing waste by giving your unwanted items a new life</p>
                </div>
                <div class="service-item">
                    <h3>Joy of Helping</h3>
                    <p>Experience the joy of helping others while decluttering your space.</p>
                </div>
                <div class="service-item">
                    <h3>Simple Process</h3>
                    <p>Our process is simple and convenient, allowing you to make a positive impact with just a few clicks.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="section">
        <div class="container">
            <h2>Our Mission</h2>
            <p>To create a sustainable community by providing a platform for individuals to donate and receive free items, fostering generosity, reducing waste, and promoting a culture of sharing. We aim to connect people in need with those who have surplus, making quality goods accessible to all while encouraging environmental responsibility.
            </p>
        </div>
    </section>
</body>
</html>