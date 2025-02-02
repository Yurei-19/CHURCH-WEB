<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .donation-bg-img {
            position: absolute;
            top: 0px;
            left: 959px;
            width: 50%;
            height: 100%;
            z-index: 0;
        }
        .praise-img {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 50%;
            height: 100%;
            z-index: 0;
        }
        .donate-title {
            position: absolute;
            top: 526px;
            left: 50px;
            font-size: 2rem;
            font-weight: bold;
            color: #ede6d8;
            font-family: 'Canva Sans';
            z-index: 0;
        }
        .donate-text {
            position: absolute;
            top: 626px;
            left: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            color: #ede6d8;
            font-family: 'Canva Sans';
            padding-right: 1000px;
            z-index: 0;
        }
        .qr-section {
            position: absolute;
            top: 250px;
            left: 1250px;
            text-align: center;
            color: #5a3e36;
            font-family: 'Canva Sans';
            z-index: 100;
            background-color: white;
            padding: 20px 90px 20px;
            border-radius: 10px;
        }
        .qr-section p {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 10px 0;
            font-family: 'Canva Sans';
            font-style: italic;
        }
        .qr-img {
            width: 200px;
            height: 200px;
        }
        .qr-code-container {
            position: relative;
            display: inline-block;
            margin-top: 20px;
        }
        .corner {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: white;
        }
        .top-left {
            top: -10px;
            left: -10px;
            border-top: 5px solid black;
            border-left: 5px solid black;
        }
        .top-right {
            top: -10px;
            right: -10px;
            border-top: 5px solid black;
            border-right: 5px solid black;
        }
        .bottom-left {
            bottom: -10px;
            left: -10px;
            border-bottom: 5px solid black;
            border-left: 5px solid black;
        }
        .bottom-right {
            bottom: -10px;
            right: -10px;
            border-bottom: 5px solid black;
            border-right: 5px solid black;
        }
        .toggle-button-container {
            display: flex;
            border: 2px solid #5a3e36;
            border-radius: 25px;
            overflow: hidden;
            width: fit-content;
            margin: 40px auto;
            justify-content: center;
        }
        .toggle-button {
            background-color: transparent;
            color: #5a3e36;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            flex: 1;
            text-align: center;
        }
        .toggle-button.active {
            background-color: #5a3e36;
            color: white;
        }
        .toggle-button:hover {
            background-color: #3e2a24;
            color: white;
        }
        .glassmorphism {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(50px);
            border-radius: 10px;
            border: 1px solid transparent;
            padding: 50px;
            width: 100%;
            z-index: 1;
        }
        @media (max-width: 1440px) {
            html, body {
                overflow: hidden;
                width: 100%;
                max-width: 100%;
                height: 100vh;
            }
            .donation-bg-img {
                left: 720px;
                width: 920px;
                height: 100vh;
                object-fit: cover;
            }
            .qr-section {
                left: 850px;
                padding: 20px 40px;
                top: 300px;
            }
            .donate-text {
                padding-right: 500px;
            }
            .praise-img {
                width: 720px;
                height: 100vh;
                object-fit: cover;
            }
          .glassmorphism{
            width: 1540px;
          } 
          
           
            }
            @media (max-width: 1024px) {
               .praise-img {
                height: 150vh;
                }
                .donation-bg-img {
                    height: 150vh;
                    width: 70%;
                }
                .qr-section {
                    width: 50%;
                    left: 75%;
                }
                .glassmorphism {
                    width: 129%;
                }
                .donate-title {
                    font-size: 1.5rem;
                    top: 900px;
                }
                .donate-text {
                    font-size: 0.8rem;
                    top: 1000px;
                }

      }
      @media (max-width: 768px) {
        .praise-img {
            height: 80vh;
            width: 1110px;
            left: 0px;
        }
        .donation-bg-img {
            height: 80vh;
            top: 700px;
            left: 10px;
            width: 1100px;
        }
        h1 {
            font-size: 1.7rem;
        }
        .donate-text {
            top: 400px;
        }
        .donate-title h1 {
            font-size: 1.9rem;
            margin-top: -550px;
            color: #ede6d8;
        }
        .qr-section {
            top: 800px;
            left: 400px;
        }
        .gives-button {
            position: absolute;
            right: -275px;
            top: 60px;
        }
        .nav a {
         
            font-size: 1.2rem;
            top: 20px;
        }
        .nav {
            margin-top: -100px;
            margin-left: 180px;
        }
      }
      @media (max-width: 425px) {
        .donation-bg-img {
          top: 1260px;
          height: 120vh;
          width: 1100px;
          left: 10px;
        }
        .qr-section {
          top: 1460px;
          left: 200px;
          width: 600px;
        }
        .qr-section p {
          font-size: 1.8rem;
        }
        .qr-img {
          width: 250px;
          height: 250px;
        }
        .toggle-button {
          font-size: 1.2rem;
          padding: 15px 30px;
        }
        .praise-img {
          height: 155vh;
          width: 1140px;
          left: 1px;
          z-index: 0;
        }
        .donate-text {
          top: 600px;
          font-size: 1.1rem;
          white-space: inherit;
        }
        .donate-title h1 {
          font-size: 2.4rem;
          margin-top: -350px;
          color: #ede6d8;
        }
        .glassmorphism {
          width: 1100px;
          height: 80px;
          padding: 20px;
         ;

        }
        .gives-button {
          position: absolute;
          right: -600px;
          top: 60px;
          width: 100px;
          height: 70px;
          font-size: 1.4rem;
          border-radius: 10px !important;
          z-index: 1000;

        }
        .nav {
          position: absolute;
          top: 20px;
          margin-left: 100px;
          height: 100px;
        font-size: 1.5rem;
       flex-direction: column;
          width: 100px;
          display: flex;
         
          gap: 15px;
        }
   
        }
      
      
      
    
    
        
        
    </style>
