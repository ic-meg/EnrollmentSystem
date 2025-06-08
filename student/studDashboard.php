<?php
include "../dbcon.php";
include "sessioncheck.php";

$user_id = $_SESSION['user_id'];

$hasProfile = false;

$query = "SELECT * FROM studentprofile WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hasProfile = true;
}

$user = $result->fetch_assoc();

$status = 'Unknown';
$totalFee = '0.00';

$enrolleeQuery = $conn->prepare("SELECT Status, EnrolleeID FROM enrollee WHERE user_id = ?");
if (!$enrolleeQuery) {
    die("Prepare failed (enrollee): (" . $conn->errno . ") " . $conn->error);
}
$enrolleeQuery->bind_param("i", $user_id);
$enrolleeQuery->execute();
$enrolleeResult = $enrolleeQuery->get_result();
if ($enrolleeResult->num_rows > 0) {
    $enrolleeData = $enrolleeResult->fetch_assoc();
    $status = $enrolleeData['Status'];
    $enrolleeID = $enrolleeData['EnrolleeID'];

    $feeQuery = $conn->prepare("SELECT SUM(TotalFees) AS total FROM paymentinfo WHERE user_id = ?");
    if (!$feeQuery) {
        die("Prepare failed (paymentinfo): (" . $conn->errno . ") " . $conn->error);
    }
    $feeQuery->bind_param("i", $user_id);
    $feeQuery->execute();
    $feeResult = $feeQuery->get_result();
    if ($feeResult->num_rows > 0) {
        $total = $feeResult->fetch_assoc();
        $totalFee = number_format((float)$total['total'], 2);
    }
    $feeQuery->close();
}
$enrolleeQuery->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oxford Academe | Dashboard</title>


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</head>
<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        max-width: 700px;
        width: 90%;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
        font-family: 'Montserrat', sans-serif;
    }

    .modal-content h2 {
        margin-bottom: 10px;
        font-size: 22px;
        color: #333;
    }

    .modal-content p {
        font-size: 14px;
        margin-bottom: 20px;
        color: #555;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="tel"],
    input[type="date"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .submit-btn {
        margin-top: 20px;
        background: #2DB2FF;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        display: block;
        width: 100%;
    }

    .submit-btn:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .submit-btn:hover {
        background: #2298e0;
    }

    select#relationship {
        width: 100%;
        padding: 10px 12px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 6px;
        background-color: #fff;
        font-family: 'Montserrat', sans-serif;
        transition: border-color 0.3s ease;
    }

    select#relationship:focus {
        border-color: #3F83E6;
        outline: none;
    }

    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');

    :root {
        --color: white;
        --background: #3F83E6;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    main {
        font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Welcome Banner */
    .Welcome {
        background: var(--background);
        min-height: 30vh;
        width: 100%;
        border-radius: 25px;
        padding: 20px 30px;
        color: var(--color);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .Welcome img {
        max-width: 100px;
        height: auto;
        border-radius: 50%;
    }

    .text-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
    }

    .welcome-greeting {
        font-size: 50px;
        font-weight: bold;
    }

    .message {
        font-weight: 100;
        font-size: 15px;
        margin-top: 2%;
    }

    /* Dashboard Flex Layout */
    .dashboard-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    /* Left: Status + Schedule + News */
    .left-section {
        flex: 1 1 60%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Right: Calendar */
    .right-section {
        flex: 1 1 35%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Card Containers */
    .cards,
    .cards1 {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Individual Cards */
    .card,
    .card1 {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        flex: 1 1 30%;
        min-width: 150px;
    }

    .card1 b {
        font-size: 16px;
        display: block;
        margin-bottom: 10px;
    }

    .stud-db-logo {
        max-width: 50px;
        margin: 0 auto 10px;
        display: block;
    }

    /* Calendar Styling */

    .calendar {
        font-family: Arial, sans-serif;
        padding: 10px 0;
        background-color: #f9f9f9;
        border-radius: 12px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .calendar-header button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0 10px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        text-align: center;
        font-size: 13px;
        padding: 10px 10px 10px;
        margin-top: 30px;
    }

    .calendar-grid div {
        padding: 5px;
        background: #e7f3ff;
        border-radius: 4px;
        position: relative;
    }

    .calendar-grid div.current-day::after {
        content: '';
        width: 5px;
        height: 5px;
        background-color: red;
        border-radius: 50%;
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            flex-direction: column;
        }

        .cards,
        .cards1 {
            flex-direction: column;
        }

        .card,
        .card1 {
            flex: 1 1 100%;
        }

        .right-section {
            order: 2;
        }

        .left-section {
            order: 1;
        }

        .welcome-greeting {
            font-size: 32px;
        }

        .message {
            font-size: 13px;
        }

        .Welcome {
            flex-direction: column;
            text-align: center;
        }

        .Welcome img {
            max-width: 80px;
        }
    }

    /* Medium screens (tablets) */
    @media (min-width: 601px) and (max-width: 1024px) {

        .cards,
        .cards1 {
            justify-content: center;
        }

        .card,
        .card1 {
            width: 45%;
            margin: 2.5%;
        }

        .welcome-greeting {
            font-size: 40px;
        }
    }
</style>

<body>
    <?php include "stud-sidebar.php"; ?>

    <!-- Student Info Modal -->
    <?php if (!$hasProfile): ?>
        <div id="infoModal" class="modal-overlay">
            <div class="modal-content">
                <h2>Complete Your Student Profile</h2>
                <p>Please fill out all required information below to proceed.</p>
                <p><strong style="font-size: 13px; color: #e53935; margin-bottom: 8px;">*</strong> indicates required fields.</p>

                <form id="studentInfoForm">
                    <script>
                        document.getElementById("studentInfoForm").addEventListener("submit", function(e) {
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch("insert_profile.php", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(res => res.text())
                                .then(data => {
                                    if (data.includes("success")) {
                                        window.location.href = "studDashboard.php";
                                    } else {
                                        alert("Something went wrong.");
                                    }
                                })

                                .catch(err => {
                                    console.error("Error:", err);
                                    alert("An error occurred while submitting your profile.");
                                });
                        });
                    </script>
                    <div class="form-grid">
                        <!-- Personal Info -->
                        <div class="form-group">
                            <label>* Last Name</label>
                            <input type="text" name="lastName" required />
                        </div>
                        <div class="form-group">
                            <label>* First Name</label>
                            <input type="text" name="firstName" required />
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middleName" />
                        </div>
                        <div class="form-group">
                            <label>* Birthdate</label>
                            <input type="date" name="birthdate" id="birthdate" required />
                        </div>
                        <div class="form-group">
                            <label>* Place of Birth</label>
                            <input type="text" name="birthplace" required />
                        </div>
                        <div class="form-group">
                            <label>* Age</label>
                            <input type="number" name="age" id="age" readonly required min="1" />
                        </div>
                        <div class="form-group">
                            <label>* Phone</label>
                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                maxlength="11"
                                pattern="^[0-9]{11}$"
                                title="Phone number must be exactly 11 digits (numbers only)"
                                required />
                            <script>
                                document.getElementById("phone").addEventListener("input", function(e) {
                                    this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
                                    if (this.value.length > 11) {
                                        this.value = this.value.slice(0, 11); // Ensure max length of 11
                                    }
                                });
                            </script>
                        </div>
                        <!-- Emergency Info -->
                        <div class="form-group">
                            <label>* Guardian Name</label>
                            <input type="text" name="guardianName" required />
                        </div>
                        <div class="form-group">
                            <label>* Guardian Contact No.</label>
                            <input
                                type="tel"
                                name="guardianContact"
                                id="guardianContact"
                                maxlength="11"
                                pattern="^[0-9]{11}$"
                                title="Contact number must be exactly 11 digits (numbers only)"
                                required />
                        </div>
                        <div class="form-group full">
                            <label>* Relationship</label>

                            <select name="relationship" id="relationship" required>
                                <option value="" disabled selected>Select relationship</option>
                                <option value="Parent">Parent</option>
                                <option value="Guardian">Guardian</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Relative">Relative</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submit-btn" disabled>Submit</button>
                </form>
            <?php endif; ?>
            </div>
        </div>

        </div>

        <main>
            <div class="container">
                <div class="Welcome">
                    <img src="studPic/image1.png" alt="logo">
                    <div class="text-content">
                        <div class="welcome-greeting">Hi, <?php echo htmlspecialchars($user['first_name']); ?>!</div>
                        <div class="message">Always stay updated in your profile</div>
                    </div>
                </div>

                <!-- Responsive Flex Layout -->
                <div class="dashboard-wrapper">
                    <!-- Left Section: Status + Schedule + News -->
                    <div class="left-section">
                        <div class="cards">
                            <div class="card">
                                <img src="studPic/Approval.png" alt="logo" class="stud-db-logo">
                                <p class="label">STATUS:</p>
                                <p class="value"><?php echo htmlspecialchars($status); ?></p>

                            </div>
                            <div class="card">
                                <img src="studPic/Stack of coins.png" alt="logo" class="stud-db-logo">
                                <p class="label">Total Fee:</p>
                                <p class="value"><?php echo $totalFee; ?></p>

                            </div>
                            <div class="card">
                                <img src="studPic/Books.png" alt="logo" class="stud-db-logo">
                                <p class="label">Enrolled <br>Subject</p>
                            </div>
                        </div>

                        <!-- Schedule and News -->
                        <div class="cards1">
                            <div class="card1">
                                <img src="studPic/Approval.png" alt="logo" class="stud-db-logo">
                                <p class="label" style="text-align: center;">Schedule</p>
                            </div>
                            <div class="card1">
                                <b>News and Update</b>
                                <hr style="border: 1px solid grey;">
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section: Calendar -->
                    <div class="calendar">
                        <div class="calendar-header">
                            <button id="prevBtn">‹</button>
                            <span id="monthYear"></span>
                            <button id="nextBtn">›</button>
                        </div>
                        <div class="calendar-grid">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                            <!-- The dates will go here -->
                        </div>
                    </div>

                </div>
            </div>
        </main>



        <script>
            function validateFormFields() {
                const requiredFields = document.querySelectorAll("#studentInfoForm input[required]");
                let allFilled = Array.from(requiredFields).every(input => input.value.trim() !== "");
                document.getElementById("submit-btn").disabled = !allFilled;
            }


            document.querySelectorAll("#studentInfoForm input[required]").forEach(input => {
                input.addEventListener("input", validateFormFields);
            });

            document.getElementById("birthdate").addEventListener("change", function() {
                const birthdate = new Date(this.value);
                const today = new Date();

                let age = today.getFullYear() - birthdate.getFullYear();
                const m = today.getMonth() - birthdate.getMonth();

                if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
                    age--;
                }

                if (age < 18) {
                    alert("Age must be at least 18 years old.");
                    document.getElementById("birthdate").value = "";
                    document.getElementById("age").value = "";
                } else {
                    document.getElementById("age").value = age;
                }
            });
            const guardianInput = document.getElementById("guardianContact");

            guardianInput.addEventListener("input", function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
            });
            const phoneInput = document.getElementById("phone");

            phoneInput.addEventListener("input", function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
            });
        </script>

        <script>
            const calendarGrid = document.querySelector(".calendar-grid");
            const monthYear = document.getElementById("monthYear");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            let currentDate = new Date();

            function renderCalendar(date) {
                const year = date.getFullYear();
                const month = date.getMonth();
                const today = new Date();

                const firstDayOfMonth = new Date(year, month, 1);
                const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
                const startDay = firstDayOfMonth.getDay();

                // Keep weekday headers (first 7 elements), remove the rest
                while (calendarGrid.children.length > 7) {
                    calendarGrid.removeChild(calendarGrid.lastChild);
                }

                monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

                // Add blank cells before the 1st of the month
                for (let i = 0; i < startDay; i++) {
                    const blank = document.createElement("div");
                    blank.innerHTML = "&nbsp;";
                    calendarGrid.appendChild(blank);
                }

                // Add days of the month
                for (let day = 1; day <= lastDateOfMonth; day++) {
                    const dateEl = document.createElement("div");
                    dateEl.textContent = day;

                    const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    if (isToday) {
                        dateEl.classList.add("current-day");
                    }

                    calendarGrid.appendChild(dateEl);
                }
            }

            renderCalendar(currentDate);

            prevBtn.onclick = () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            };

            nextBtn.onclick = () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            };
        </script>

</body>
<?php if (isset($_SESSION['success'])): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $_SESSION['success'] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.show();
        }
    </script>


    <?php unset($_SESSION['success']); ?>
<?php endif; ?>


</html>