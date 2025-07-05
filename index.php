<?php 
include "header.php";
?>

<style>
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Section Styles */
.Services {
    padding: 60px 20px;
    background: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.Service_title {
    text-align: center;
    margin-bottom: 40px;
}

.Service_title h2 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.Service_title p {
    font-size: 1.1rem;
    color: #7f8c8d;
}

/* Service Grid */
.Service_Wrap {
    display: grid;
    grid-template-columns: repeat(3, 1fr); 
    gap: 30px;
    justify-items: center;
    padding: 0 20px;
}

@media (max-width: 992px) {
    .Service_Wrap {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .Service_Wrap {
        grid-template-columns: 1fr;
    }
}

/* Updated Service Card Style */
.Service_Item {
    width: 100%;
    height: 280px;
    background-size: cover;
    background-position: center;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    display: flex;
    align-items: flex-end;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
}

.Service_Item:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
}

.Service_Content {
    background: rgba(255, 255, 255, 0.9);
    width: 100%;
    padding: 10px 15px;
    border-radius: 0 0 12px 12px;
    text-align: center;
}

.Service_Content h2 {
    font-size: 1.2rem;
    color: #34495e;
    margin-top: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .Service_Item {
        width: 90%;
    }
}
</style>

<!-- Hero Section -->
<section class="Hero">
    <div class="Hero_title section_title">
        <h3>DONATE HAPPINESS</h3>
        <h2>Small Efforts Make Big Change</h2>
        <ul>
            <li>Help Others By Donating</li>
            <li>Get Quality Second Hand Items</li>
        </ul>
        <div class="Hero_btns">
            <button class="btn"><a href="donaradress.php">Donate Now</a></button>
        </div>
    </div>
    <figure class="section_Image">
        <img src="images/banner.jpg" alt="">
    </figure>
</section>

<!-- SERVICES -->
<section class="Services">
    <div class="Service_title section_title">
        <h2>DONATE ALMOST ANYTHING</h2>
        <p>Find It, Love It, Pass It On</p>
    </div>
    <div class="Service_Wrap">
        <a href="all categories.php" class="Service_Item" style="background-image: url('images/all categories.jpg');">
            <div class="Service_Content">
                <h2>All Categories</h2>
            </div>
        </a>
        <a href="furniture.php" class="Service_Item" style="background-image: url('images/furniture.jpg');">
            <div class="Service_Content">
                <h2>Furniture</h2>
            </div>
        </a>
        <a href="stationary.php" class="Service_Item" style="background-image: url('images/stationary.jpg');">
            <div class="Service_Content">
                <h2>Stationery</h2>
            </div>
        </a>
        <a href="bags.php" class="Service_Item" style="background-image: url('images/bags.jpg');">
            <div class="Service_Content">
                <h2>Bags</h2>
            </div>
        </a>
        <a href="clothes.php" class="Service_Item" style="background-image: url('images/clothes.jpg');">
            <div class="Service_Content">
                <h2>Clothes</h2>
            </div>
        </a>
        <a href="books.php" class="Service_Item" style="background-image: url('images/books.jpg');">
            <div class="Service_Content">
                <h2>Books</h2>
            </div>
        </a>
    </div>
</section>

<!-- REASONS -->
<section class="Feature">
    <div class="Feature_title section_title">
        <h2>Why Donate through us?</h2>
    </div>
    <div class="Feature_Wrap">
        <div class="Feature_Item">
            <div class="Feature_Icon Section_Icon">
                <img src="images/super convenient.png" alt="">
            </div>
            <div class="Feature_Content Section_Content">
                <h2>Super Convenient</h2>
                <p>Donate reusable items from the convenience of your house. Avail doorstep pickup and get your donations delivered to the ones in need.</p>
            </div>
        </div>
        <div class="Feature_Item">
            <div class="Feature_Icon Section_Icon">
                <img src="images/humanface.png">
            </div>
            <div class="Feature_Content Section_Content">
                <h2>Feel Good Factor</h2>
                <p>Giving gives you pleasure and makes you happier bringing a positive and uplifting effect on you.</p>
            </div>
        </div>
        <div class="Feature_Item">
            <div class="Feature_Icon Section_Icon">
                <img src="images/dimonds.png" alt="">
            </div>
            <div class="Feature_Content Section_Content">
                <h2>Your Donations are Valued</h2>
                <p>We make sure your donations reach someone who really requires them by delivering them to the beneficiaries directly.</p>
            </div>
        </div>
        <div class="Feature_Item">
            <div class="Feature_Icon Section_Icon">
                <img src="images/transparent.png" alt="">
            </div>
            <div class="Feature_Content Section_Content">
                <h2>Social Responsibility</h2>
                <p>Donating used items shows social responsibility by helping those in need and reducing waste. It supports communities and promotes a more sustainable way of living.</p>
            </div>
        </div>
        <div class="Feature_Item">
            <div class="Feature_Icon Section_Icon">
                <img src="images/env.png" alt="">
            </div>
            <div class="Feature_Content Section_Content">
                <h2>Save the Environment</h2>
                <p>Keep your unwanted belongings out of landfill by giving them a new life and getting them in hands of someone who really requires them.</p>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
