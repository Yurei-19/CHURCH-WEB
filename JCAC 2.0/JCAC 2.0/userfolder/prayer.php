<?php
session_start();
include 'header.php';
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $wish1 = $_POST['wish1'];
    $wish2 = $_POST['wish2'];
    $wish3 = $_POST['wish3'];
    $prayerreq = $_POST['prayerreq'];

    $sql = "INSERT INTO prayerreq_tbl (name, wish1, wish2, wish3, prayerreq) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $wish1, $wish2, $wish3, $prayerreq);
    
    if($stmt->execute()) {
        $_SESSION['show_modal'] = true;
        header("Location: " . $_SERVER['PHP_SELF'], true, 303);
        exit();
    } else {
        echo "<script>alert('Error submitting prayer request.');</script>";
    }
    $stmt->close();
}

$show_modal = isset($_SESSION['show_modal']);
if($show_modal) {
    unset($_SESSION['show_modal']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .form-container {
            position: absolute;
            top: 285px;
            left: -10px;
            width: 95%;
            margin: 50px auto;
            padding: 72px;
            border: 1px solid transparent;
            background-color: #ede6d8;
        }
        .form-input {
            width: 100%;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox {
            margin-right: 10px;
        }
        .form-button {
            background-color: #8b5e34;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 50px;
            display: block;
        }
        .form-button:hover {
            background-color: #6e4a2b;
        }
        .prayer-header {
            position: relative;
            top: -100px;
            left: -20px;
            padding: 10px 20px;
            width: 100%;
            max-width: 615px;
            height: auto;
            z-index: 0;
        }
        .prayer-header-img {
            width: 315%;
            height: 100%;
            clip-path: inset(20% 0 65% 0);
            filter: brightness(0.7);
        }
        .prayer-text{
            position: absolute;
            top: 200px;
            left: 100px;
            font-size: 40px;
            font-family: 'league spartan';
            color: #ffffff;
        }
    @media (max-width: 1536px){
        .nav {
            top: 50px;
            margin-left: 1430px;    
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -390px;
        }
        .prayer-header-img{
            position: absolute;
            top: 81px;
            width: 234.9%;
            height: 4675%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 94%;
            margin: 44px auto;
            padding: 55px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 20px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 40px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 600px;
            display: block;
        }
    }

    @media (max-width: 1440px){
        .nav {
            top: 50px;
            margin-left: -700px;    
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -450px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 219.9%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 90%;
            margin: 44px auto;
            padding: 76px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 20px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 40px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 600px;
            display: block;
        }
    }
        

    @media (max-width: 1024px){
        .nav {
            top: 80px;
            margin-left: -900px;    
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -850px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 156.4%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 90%;
            margin: 44px auto;
            padding: 54px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 410px;
            display: block;
        }
    }

    @media (max-width: 768px){
        .nav {
            top: 103px;
            margin-left: -900px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1090px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 117.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 87%;
            margin: 44px auto;
            padding: 54px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 290px;
            display: block;
        }
    }


    @media (max-width: 425px){
        .nav {
            top: 103px;
            margin-left: -1100px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1355px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 110.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 88%;
            margin: 44px auto;
            padding: 73px;      
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 140px;
            display: block;
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
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 110.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 95%;
            margin: 44px auto;
            padding: 54px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 140px;
            display: block;
        }
    }


     @media (max-width: 375px){
        .nav {
            top: 103px;
            margin-left: -1110px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 110.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 95%;
            margin: 44px auto;
            padding: 54px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 140px;
            display: block;
        }
    }

     

    @media (max-width: 360px){
        .nav {
            top: 103px;
            margin-left: 925px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 110.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 95%;
            margin: 44px auto;
            padding: 54px;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 140px;
            display: block;
        }
    }



    @media (max-width: 360px) and (max-height: 560px) {
        .nav {
            top: 103px;
            margin-left: 925px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .prayer-header-img{
            position: absolute;
            top: 163px;
            width: 110.2%;
            height: 3500%;
        }
        .prayer-text{
            position: absolute;
            top: 120px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 182px;
            left: -10px;
            width: 114%;
            margin: 43px auto;
            padding: 19px;
            border: 1px solid transparent;
            background-color: #ede6d8;
        }
        .form-input{
            margin-top: -10px;
            padding: 10px;
        }
        .form-textarea{
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #8b5e34;
            box-sizing: border-box;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 10px;
        }
        .form-container p{
            margin-top: 5px;
        }
        .form-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-left: auto;
            margin-right: 140px;
            display: block;
        }
    }


    @media (max-width: 320px){
        .nav {
            top: 103px;
            font-size: 0.7rem;
            margin-left: -1120px;
            height: 100px;
            white-space: nowrap;
        }
        .gives-button {
            margin-left: -1405px;
        }
        .prayer-header-img{
            position: absolute;
            top: 108px;
            width: 122.2%;
            height: 4905%;
        }
        .prayer-text{
            position: absolute;
            top: 145px;
            left: 100px;
            font-size: 20px;
            font-family: 'league spartan';
            color: #ffffff;
            white-space: nowrap;
        }
        .form-container{
            position: absolute;
            top: 218px;
            left: -10px;
            width: 95%;
            margin: 50px auto;
            padding: 72px;
            border: 1px solid transparent;
            background-color: #ede6d8;
        }
        .form-checkbox{
            margin-right: 10px;
            margin-top: 20px;
        }
        .form-container p{
            margin-top: 50px;
        }
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background-color: #ede6d8;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #8b5e34;
        width: 80%;
        max-width: 400px;
        border-radius: 10px;
        position: relative;
        text-align: center;
        animation: slideIn 0.3s;
    }

    .success-icon {
        width: 60px;
        height: 60px;
        background-color: #4CAF50;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .success-icon::before {
        content: '✓';
        font-size: 35px;
        color: white;
    }

    .modal h2 {
        color: #8b5e34;
        margin-bottom: 15px;
        font-family: 'league spartan';
    }

    .modal p {
        color: #666;
        margin-bottom: 20px;
    }

    .modal-button {
        background-color: #8b5e34;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-button:hover {
        background-color: #6e4a2b;
    }

    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @keyframes slideIn {
        from {transform: translateY(-100px); opacity: 0;}
        to {transform: translateY(0); opacity: 1;}
    }

    </style>
</head>
<body>
    <?php if($show_modal): ?>
    <script>
        window.onload = function() {
            document.getElementById('successModal').style.display = 'block';
        }
    </script>
    <?php endif; ?>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="success-icon"></div>
            <h2>Prayer Request Submitted</h2>
            <p>Your prayer request has been successfully submitted. We will keep you in our prayers.</p>
            <button class="modal-button" onclick="closeModal()">OK</button>
        </div>
    </div>

    <div class="prayer-header">
        <img src="Pictures/FourthContent/prayer.jpg" alt="prayer-header" class="prayer-header-img">
    </div>

    <div class="prayer-text">
        <h1>Prayer Request</h1>
    </div>

    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="name" class="form-input" placeholder="Your Name" required>
            <input type="text" name="wish1" class="form-input" placeholder="Prayer Request 1" required>
            <input type="text" name="wish2" class="form-input" placeholder="Prayer Request 2">
            <input type="text" name="wish3" class="form-input" placeholder="Prayer Request 3">
            <textarea name="prayerreq" class="form-textarea" placeholder="Additional Prayer Requests"></textarea>
            <button type="submit" name="submit" class="form-button">Submit</button>
        </form>
    </div>

    <script>
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
            // Clear the form after closing the modal
            document.querySelector('form').reset();
        }
    </script>
</body>
</html>