</head>
<body>
        <!-- Header -->
<?php include 'header.php'; ?>
    <div class="glassmorphism"></div>
    <div class="donate-bg">
        <img src="Pictures/fifthContent/donation-bg.jpg" alt="donation-bg" class="donation-bg-img">
    </div>

    <div class="qr-section">
        <p>Be a Part of Something Bigger ..</p>
        <p>SCAN QR CODE</p>
        <div class="qr-code-container">
            <img id="qr-code" src="Pictures/fifthContent/code.png" alt="QR Code" class="qr-img">
            <div class="corner top-left"></div>
            <div class="corner top-right"></div>
            <div class="corner bottom-left"></div>
            <div class="corner bottom-right"></div>
        </div>
        <div class="toggle-button-container">
            <button id="gcash-btn" class="toggle-button active" onclick="toggleQRCode('gcash')">GCash</button>
            <button id="paymaya-btn" class="toggle-button" onclick="toggleQRCode('paymaya')">PayMaya</button>
        </div>
    </div>

    <div class="praise">
        <img src="Pictures/fifthContent/praise.jpg" alt="praise" class="praise-img">
    </div>

    <div class="donate-title">
        <h1>Lorem Ipsum</h1>
    </div>

    <div class="donate-text"> 
        <h1>Lorem Ipsum lorem Ipsum dolor lorem Lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum dolor</h1>
    </div>

    <script>
        function toggleQRCode(type) {
            const qrCodeImage = document.getElementById('qr-code');
            const gcashBtn = document.getElementById('gcash-btn');
            const paymayaBtn = document.getElementById('paymaya-btn');

            if (type === 'gcash') {
                qrCodeImage.src = 'Pictures/fifthContent/code.png';
                gcashBtn.classList.add('active');
                paymayaBtn.classList.remove('active');
            } else if (type === 'paymaya') {
                qrCodeImage.src = 'Pictures/fifthContent/qrcode.png';
                paymayaBtn.classList.add('active');
                gcashBtn.classList.remove('active');
            }
        }
    </script>
</body>
</html>
