<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="dashboard-container">
    <!-- Background Image -->
    <div class="background">
        <img src="Pictures/firstContent/bg.jpg" alt="Background">
    </div>

    <!-- Pastor Image (Right Side) -->
    <div class="pastor-image">
        <img src="Pictures/firstContent/pastor.png" alt="Pastor">
    </div>

    <!-- Great Image (Left Side) -->
    <div class="great-image">
        <img src="Pictures/firstContent/great.png" alt="Great">
    </div>

    <!-- Church Name and Year -->
    <div class="church-name">Jesus Christ Antioch Church</div>
    <div class="year">2024</div>

    <!-- Devotion Button (Bottom Left) -->
    <div class="devotion-button">
        <a href="devotion.php" class="gradient-button">
            Today's Devotion 
            <span class="date"><?php echo date('F j, Y'); ?></span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <!-- Add this after the pastor-image div -->
    <div class="transparent-rectangle">
        <div class="social-icon">
            <i class="fab fa-facebook-f"></i>
        </div>
    </div>

    <!-- Add this after the pastor-image div -->
    <div class="pastor-name">
        <div class="title">Pastor</div>
        <div class="name">Jojo Limindog</div>
    </div>
</div>

<style>
body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.dashboard-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    margin-top: -110px;
    padding: 0;
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.background img {
    margin-top: 0;
    width: 50%;
    height: 110vh;
    object-fit: cover;
    position: absolute;
    top: -300px;
    right: 0;
    transform: none;
    z-index: -1;
}

.pastor-image {
    height: 100px;
    position: absolute;
    right: -200px;
    top: 14%;
    transform: translateY(-50%);
    z-index: 2;
    width: 65%;
}

.pastor-image img {
    width: 100%;
    height: auto;
}

.great-image {
    position: absolute;
    left: -250px;
    top: 300px;
    transform: translateY(-50%);
    z-index: 2;
    width: 50%;
}

.great-image img {
    width: 100%;
    height: auto;
}

.devotion-button {
    position: absolute;
    bottom: 5%;
    left: 5%;
    z-index: 3;
}

