<?php
session_start();
include '../conn.php';

$date = $_GET['date'] ?? date('Y-m-d'); // Get the date from the query parameter or use today's date

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT bible_verse, content FROM devotions WHERE devotion_date = ? LIMIT 1");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$bibleVerse = "";
$content = "";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bibleVerse = $row['bible_verse'];
    $content = $row['content'];
}
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Devotion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Add your CSS styles here */
        /* 2nd Content */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .second-content {
            position: absolute;
            top: -120px;
            left: -100px;
            padding: 10px 20px;
            width: 100%;
            max-width: 500px;
            height: auto;
            z-index: 0;
        }

        .second-content img {
            width: 410%;
            height: 90%;
            clip-path: inset(35% 0 15% 0);
            filter: brightness(0.9);
        }

        .daily-devotion h1 {
            font-size: 4.2em;
            color: #ffffff;
            margin: 5px 0;
            position: absolute;
            top: 150px;
            left: 100px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
            z-index: 1500;
        }

        .second-content-transparent-rectangle {
            position: absolute;
            top: 430px;
            left: 1px;
            width: 1920px;
            height: 100px;
            background-color: rgb(237, 230, 216);
            z-index: 100;
        }

        .date-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ede6d8;
            border: 1px solid #694f36;
            border-radius: 25px;
            padding: 10px 20px;
            margin: 20px;
            position: absolute;
            top: 440px;
            left: 1450px;
            transform: translateX(-50%);
            z-index: 1500;
            width: auto;
        }

        .date-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #694f36;
            margin: 0 10px;
        }

        .date-navigation span {
            margin: 0 10px;
            font-size: 18px;
            color: #694f36;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
        }

        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 28px;
            top: 395px;
            left: 950px;
            transform: translateX(-50%);
            z-index: 1500;
        }

        .devotion-text {
            position: absolute;
            font-family: 'The Seasons';
            top: 420px;
            left: 380px;
            transform: translateX(-50%);
            color: #694e37;
            z-index: 1500;
        }

        .bible-verse {
            position: absolute;
            font-weight: 'Arial';
            font-size: 14px;
            top: 470px;
            left: 290px;
            z-index: 1500;
        }

        .devotion-content {
            position: absolute;
            font-size: 24px;
            color: #694f36;
            top: 580px;
            left: 180px;
            z-index: 1500;
            border: 1px solid transparent;
            padding: 10px;
            max-width: 80%;
            max-height: 300px;
            overflow: hidden;
            box-sizing: border-box;
            overflow-wrap: break-word;
            transition: max-height 0.3s ease;
        }

        .read-more {
            display: none;
            position: absolute;
            top: 880px;
            left: 880px;
            z-index: 1500;
            background-color: #694f36;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .audio-control {
            position: absolute;
            top: 530px;
            left: 630px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 25px;
            background-color: #f5f5f5;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1500;
        }

        .audio-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #694f36;
        }

        #progress-bar {
            flex-grow: 1;
            margin: 0 10px;
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 2000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: hidden; /* Disable scroll */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-height: 70vh; /* Limit height to avoid overflow */
            overflow-y: auto; /* Enable scroll within modal if needed */
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
            top: 45px;
            margin-left: 1144px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -332px;
        }
        .second-content img {
            position: absolute;
            top: -107px;
            width: 300%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 201px;
            left: 1px;
            width: 1535px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 205px;
            left: 1235px;
            width: 375px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 168px;
            left: 748px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 95px;
            left: 177px;
        }
        .devotion-text {
            top: 186px;
            left: 425px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 239px;
            left: 333px;
            z-index: 1500;
        }
        .audio-control {
            top: 294px;
            left: 465px;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 339px;
            left: 197px;
            width: 93%;
            max-height: 393px;
            z-index: 1500;
        }
        .read-more {
            top: 633px;
            left: 722px;
        }
        .modal-content {
            margin-top: 355px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
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
            top: 45px;
            margin-left: -500px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -443px;
        }
        .second-content img {
            position: absolute;
            top: -107px;
            width: 282%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 201px;
            left: 1px;
            width: 1442px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 205px;
            left: 1138px;
            width: 375px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 168px;
            left: 692px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 95px;
            left: 175px;
        }
        .devotion-text {
            top: 186px;
            left: 383px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 239px;
            left: 293px;
            z-index: 1500;
        }
        .audio-control {
            top: 294px;
            left: 435px;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 339px;
            left: 108px;
            width: 93%;
            max-height: 488px;
            z-index: 1500;
        }
        .read-more {
            top: 659px;
            left: 663px;
        }
        .modal-content {
            margin-top: 355px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    

    


    @media (max-width: 1024px) {
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .nav {
            top: 45px;
            margin-left: -800px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -835px;
        }
        .second-content img {
            position: absolute;
            top: -107px;
            width: 199%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 201px;
            left: 1px;
            width: 1021px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 205px;
            left: 756px;
            width: 375px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 168px;
            left: 492px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 95px;
            left: 26px;
        }
        .devotion-text {
            top: 186px;
            left: 180px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 239px;
            left: 93px;
            z-index: 1500;
        }
        .audio-control {
            top: 294px;
            left: 227px;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 339px;
            left: 108px;
            width: 93%;
            max-height: 488px;
            z-index: 1500;
        }
        .read-more {
            top: 557px;
            left: 451px;
        }
        .modal-content {
            margin-top: 355px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }
        


    @media (max-width: 768px) {
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .logo-img {
            width: 120px;
        }
        .nav {
            top: -30px;
            margin-left: 70px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1078px;
        }
        .second-content img {
            position: absolute;
            top: -107px;
            width: 157%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 201px;
            left: 1px;
            width: 767px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 205px;
            left: 528px;
            width: 375px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 168px;
            left: 367px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 95px;
            left: 26px;
        }
        .devotion-text {
            top: 186px;
            left: 180px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 239px;
            left: 93px;
            z-index: 1500;
        }
        .audio-control {
            top: 294px;
            left: 81px;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 339px;
            left: 108px;
            width: 93%;
            max-height: 488px;
            z-index: 1500;
        }
        .read-more {
            top: 557px;
            left: 323px;
        }
        .modal-content {
            margin-top: 355px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    @media (max-width: 425px) {
        .nav  {
            top: 10px;
            margin-left: -90px;
            height: 100px;
            white-space: nowrap;
            font-size: 10px;
        }
        .gives-button {
            margin-left: -1355px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            width: 130.8%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 550px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 226px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 138px;
            left: 54px;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 449px;
            left: 40px;
            width: 93%;
            max-height: 386px;
            z-index: 1500;
        }
        .read-more {
            top: 758px;
            left: 159px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    @media (max-width: 414) and (min-height: 667px){
        .nav {
            top: 103px;
            margin-left: 925px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            width: 125.2%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 439px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 226px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 138px;
            left: 54px;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 449px;
            left: 92px;
            width: 93%;
            max-height: 454px;
            z-index: 1500;
        }
        .read-more {
            top: 683px;
            left: 159px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    
    

    @media (max-width: 375px) {
        .nav {
            top: 10px;
            margin-left: 9px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            width: 145.2%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 520px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 226px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 138px;
            left: 54px;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            top: 449px;
            left: 92px;
            width: 93%;
            max-height: 454px;
            z-index: 1500;
        }
        .read-more {
            top: 839px;
            left: 159px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }


    @media (max-width: 360px) {
        .nav {
            top: 103px;
            margin-left: 925px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            width: 129.2%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 437px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 230px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 145px;
            left: 54px;
            white-space: nowrap;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
            white-space: nowrap;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            left: 101px;
            width: 93%;
            max-height: 327px;
            z-index: 1500;
        }
        .read-more {
            top: 737px;
            left: 170px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    @media (max-width: 360px) and (min-height: 560px) {
        .nav {
            top: 103px;
            margin-left: 925px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            width: 129.2%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 437px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 230px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 145px;
            left: 54px;
            white-space: nowrap;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
            white-space: nowrap;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            left: 101px;
            width: 93%;
            max-height: 327px;
            z-index: 1500;
        }
        .read-more {
            top: 607px;
            left: 170px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }

    @media (max-width: 320px) {
        .nav {
            top: 10px;
            margin-left: -70px;
            height: 100px;
            white-space: nowrap;
            font-size:12px;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .second-content img {
            position: absolute;
            top: -52px;
            left: -30px;
            width: 155.2%;
            height: 581px;
            clip-path: inset(51% 0 33% 0);
        }
        .second-content-transparent-rectangle {
            position: absolute;
            top: 263px;
            left: 0px;
            width: 480px;
            height: 100px;
        }
        .date-navigation {
            position: absolute;
            top: 353px;
            left: 197px;
            width: 380px;
        }
        .today-date-display {
            position: absolute;
            font-family: 'Lora', serif;
            font-size: 25px;
            top: 226px;
            left: 206px;
            white-space: nowrap;
        }
        .daily-devotion h1 {
            font-size: 2.2em;
            top: 145px;
            left: 54px;
            white-space: nowrap;
        }
        .devotion-text {
            top: 248px;
            left: 209px;
            white-space: nowrap;
        }
        .bible-verse {
            position: absolute;
            font-size: 14px;
            top: 302px;
            left: 114px;
            z-index: 1500;
            white-space: nowrap;
        }
        .audio-control {
            top: 412px;
            left: 47px;
            width: auto;
        }
        .devotion-content {
            position: absolute;
            font-size: 28px;
            color: #694f36;
            left: 101px;
            width: 93%;
            max-height: 610px;
            z-index: 1500;
        }
        .read-more {
            top: 728px;
            left: 159px;
        }
        .modal-content {
            margin-top: 481px;
            margin-left: 0px;
            max-width: 100%;
            width: auto;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
            box-sizing: border-box;
            padding: 20px;
        }
    }
    


    </style>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- devotion Content -->
<div class="bible-verse">
    <h2><?php echo htmlspecialchars($bibleVerse); ?></h2>
</div>
<div class="devotion-content">
    <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
</div>

<!-- 2nd Content -->
<div class="second-content">
    <img src="Pictures/SecondContent/jcac.png" alt="jcac" class="jcac-img">
</div>
<div class="daily-devotion">
    <h1>DAILY DEVOTIONS</h1>
</div>
<div class="second-content-transparent-rectangle"></div>

<div id="devotion-text" class="devotion-text">
    <h1>Today's Devotion</h1>
</div>

<div class="date-navigation">
    <button id="prev-date" class="date-button"><i class="fas fa-arrow-left"></i></button>
    <span id="prev-date-display"></span>
    <span id="next-date-display"></span>
    <button id="next-date" class="date-button"><i class="fas fa-arrow-right"></i></button>
</div>
<div class="today-date-display">
    <span id="today-date-display"></span>
</div>

<div class="audio-control">
    <button id="play-pause" class="audio-button"><i class="fas fa-play"></i></button>
    <span id="current-time">00:00</span> / <span id="total-time">00:00</span>
    <input type="range" id="progress-bar" value="0" max="100">
    <button id="rewind" class="audio-button"><i class="fas fa-undo"></i></button>
    <button id="forward" class="audio-button"><i class="fas fa-redo"></i></button>
</div>

<!-- Modal Structure -->
<div id="contentModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <div class="modal-body">
            <!-- Content will be dynamically inserted here -->
        </div>
    </div>
</div>

<script>
    // Initialize currentDate
    let currentDate = new Date();
    // 2nd Content
    // Date Navigation & Realtime

    const prevDateDisplay = document.getElementById('prev-date-display');
    const todayDateDisplay = document.getElementById('today-date-display');
    const nextDateDisplay = document.getElementById('next-date-display');

    function updateDateDisplays() {
        const options = { month: 'long', day: 'numeric' };
        const optionsWithYear = { ...options, year: 'numeric' };
        const today = new Date();
        const yesterday = new Date(today);
        const tomorrow = new Date(today);
        yesterday.setDate(today.getDate() - 1);
        tomorrow.setDate(today.getDate() + 1);

        if (currentDate.toDateString() === today.toDateString()) {
            document.querySelector('.devotion-text h1').textContent = "Today's Devotion";
        } else if (currentDate.toDateString() === yesterday.toDateString()) {
            document.querySelector('.devotion-text h1').textContent = "Yesterday's Devotion";
        } else if (currentDate.toDateString() === tomorrow.toDateString()) {
            document.querySelector('.devotion-text h1').textContent = "Tomorrow's Devotion";
        } else if (currentDate > tomorrow) {
            document.querySelector('.devotion-text h1').textContent = "Future Devotion";
        } else if (currentDate < yesterday) {
            document.querySelector('.devotion-text h1').textContent = "Past Devotion";
        } else {
            document.querySelector('.devotion-text h1').textContent = "No Devotion Found";
        }

        prevDateDisplay.textContent = new Date(currentDate.getTime() - 86400000).toLocaleDateString('en-PH', options);
        todayDateDisplay.textContent = currentDate.toLocaleDateString('en-PH', optionsWithYear);
        nextDateDisplay.textContent = new Date(currentDate.getTime() + 86400000).toLocaleDateString('en-PH', options);
    }

    document.getElementById('prev-date').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDateDisplays();
        fetchDevotion(currentDate.toISOString().split('T')[0]); // Fetch new devotion
    });

    document.getElementById('next-date').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDateDisplays();
        fetchDevotion(currentDate.toISOString().split('T')[0]); // Fetch new devotion
    });

    // Text to Speech

    let isPlaying = false;
    let speechSynthesisUtterance;
    let speechSynthesisInstance = window.speechSynthesis;
    let currentText = '';
    let estimatedDuration = 0;
    let interval;

    // Function to estimate duration based on text length
    function estimateDuration(text) {
        const wordsPerMinute = 180; // Adjust this value based on your needs
        const words = text.split(/\s+/).length; // Use regex to split by whitespace
        return (words / wordsPerMinute) * 60; // Duration in seconds
    }

    // Function to format time in mm:ss
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
    }

    // Function to play or pause speech synthesis with emotion
    function playPauseSpeech() {
        if (isPlaying) {
            speechSynthesisInstance.cancel();
            clearInterval(interval);
            document.getElementById('play-pause').innerHTML = '<i class="fas fa-play"></i>';
        } else {
            if (!currentText) {
                currentText = document.querySelector('.devotion-content p').textContent.trim();
                if (!currentText) {
                    alert("No text available to play.");
                    return;
                }
                estimatedDuration = estimateDuration(currentText);
                document.getElementById('total-time').textContent = formatTime(estimatedDuration);
            }
            
            // Create a new SpeechSynthesisUtterance with emotion and male voice
            speechSynthesisUtterance = new SpeechSynthesisUtterance(currentText);
            speechSynthesisUtterance.voice = speechSynthesisInstance.getVoices().find(voice => voice.name === 'Male Voice Name'); // Replace with actual voice name
            speechSynthesisUtterance.pitch = 2; // Adjust pitch for emotion
            speechSynthesisUtterance.rate = 1; // Adjust rate for emotion

            speechSynthesisUtterance.onend = () => {
                isPlaying = false;
                clearInterval(interval);
                document.getElementById('play-pause').innerHTML = '<i class="fas fa-play"></i>';
                document.getElementById('current-time').textContent = formatTime(0);
                document.getElementById('progress-bar').value = 0;
            };
            speechSynthesisUtterance.onboundary = (event) => {
                const elapsedTime = event.elapsedTime / 1000; // Convert to seconds
                const progress = (elapsedTime / estimatedDuration) * 100;
                document.getElementById('progress-bar').value = progress;
                document.getElementById('current-time').textContent = formatTime(elapsedTime);
            };
            speechSynthesisInstance.speak(speechSynthesisUtterance);
            document.getElementById('play-pause').innerHTML = '<i class="fas fa-pause"></i>';
        }
        isPlaying = !isPlaying;
    }

    // Rewind and forward functionality
    document.getElementById('rewind').addEventListener('click', () => {
        if (speechSynthesisInstance.speaking) {
            speechSynthesisInstance.cancel();
            currentIndex = Math.max(0, currentIndex - 10);
            playPauseSpeech();
        }
    });

    document.getElementById('forward').addEventListener('click', () => {
        if (speechSynthesisInstance.speaking) {
            speechSynthesisInstance.cancel();
            currentIndex = Math.min(currentText.length, currentIndex + 10);
            playPauseSpeech();
        }
    });

    // Update speech content and duration
    function updateSpeechContent(newText) {
        currentText = newText;
        estimatedDuration = estimateDuration(newText);
        document.getElementById('total-time').textContent = formatTime(estimatedDuration);
        if (isPlaying) {
            speechSynthesisInstance.cancel();
            playPauseSpeech();
        }
    }

    // Initialize the devotion text
    updateDateDisplays();
    fetchDevotion(currentDate.toISOString().split('T')[0]); // Fetch initial devotion

    // Add event listener for play/pause button
    document.getElementById('play-pause').addEventListener('click', playPauseSpeech);

    // Read more Button

    function toggleReadMore() {
        const devotionContent = document.querySelector('.devotion-content');
        const readMoreButton = document.querySelector('.read-more');
        const modal = document.getElementById('contentModal');
        const modalBody = modal.querySelector('.modal-body');

        // Insert the full content into the modal
        modalBody.innerHTML = devotionContent.innerHTML;

        // Display the modal
        modal.style.display = 'block';
    }

    // Close the modal when the user clicks on <span> (x)
    document.querySelector('.close-button').onclick = function() {
        document.getElementById('contentModal').style.display = 'none';
    }

    // Close the modal when the user clicks anywhere outside of the modal
    window.onclick = function(event) {
        const modal = document.getElementById('contentModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const devotionContent = document.querySelector('.devotion-content');
        const readMoreButton = document.createElement('button');
        readMoreButton.className = 'read-more';
        readMoreButton.textContent = 'Read More';
        readMoreButton.addEventListener('click', toggleReadMore);
        document.body.appendChild(readMoreButton);

        // Check if content exceeds max height
        if (devotionContent.scrollHeight > devotionContent.clientHeight) {
            readMoreButton.style.display = 'block'; // Show the button if content is overflowing
        }
    });

    function fetchDevotion(date) {
        fetch(`devotion.php?date=${date}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const bibleVerseElement = doc.querySelector('.bible-verse h2');
                const contentElement = doc.querySelector('.devotion-content p');

                if (bibleVerseElement && contentElement) {
                    document.querySelector('.bible-verse h2').textContent = bibleVerseElement.textContent;
                    document.querySelector('.devotion-content p').innerHTML = contentElement.innerHTML;
                    updateSpeechContent(contentElement.textContent);

                    // Re-check if content exceeds max height after loading new content
                    const devotionContent = document.querySelector('.devotion-content');
                    const readMoreButton = document.querySelector('.read-more');
                    if (devotionContent.scrollHeight > devotionContent.clientHeight) {
                        readMoreButton.style.display = 'block';
                    } else {
                        readMoreButton.style.display = 'none';
                    }
                } else {
                    document.querySelector('.bible-verse h2').textContent = "No devotions found.";
                    document.querySelector('.devotion-content p').textContent = "";
                    updateSpeechContent("");
                }
            })
            .catch(error => console.error('Error fetching devotion:', error));
    }

</script>

</body>
</html>