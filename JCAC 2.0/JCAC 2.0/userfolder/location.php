<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }
        .service {
            position: absolute;
            top: 60px;
            left: 40px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #694f36;
            font-family: 'league spartan';
        }
        .time-date {
            position: absolute;
            top: 130px;
            left: 40px;
            color: #694f36;
            font-family: 'canva sans';
        }
        .service-text {
            position: absolute;
            top: 180px;
            left: 40px;
            color: #694f36;
            font-family: 'canva Sans';
        }
        .map {
            position: absolute;
            top: 250px;
            left: 0px;
            width: 1910px;
            height: 700px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }

        @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    @media (max-width: 1536px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 50px;
            margin-left: 1435px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -400px;
        }
        .service {
            position: absolute;
            top: 85px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 130px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 190px;
            left: 20px;
            width: 1430px;
        }
        .map {
            position: absolute;
            top: 290px;
            left: 0px;
            width: 1505px;
            height: 455px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }





    @media (max-width: 1440px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 50px;
            margin-left: 143px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -450px;
        }
        .service {
            position: absolute;
            top: 85px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 130px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 190px;
            left: 20px;
            width: 1250px;
        }
        .map {
            position: absolute;
            top: 290px;
            left: 0px;
            width: 1445px;
            height: 535px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }




    @media (max-width: 1024px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 50px;
            margin-left: -720px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -855px;
        }
        .service {
            position: absolute;
            top: 85px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 155px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 190px;
            left: 20px;
            width: 745px;
        }
        .map {
            position: absolute;
            top: 290px;
            left: 0px;
            width: 1025px;
            height: 535px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }


    @media (max-width: 768px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 10px;
            margin-left: 110px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1075px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 745px;
        }
        .map {
            position: absolute;
            top: 370px;
            left: 0px;
            width: 770px;
            height: 455px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }


    @media (max-width: 425px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 10px;
            margin-left: 9px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 450px;
            left: 0px;
            width: 425px;
            height: 375px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }


    @media (max-width: 414) and (min-height: 667px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 103px;
            margin-left: 920px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 450px;
            left: 0px;
            width: 420px;
            height: 300px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }

    @media (max-width: 375px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 10px;
            margin-left: 9px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 450px;
            left: 0px;
            width: 420px;
            height: 300px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }


    @media (max-width: 360px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 103px;
            margin-left: 920px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 450px;
            left: 0px;
            width: 420px;
            height: 300px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }

    @media (max-width: 360px) and (max-height: 560px){
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 103px;
            margin-left: 920px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 420px;
            left: 0px;
            width: 420px;
            height: 235px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }

    @media (max-width: 320px) {
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }  
        .nav {
            top: 10px;
            margin-left: 9px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1410px;
        }
        .service {
            position: absolute;
            top: 150px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .time-date {
            position: absolute;
            top: 210px;
            left: 20px;
            font-size: 1rem;
            white-space: nowrap;
        }
        .service-text {
            position: absolute;
            top: 270px;
            left: 20px;
            width: 398px;
        }
        .map {
            position: absolute;
            top: 450px;
            left: 0px;
            width: 420px;
            height: 300px;
        }
        .map iframe {
            width: 100%;
            height: 100%;
        }
    }



    </style>
</head>
<body>
    <!-- Header -->
<?php include 'header.php'; ?>

    <!-- 3rd Content -->
    <div class="service">
        <h1>JOIN US FOR SERVICE</h1>
    </div>

    <div class="time-date">
        <h2>SUNDAY - 9:30 AM & 9:30 PM</h2>
    </div>

    <div class="service-text">
        <h2>Lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem </h2>
    </div>

    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.363219543114!2d121.08635207474119!3d14.692040085805285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397bb1cf5d0abe1%3A0xdb3671a5864e8201!2sJesus%20Christ%20Antioch%20Church!5e0!3m2!1sen!2sph!4v1734415147241!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>



    <script>

    </script>
</body>
</html>