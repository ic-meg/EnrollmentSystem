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

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">

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
                            alert(data); 
                            window.location.reload(); 
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
                        <input type="text" name="middleName"  />
                    </div>
                    <div class="form-group">
                        <label>* Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate"required />
                    </div>
                    <div class="form-group">
                        <label>* Place of Birth</label>
                        <input type="text" name="birthplace" required />
                    </div>
                    <div class="form-group">
                        <label>* Age</label>
                        <input type="number" name="age" id="age" readonly required min="1"/>
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
                            required
                        />
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
                            required
                        />
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
    </div>
    </div>
        <!-- WAG TANGGALIN MAIN AT CONTAINER-->
        <div class="container">
        <!--Content here-->
            <div class="Welcome">
                <img src="studPic/image1.png" alt="logo">
                <div class="text-content">
                    <div class="welcome-greeting">Hi, <?php echo htmlspecialchars($user['first_name']); ?>!</div>
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

    document.getElementById("birthdate").addEventListener("change", function () {
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

    guardianInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 11); 
    });
    const phoneInput = document.getElementById("phone");

    phoneInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
    </script>
</body>
</html>