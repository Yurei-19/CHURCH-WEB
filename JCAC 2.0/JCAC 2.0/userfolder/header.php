<style>
.header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-size: cover;
            padding: 0 20px;
            margin: 0;
            position: relative;
            z-index: 1500;
        /* Header Button/Navigation */
        }
        .logo {
            flex-shrink: 0;
            z-index: 1500;
        }
        .logo-img {
            margin-top: -10px;
            width: 200px; /* Adjust the size as needed */
            height: auto;
        }
        .nav {
            display: flex;
            gap: 50px;
            position: relative;
            left: -428px;
            z-index: 1500;
        }
        .nav a {
            margin-top: -25px;
            text-decoration: none;
            color: #694f36; /* Adjust color to match the text */
            font-weight: bold;
            position: relative;
        }
        .nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            background-color: #b49979;
            bottom: -2px;
            left: 0;
            transition: width 0.3s ease-in-out; /* Smooth transition */
        }
    
        .nav a:hover::after {
            width: 100%; /* Full width on hover */
        }
        .gives-button {
            margin-top: -25px;
            background-color: #f10707;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1500;
        }
        @media (max-width: 1440px) {
          .nav a  {
            left:200px;
          }
               }
               
          @media (max-width: 1440px) {
          .nav a  {
            left:400px;
          }
            }
    
    
         @media (max-width: 768px) {
            .nav a  {
                top: 80px;
                white-space: nowrap;
                left:300px;
                font-size: 1.2em;
            }
            .gives-button{
              margin-left: -150px;
            }
            }
           

            
          
               
            
        
        </style>
<div class="header">
        <div class="logo">
            <img src="Pictures/logo.png" alt="Antioch Logo" class="logo-img">
        </div>
        <div class="nav">
            <a href="#" id="home-button">Home</a>
            <a href="#" id="events-button">Events</a>
            <a href="#" id="location-button">Location</a>
            <a href="#" id="prayer-request-button">Prayer Request</a>
        </div>
        <button class="gives-button" id="gives-button">GIVE</button>

        <script>
                        //Go to section

                        document.getElementById('home-button').addEventListener('click', function() {
                window.location.href = 'dashboard.php'; // Redirect to index.php
            });

            document.getElementById('events-button').addEventListener('click', function() {
                window.location.href = 'event.php'; // Redirect to event.php
            });

            
                document.getElementById('location-button').addEventListener('click', function() {
                    window.location.href = 'location.php'; // Redirect to location.php
                });

                document.getElementById('prayer-request-button').addEventListener('click', function() {
                    window.location.href = 'prayer.php'; // Redirect to prayer.php
                });

                document.getElementById('gives-button').addEventListener('click', function() {
                    window.location.href = 'donation.php'; // Redirect to donation.php
                });
        </script>
    </div>