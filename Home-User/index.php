<?php
// Check if the user is logged in, otherwise redirect to the login page
// You may need to modify this part based on your authentication mechanism
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Include your database connection code here (e.g., db.php)
include("../login/db.php");

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// You can customize the dashboard content based on your requirements
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team 7 Hotel Website</title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b8a58bc95c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" media="mediatype and|not|only (expressions)" href="print.css">
</head>
<body>
    <header class="header" id="navigation-menu">
        <div class="container">
            <nav>
                <a href="#" class="logo">
                    <img src="./img/logo.png" alt="logo image">
                    <!-- <li><a href="#name" class="nav-name-hotel" style="text-decoration: none;color: #C1B086; font-size: 50px; margin-left: -500px; ">Team 7 Hotel</a> </li> -->
                </a>
                <ul class="nav-menu">
                    <li> <a href="index.php" class="nav-list">Home</a> </li>
                    <li> <a href="../Rooms.html" class="nav-list">Rooms</a> </li>
                    <li> <a href="../Check-In-Online/index.php" class="nav-list">Check-In</a> </li>
                    <li> <a href="#different-hotels" class="nav-list">About</a> </li>
                    <div class="wrapper" style="margin-left: 40px;">
                        <h4>Welcome, <?php echo $user['username']; ?>!</h4>
                        <p><a href="../login/logout.php">Logout</a></p>
                    </div>
                </ul>

                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>

    </header>

    <div class="location-ask">
        <span class="where-to">Where to?</span> <span class="required">(Required) </span> <br />

    <div class="booking">

            <label class="location-label"></label>
            <input type="text" class="location" placeholder="City, state, location, or airport" required>

            <button type="submit" class="btn date" onclick="dateOpenPopup()">Date</button>
            <div class="date-popup" id="date-popup">
                <h2>Select Date</h2>
                <input type="text" id="datepicker">
                <button type="button" onclick="dateClosePopup()">OK</button>
            </div>

            <button type="submit" class="btn room" onclick="roomOpenPopup()">Rooms & Guests</button>
            <div class="room-popup" id="room-popup">
                <h2>Rooms and Guests</h2>
                <div class="container-room">
                <form>
                    <label for="rooms">Rooms:</label>
                    <input type="number" id="rooms" value=1><br><br>
                    <label for="adults">Adults:</label>
                    <input type="number" id="adults" value=1><br><br>
                    <label for="kids">Kids:</label>
                    <input type="number" id="kids" value=0><br><br>
                </form>
                <button type="button" onclick="roomClosePopup()">OK</button>

            </div>
            </div>

            <a href="../Rooms.html"><button onclick="redirecToRooms()" id="redirectButton" type="submit" class="btn find-hotels">Find a Hotel</button></a>

    </div>

    <div class="hotel-front-container">
        <img src="https://raw.githubusercontent.com/MichaelZhou334/Hotel-Landing-Page/main/images/hotel_front.jpg" alt="picture of the front of the hotel" class="hotel-front">
       </div>

       <div class="welcome-text">
        <h2>Beautiful Room</h2>
        <p>This hotel offers a perfect blend of luxury, comfort, and the enchanting allure of Viet Nam.</p>
        <button class="btn">Explore More</button>
       </div>

       <div class="subheading">
        <h2>Exhilarating Destinations</h2>
        <p>Here is a journey through some of the most wonderful room.</p>
       </div>

       <div class="destinations-images">

        <div class="country" id="singleBed-div">
            <img src="./img/galery1.jpg" alt="italy hotel" >
            <div class="room-text" id="singleBed-text">SINGLE BED</div>
        </div>
        <div class="country" id="portugal-div">
            <img src="./img/RoomBooking3.jpg" alt="portugal hotel" >
            <div class="room-text" id="portugal-text">DOUBLE BED</div>
        </div>
        <div class="country" id="japan-div">
            <img src="./img/galery7.jpg" alt="japan hotel" >
            <div class="room-text" id="japan-text">FAMILY ROOM</div>
        </div>
        <div class="country" id="egypt-div">
            <img src="./img/RoomBooking1.jpg" alt="egypt hotel" >
            <a style="color: white;" href="../Rooms.html"><div class="room-text" id="egypt-text">MORE...</div></a>
        </div>
       </div>

       <div class="subheading">
        <h2>Experience Something New</h2>
        <p>The unknown beckons us, and our imaginations run wild with possibilities</p>
       </div>

       <div class="experience-images">
        <div class="experience" id="discount-div">
            <img src="https://raw.githubusercontent.com/MichaelZhou334/Hotel-Landing-Page/main/images/discount.jpg" alt="discount picture" >
            <div class="experience-text" id="discount-text">ADVANCE PURCHASE DISCOUNT</div>
        </div>
        <div class="experience" id="points-div">
            <img src="./img/PoolHotel.jpg" alt="points picture" >
            <div class="experience-text" id="points-text">POOL HOUSE</div>
        </div>
        <div class="experience" id="parking-div">
            <img src="./img/Parking-Stay.jpg" alt="parking picture" >
            <div class="experience-text" id="parking-text">PARKING & STAY</div>
        </div>
        <div class="experience" id="plan-div">
            <img src="https://raw.githubusercontent.com/MichaelZhou334/Hotel-Landing-Page/main/images/plan.jpg" alt="plan picture" >
            <div class="experience-text" id="plan-text">Breakfast</div>
        </div>
        <div class="experience" id="first-time-div">
            <img src="https://raw.githubusercontent.com/MichaelZhou334/Hotel-Landing-Page/main/images/first-time.jpg" alt="first-time picture" >
            <div class="experience-text" id="first-time-text">FIRST TIME DISCOUNTS</div>
        </div>
        <div class="experience" id="members-div">
            <img src="https://raw.githubusercontent.com/MichaelZhou334/Hotel-Landing-Page/main/images/front-desk.jpg" alt="members picture" >
            <div class="experience-text" id="members-text">MEMBERS GET MORE</div>
        </div>
       </div>

       <div class="different-hotels" id="different-hotels">
        <img src="./img/Hotel.jpg" alt="hotel front">
        <div class="different-hotels-div">
        <h2>OUR BEST ROOMS</h2>
        <p>Team 7 Hotel was designed to provide travelers with access to high-end vacation rentals, such as entire homes, villas, and luxury accommodations. The platform featured a curated selection of upscale and unique properties, with distinctive architectural features, stunning views, or premium amenities. We offered additional concierge services, which could include personalized check-in experiences, access to local recommendations, and assistance with planning activities and dining reservations.</p>
        <button type="submit" class="btn"><a href="../UserLogin/signup.php" style="color: white; text-decoration: none;">Sign Up</a></button>
    </div>
    </div>

    <div class="back-to-top">
    <button onclick="topFunction()" class="btn"> ⬆ Back to Top</button>
    </div>

    <df-messenger
    intent="WELCOME"
    chat-title="7Hotel_QA"
    agent-id="dcccff66-836f-4065-909d-49068d6cb398"
    language-code="en"
    ></df-messenger>  
  <hr class="footer-line">

    <div class="footer">
        <div class="col-1">
            <div>
            <h3>How can we help?</h3>
            <button class="btn">Request a Call</button>
            <div class="social-icons">
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-youtube"></i>
                
            </div>

        </div>
        </div>
        <div class="col-2">
            <a href="#">Travel Inspiration</a>
            <a href="#">Pet-Friendly Stays</a>
            <a href="#">Gift Card</a>
            <a href="#">Global Privacy Statement</a>
            <a href="#">Site Map</a>
            <a href="#">Development</a>
            <a href="#">Media</a>
            <a href="#">Blog</a>
            <a href="#">Web Accessibility</a>
            <a href="#">Customer Support</a>
        </div>
        <div class="col-3">
            <a href="#">Cookies Statement</a>
            <a href="#">Hotel Hotline</a>
            <a href="#">Corporate Responsibility</a>
            <a href="#">Hotel Honors Discount Terms & Conditions</a>
            <a href="#">Modern Slavery and Human Trafficking</a>
            <a href="#">Do Not Sell My Personal Information</a>
            <a href="#">Personal Data Requests</a>
            <a href="#">Site Usage Agreement</a>
            
        </div>
        <div class="col-4">
            <a href="#">Address: 180 Đ. Cao Lỗ, Phường 4, Quận 8, Thành phố Hồ Chí Minh</a>
        </div>
    </div>
    <script src="./script.js"></script>
    </body>
    </html>