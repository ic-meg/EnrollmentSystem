<?php
include "../dbcon.php";
include "sessioncheck.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe | Dashboard</title>
  <link rel="stylesheet" href="studDashboard.css">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<style>
    
</style>
<body>
<?php include "stud-sidebar.php"; ?>


<main>
</div>
</div>
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <!--Content here-->
        <div class="Welcome">
            <img src="studPic/image1.png" alt="logo">
            <div class="text-content">
                <div class="welcome-greeting">Hi, Giuliani!</div>
                <div class="message">Always stay updated in your profile</div>
            </div>
        </div>

        <!-- Cards Section -->
    <div class="schedule-news-calendar">
        <div class="cards" style="margin-top: -30px;">
            <div class="card">
                <img src="studPic/Approval.png" alt="logo" class="stud-db-logo" style="display: block; margin: 0 auto;">
                <p class="label" style="white-space: nowrap;">STATUS:</p>
                <p class="value" style="white-space: nowrap;">Enrolled</p>
            </div>
            <div class="card">
                <img src="studPic/Stack of coins.png" alt="logo" class="stud-db-logo" style="display: block; margin: 0 auto;">
                <p class="label" style="white-space: nowrap;">Total Fee:</p>
                <p class="value" style="white-space: nowrap;">123,456.78</p>
            </div>
            <div class="card" style="height: auto;">
                <img src="studPic/Books.png" alt="logo" class="stud-db-logo" style="display: block; margin: 0 auto;">
                <p class="label" style="white-space: nowrap;">Enrolled  <br>Subject</p>
            </div>
        </div>
    </div>

        <!-- Schedule and News Section -->
            <div class="cards1">
                <div class="card1">
                    <img src="studPic/Approval.png" alt="logo" style="display: block; margin: 0 auto;">
                    <p class="label" style="display: block; margin: 0 auto; text-align: center;">Schedule</p>
                </div>
                <div class="card1" style="height: auto; width: 42%;">
                    <b style="white-space: nowrap;">News and Update</b>
                    <hr style="border: 1px solid grey;">
                    <p></p>
                </div>
            </div>
            <div class="datepicker">
            <div class="datepicker-top">

                <div class="month-selector">
                    <button class="arrow"><i class="material-icons">chevron_left</i></button>
                    <span class="month-name">December 2020</span>
                    <button class="arrow"><i class="material-icons">chevron_right</i></button>
                </div>
            </div>
            <div class="datepicker-calendar">
                <span class="day">Mo</span>
                <span class="day">Tu</span>
                <span class="day">We</span>
                <span class="day">Th</span>
                <span class="day">Fr</span>
                <span class="day">Sa</span>
                <span class="day">Su</span>
                <button class="date faded">30</button>
                <button class="date">1</button>
                <button class="date">2</button>
                <button class="date">3</button>
                <button class="date">4</button>
                <button class="date">5</button>
                <button class="date">6</button>
                <button class="date">7</button>
                <button class="date">8</button>
                <button class="date current-day">9</button>
                <button class="date">10</button>
                <button class="date">11</button>
                <button class="date">12</button>
                <button class="date">13</button>
                <button class="date">14</button>
                <button class="date">15</button>
                <button class="date">16</button>
                <button class="date">17</button>
                <button class="date">18</button>
                <button class="date">19</button>
                <button class="date">20</button>
                <button class="date">21</button>
                <button class="date">22</button>
                <button class="date">23</button>
                <button class="date">24</button>
                <button class="date">25</button>
                <button class="date">26</button>
                <button class="date">27</button>
                <button class="date">28</button>
                <button class="date">29</button>
                <button class="date">30</button>
                <button class="date">31</button>
                <button class="date faded">1</button>
                <button class="date faded">2</button>
                <button class="date faded">3</button>
            </div>
        </div>
        
        </div>    
    </div>
    </div>
  </main>

</body>
</html>