.gradient-button {
    top: -240px;
    left: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 30px;
    background: linear-gradient(45deg, #ff4949, white);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    font-size: 18px;
    width: 300px;
    position: relative;
}

.gradient-button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.gradient-button .date {
    font-size: 14px;
    margin-top: 5px;
    text-transform: none;
}

.gradient-button i {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.church-name {
    position: absolute;
    left: 20%;
    top: 430px;
    transform: translateX(-50%);
    z-index: 2;
    color: #b49979;
    font-size: 34px;
    font-weight: bold;
    text-align: center;
    width: 100%;
}

.year {
    position: absolute;
    left: 620px;
    top: 370px;
    z-index: 2;
    color: #b49979;
    font-size: 24px;
    font-weight: bold;
}

.transparent-rectangle {
    position: absolute;
    right: 20.7%;
    top: 74%;
    width: 1100px;
    height: 100px;
    transform: translate(50%, -50%);
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 5;
    display: flex;
    align-items: center;
}

.social-icon {
    position: absolute;
    left: 75%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 34px;
    transition: all 0.3s ease;
}

.social-icon:hover {
    transform: translate(-50%, -50%) scale(1.2);
    color: #4267B2;
}

.pastor-name {
    position: absolute;
    left: 55%;
    top: 74%;
    transform: translate(-50%, -50%);
    z-index: 6;
    text-align: center;
}

.pastor-name .title {
    color: white;
    font-size: 34px;
    font-weight: bold;
    margin-bottom: 5px;
    z-index: 7;
}

.pastor-name .name {
    color: white;
    font-size: 24px;
    font-weight: bold;
    z-index: 8;
}


@media (max-width: 425px) {
    .dashboard-container {
        left: -40px;
        width: 650px;
        margin: 0;
        height: 120vh;  
        padding: 0;
    }
    .nav {
        top: -30px;
        font-size: 17px;
    }
    .gives-button {
        margin-left: -200px;
    }
    .background img {
        width: 700px;
        height: 350vh;
        top: -80px;
        margin-left: -200px;
        padding: 0;
    }
    .pastor-image {
        position: absolute;
        left: -10px !important;
        top: 599px !important;
        width: 900px;
    }
    
    .transparent-rectangle {
        position: absolute;
        left: -295px;
        margin-top: 200px;
        max-width: 700px;
        min-height: 80px !important;
    }
    .pastor-name {
        position: absolute;
        margin-left: -250px!important;
        font-size: 40px;
        margin-top: 190px;
    }
    .social-icon {
        position: absolute;
        font-size: 40px;
        margin-top: 1px;
        margin-left: 180px;
    }   
    .gradient-button {
        left: 150px !important;
        top: -500px;
        width: 300px;
        height: 50px;
        font-size: 20px;
    }
    .great-image {
        position: absolute;
        height: auto;
        left: -50px !important;
        right: 0;
        top: -50px !important;
        margin: auto;
        width: 500px;
        z-index: 2;
        transform: translateX(-100px);
    }
    .church-name {
        font-size: 30px;
        margin-top: -200px;
        margin-left: 120px;
        text-shadow: 2px 2px 4px #000000;
    }
    .year {
        font-size: 25px;
        margin-top: -200px !important;
        text-shadow: 2px 2px 4px #000000;
        left: 420px !important;
    }
}

/* Specific styles for screens between 321px and 375px */
@media  (max-width: 375px) {
    .dashboard-container {
        left: 0;
        width: 600px;
        margin: 0;
        height: 140vh;  
        padding: 0;
    }
    .nav {
        top: -30px;
        font-size: 17px;
        left: -500px;
    }
    .gives-button {
        margin-left: -220px;
    }


    .background img {
        max-width: 850px;
        height: 1200px !important;
        left: 10px;
        padding: 0;
        margin: 0;
    }

    .pastor-image {
        position: absolute;
        left: -160px !important;
        top: 560px !important;
        width: 1100px !important;
    }

    .transparent-rectangle {
        position: absolute;
        left: -340px;
        top: 890px!important;
        width: 950px;
    }

    .social-icon {
        position: absolute;
        font-size: 50px;
        margin-top: 1px;
        margin-left: 200px;
    }

    .pastor-name {
        position: absolute;
        left: 350px !important;
        top: 890px !important;
    }

    .gradient-button {
        position: absolute;
        left: 20px !important;
        top: -800px;
        width: 400px;
        height: 50px;
        font-size: 30px;
    }

    .great-image {
        position: absolute;
        width: 700px;
        left: -150px;
    }

    .year {
        position: absolute;
        left: 410px;
        top: 280px;
        font-size: 30px;
        text-shadow: 2px 2px 4px #000000;
    }

    .church-name {
        position: absolute;
        left: 300px;
        top: 400px;
        text-shadow: 2px 2px 4px #000000;
        font-size: 30px;
    }
}

/* Specific styles for screens 320px and below */
@media (max-width: 320px) {
    .nav {
        top: -20px !important;
        font-size: 20px !important;
    }
    .gives-button {
        margin-top: -25px;
        background-color: #f10707;
        color: white;
        font-size: 25px;
        margin-left: -270px;
        border: none;   
    }  
    
    .dashboard-container {
        left: -10px;
        width: 600px;
        margin: 0;
        height: 140vh;  
        padding: 0;
    }

    .background img {
        max-width: 600px;
        height: 1800px !important;
        left: 10px;
        padding: 0;
        margin: 0;
    }
    .pastor-image {
        position: absolute;
        left: -80px;
        top: 670px !important;
        width: 1100px !important;
    }
    .transparent-rectangle {
        position: absolute;
        left: -400px;
        top: 1000px !important;
        width: 900px;
    }
    .social-icon {
        position: absolute;
        font-size: 50px;
        margin-top: 1px;
        margin-left: 280px;
    }
    .pastor-name {
        position: absolute;
        left: 10px;
        top: 1000px !important;
    }

    .gradient-button {
        position: absolute;
        left: 50px;
        top: -800px;
        width: 400px;
        height: 50px;
        font-size: 30px;
    }
    .great-image {
        position: absolute;
        width: 700px;
        left: -150px;
    }
    .year {
        position: absolute;
        left: 410px;
        top: 280px;
        font-size: 30px;
        text-shadow: 2px 2px 4px #000000;
    }
    .church-name {
        position: absolute;
        left: 300px;
        top: 400px;
        text-shadow: 2px 2px 4px #000000;
        font-size: 30px;
    }
}

/* Media query for 2560px (4K/UHD displays) */
@media (min-width: 2560px) {
    .dashboard-container {
        height: 100vh;
        margin-top: -150px;
    }
    .nav {
      font-size: 50px;
    }
    .gives-button {
        font-size: 50px;
        border-radius: 10px;
    }
    

    .background img {
        width: 60%;
        height: 100vh;
        top: -400px;
    }

    .pastor-image {
        right: -400px;
        top: 15%;
        width: 80%;
    }

    .great-image {
        left: -400px;
        top: 400px;
        width: 60%;
    }

    .church-name {
        left: 25%;
        top: 600px;
        font-size: 60px;
    }

    .year {
        left: 820px;
        top: 400px;
        font-size: 40px;
    }

    .transparent-rectangle {
        right: 26.6%;
        top: 74%;
        width: 1700px;
        height: 150px;
    }

    .social-icon {
        font-size: 50px;
    }

    .pastor-name .title {
        font-size: 50px;
    }

    .pastor-name .name {
        font-size: 40px;
    }

    .gradient-button {
        top: -300px;
        left: 200px;
        padding: 25px 50px;
        font-size: 30px;
        width: 500px;
    }

    .gradient-button .date {
        font-size: 24px;
    }
}
@media (max-width: 1024px) {
    .transparent-rectangle {    
        right: 6%;
        top: 74%;
        width: 900px;
        height: 50px;
    }
    .pastor-name {
        font-size: 10px;
        top: 650px;
        left: 60%;
    }
    .pastor-name .title {
        font-size: 24px;
    }
    .pastor-name .name {
        font-size: 18px;
    }
    .social-icon {
        left: 50%;
    }
    .pastor-image {
        top: 350px;
        left: 500px;
    }
    .gradient-button {
  
        left: 50px;
        
    }
    .great-image {
        left: -200px;
        top: 350px;
        width: 700px;
    }
    .church-name {
        left: 300px;
        top: 450px;
       
        font-size: 30px;
    }
    .year {
        left: 400px;
        top: 350px;
       
    }
}
@media (max-width: 768px) {
    .nav {
        font-size: 20px;
        top: -50px;
    }
    .transparent-rectangle {
        width: 670.9px;
        top: 740px;
        
    }
    .pastor-name {
        top: 740px;
        left: 60%;
    }

    .pastor-image {
        top: 383px;
        left: 250px;
        width: 760px;
    }
    .background img {  
        height: 120vh;
    }
    .great-image {
        left: -270px;
    
    }
    .church-name {
        left: 200px;
       
    }
    .year {
        left: 300px;
    }
    .gradient-button {
        left:-20px;
    }
}





</style>

</body>
</html>