<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Profile and Notifications Dropdowns</title>
	<link rel="stylesheet" href="header-style.css">
  <link rel="stylesheet" href="notif-drop.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  
</head>
<style>
.notification_dd ul{
  padding: 0;
  list-style-type:  none;
}
</style>
<body>

  <div class="navbar">
    <div class="navbar_left">
    </div>
    <div class="group">
      <svg class="icon"  aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
      <input placeholder="Search" type="search" class="input"> 
    </div>
    <div class="navbar_right">
      <div class="notifications">
        <div class="icon_wrap">
          <svg class="notif-icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
            <path d="M21.636,17.869c-0.016-0.016-1.581-1.635-1.581-3.952v-2.9c0-3.996-2.957-7.309-6.806-7.91V2.25C13.25,1.56,12.69,1,12,1 s-1.25,0.56-1.25,1.25v0.857c-3.849,0.601-6.806,3.914-6.806,7.91v2.9c0,2.317-1.565,3.936-1.576,3.947 c-0.359,0.357-0.467,0.895-0.274,1.363C2.288,19.695,2.744,20,3.25,20H9c0,1.657,1.343,3,3,3s3-1.343,3-3h5.75 c0.503,0,0.956-0.305,1.15-0.77C22.095,18.766,21.989,18.228,21.636,17.869z"></path>
          </svg>
        </div>
        <!-- Dropdown -->
        <div class="notification_dd">
            <ul class="notification_ul">
                <!-- Header inside the dropdown -->
                <div class="notification_header">
                  <div class="notification_left">
                    <span>Notifications</span>
                  </div>
                  <div class="notification_right">
                    <button class="mark-all-read">
                      <i class="fas fa-check-double"></i> 
                      Mark all as read
                    </button>
                  </div>
                </div>
                <div class="notification_dd_body">
                  <ul>
                      <!-- Unread Notification -->
                      <li class="unread">
                          <div class="left">
                              <span class="status-dot"></span>
                              <div class="message-content">
                                  <p class="message">A new enrollee has submitted their documents for review.</p>
                                  <p class="date">December 9, 2024</p>
                              </div>
                          </div>
                          <div class="right">
                              <div class="circle-icon">
                                  <!-- SVG Icon Placeholder -->
                                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256"
                                  style="fill:#1A1A1A;">
                                  <g fill="#fafafa" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M0,7v2.78125c3.012,2.622 20.29902,17.66933 21.66602,18.86133c1.406,1.225 2.79998,1.35742 3.33398,1.35742c0.534,0 1.92798,-0.13242 3.33398,-1.35742c1.418,-1.236 19.71202,-17.15642 21.66602,-18.85742v-2.78516zM0,12.43164v25.09375l15.11523,-11.93555c-4.901,-4.267 -11.88423,-10.3452 -15.11523,-13.1582zM50,12.43555c-3.051,2.655 -10.14423,8.82925 -15.11523,13.15625l5.36133,4.21875c0.154,-0.357 0.37973,-0.68861 0.67773,-0.97461c1.195,-1.146 3.09324,-1.10711 4.24023,0.08789l4.83594,5.03906zM16.65039,26.92578l-16.65039,13.14844v2.92578h28c0,-4.963 4.038,-9 9,-9h4.7207l-0.88477,-0.92383c-0.246,-0.256 -0.4255,-0.54752 -0.5625,-0.85352l-6.92383,-5.29492c-1.937,1.686 -3.34717,2.91366 -3.70117,3.22266c-1.918,1.669 -3.88944,1.84961 -4.64844,1.84961c-0.759,0 -2.73144,-0.18156 -4.64844,-1.85156c-0.351,-0.306 -1.76017,-1.53266 -3.70117,-3.22266zM43.00977,29.99023c-0.40608,-0.00706 -0.77611,0.23216 -0.93635,0.60535c-0.16025,0.37319 -0.07889,0.80624 0.20588,1.09582l4.13281,4.30859h-9.41211c-3.85433,0 -7,3.14567 -7,7c0,3.85433 3.14567,7 7,7h10v-2h-10c-2.77367,0 -5,-2.22633 -5,-5c0,-2.77367 2.22633,-5 5,-5h9.41211l-4.13281,4.30859c-0.26965,0.25309 -0.37762,0.63432 -0.28074,0.99122c0.09688,0.3569 0.38281,0.6312 0.74342,0.7132c0.36061,0.082 0.73704,-0.0417 0.97872,-0.32161l6.42188,-6.69141l-6.42187,-6.69141c-0.18421,-0.19784 -0.44067,-0.31268 -0.71094,-0.31836z"></path></g></g>
                                  </svg>
                              </div>
                          </div>
                      </li>
                    <!-- Unread Notification -->
                    <li class="unread">
                          <div class="left">
                              <span class="status-dot"></span>
                              <div class="message-content">
                                  <p class="message">Payment of ₱5,000 received 
                                  from John Doe.</p>
                                  <p class="date">December 9, 2024</p>
                              </div>
                          </div>
                          <div class="right">
                              <div class="circle-icon" style="background-color: #4DD44D;">
                                  <!-- SVG Icon Placeholder -->
                                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0,0,256,256"
                                  style="fill:#1A1A1A;">
                                  <g fill="#fafafa" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M12,2c-5.523,0 -10,4.477 -10,10c0,5.523 4.477,10 10,10c5.523,0 10,-4.477 10,-10c0,-5.523 -4.477,-10 -10,-10zM17.707,9.707l-7,7c-0.195,0.195 -0.451,0.293 -0.707,0.293c-0.256,0 -0.512,-0.098 -0.707,-0.293l-3,-3c-0.391,-0.391 -0.391,-1.023 0,-1.414c0.391,-0.391 1.023,-0.391 1.414,0l2.293,2.293l6.293,-6.293c0.391,-0.391 1.023,-0.391 1.414,0c0.391,0.391 0.391,1.023 0,1.414z"></path></g></g>
                                  </svg>
                              </div>
                          </div>
                      </li>
                      <!-- Read Notification -->
                      <li class="read">
                          <div class="left">
                              <div class="message-content">
                                  <p class="message">You have 3 new documents that need verification for enrollment applications.</p>
                                  <p class="date">December 8, 2024</p>
                              </div>
                          </div>
                          <div class="right">
                              <div class="circle-icon">
                                  <!-- SVG Icon Placeholder -->
                                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0,0,256,256"
                                  style="fill:#1A1A1A;">
                                  <g fill="#fafafa" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M12,2c-5.523,0 -10,4.477 -10,10c0,5.523 4.477,10 10,10c5.523,0 10,-4.477 10,-10c0,-5.523 -4.477,-10 -10,-10zM17.707,9.707l-7,7c-0.195,0.195 -0.451,0.293 -0.707,0.293c-0.256,0 -0.512,-0.098 -0.707,-0.293l-3,-3c-0.391,-0.391 -0.391,-1.023 0,-1.414c0.391,-0.391 1.023,-0.391 1.414,0l2.293,2.293l6.293,-6.293c0.391,-0.391 1.023,-0.391 1.414,0c0.391,0.391 0.391,1.023 0,1.414z"></path></g></g>
                                  </svg>
                              </div>
                          </div>
                      </li>

                  </ul>
              </div>
            </ul>
            <ul>
                <li class="show_all">
                    <p class="link">View all notifications</p>
                </li> 
            </ul>
        </div>
      </div>
    </div>
  </div>
<!-- VIEW ALL NOTIF -->
  <div class="popup">
    <div class="shadow"></div>
      <div class="inner_popup">
        <div class="notification_dd">
            <ul class="notification_ul">
                <li class="title">
                    <p>All Notifications</p>
                    <p class="close"><i class="fas fa-times" aria-hidden="true"></i></p>
                </li> 
                <div class="full_notifications">
    <!-- Header -->
    <!-- Notifications List -->
    <ul class="notifications_list">
        <!-- Example of a Success Notification -->
        <li class="read success">
            <div class="left">
                <div class="message-content">
                    <p class="message">Congratulations! Your application has been approved. You can now proceed with the next steps.</p>
                    <p class="date">December 8, 2024</p>
                </div>
            </div>
            <div class="right">
                <div class="circle-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0,0,256,256"
                        style="fill:#1A1A1A;">
                          <g fill="#fafafa" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M0,7v2.78125c3.012,2.622 20.29902,17.66933 21.66602,18.86133c1.406,1.225 2.79998,1.35742 3.33398,1.35742c0.534,0 1.92798,-0.13242 3.33398,-1.35742c1.418,-1.236 19.71202,-17.15642 21.66602,-18.85742v-2.78516zM0,12.43164v25.09375l15.11523,-11.93555c-4.901,-4.267 -11.88423,-10.3452 -15.11523,-13.1582zM50,12.43555c-3.051,2.655 -10.14423,8.82925 -15.11523,13.15625l5.36133,4.21875c0.154,-0.357 0.37973,-0.68861 0.67773,-0.97461c1.195,-1.146 3.09324,-1.10711 4.24023,0.08789l4.83594,5.03906zM16.65039,26.92578l-16.65039,13.14844v2.92578h28c0,-4.963 4.038,-9 9,-9h4.7207l-0.88477,-0.92383c-0.246,-0.256 -0.4255,-0.54752 -0.5625,-0.85352l-6.92383,-5.29492c-1.937,1.686 -3.34717,2.91366 -3.70117,3.22266c-1.918,1.669 -3.88944,1.84961 -4.64844,1.84961c-0.759,0 -2.73144,-0.18156 -4.64844,-1.85156c-0.351,-0.306 -1.76017,-1.53266 -3.70117,-3.22266zM43.00977,29.99023c-0.40608,-0.00706 -0.77611,0.23216 -0.93635,0.60535c-0.16025,0.37319 -0.07889,0.80624 0.20588,1.09582l4.13281,4.30859h-9.41211c-3.85433,0 -7,3.14567 -7,7c0,3.85433 3.14567,7 7,7h10v-2h-10c-2.77367,0 -5,-2.22633 -5,-5c0,-2.77367 2.22633,-5 5,-5h9.41211l-4.13281,4.30859c-0.26965,0.25309 -0.37762,0.63432 -0.28074,0.99122c0.09688,0.3569 0.38281,0.6312 0.74342,0.7132c0.36061,0.082 0.73704,-0.0417 0.97872,-0.32161l6.42188,-6.69141l-6.42187,-6.69141c-0.18421,-0.19784 -0.44067,-0.31268 -0.71094,-0.31836z"></path></g></g>
                    </svg>
                </div>
            </div>
        </li>

        <!-- Example of a Failed Notification -->
        <li class="read failed">
            <div class="left">
                <div class="message-content">
                    <p class="message">Your application has been rejected due to missing documents.</p>
                    <p class="date">December 7, 2024</p>
                </div>
            </div>
            <div class="right">
                <div class="circle-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0,0,256,256"
                        style="fill:#1A1A1A;">
                        <g fill="#fafafa" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M12,2c-5.523,0 -10,4.477 -10,10c0,5.523 4.477,10 10,10c5.523,0 10,-4.477 10,-10c0,-5.523 -4.477,-10 -10,-10zM17.707,9.707l-7,7c-0.195,0.195 -0.451,0.293 -0.707,0.293c-0.256,0 -0.512,-0.098 -0.707,-0.293l-3,-3c-0.391,-0.391 -0.391,-1.023 0,-1.414c0.391,-0.391 1.023,-0.391 1.414,0l2.293,2.293l6.293,-6.293c0.391,-0.391 1.023,-0.391 1.414,0c0.391,0.391 0.391,1.023 0,1.414z"></path></g></g>
                    </svg>
                </div>
            </div>
        </li>
      
    </ul>
</div>

  
</div>
<script type="text/javascript" src="notif.js" defer></script>
<script>

    const toggleButton = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.querySelector('.navbar'); 

    function toggleSidebar() {
      sidebar.classList.toggle('close');
      toggleButton.classList.toggle('rotate');


      navbar.classList.toggle('close', sidebar.classList.contains('close'));

      closeAllSubMenus();
    }

    function toggleSubMenu(button) {
      if (!button.nextElementSibling.classList.contains('show')) {
        closeAllSubMenus();
      }

      button.nextElementSibling.classList.toggle('show');
      button.classList.toggle('rotate');

      if (sidebar.classList.contains('close')) {
        sidebar.classList.toggle('close');
        toggleButton.classList.toggle('rotate');
      }
    }

    function closeAllSubMenus() {
      Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
        ul.classList.remove('show');
        ul.previousElementSibling.classList.remove('rotate');
      });
    }
  </script>

</body>
</html>
