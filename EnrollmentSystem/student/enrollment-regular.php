<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="enrollment-regular.css">
  <title>Oxford Academe | Enrollment Form - Freshmen </title>
</head>
<style>
    .content-wrapper {
    display: flex; /* Align sidebar and form horizontally */
    justify-content: space-between; /* Distribute space evenly between the sidebar and form */
}

.Form-regular {
    margin-top: 50px;
    flex: 2; /* The form will take up more space */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;


}

.side--container{
    /* background-color: #2db2ff; */
}
</style>
<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
        <div class="container">
            <div class="header">
                <h1>Student Enrollment</h1>
            </div>
        <!-- Content Wrapper -->
        <div class="content-wrapper">
                
                <!-- Sidebar -->
                <div class="side--container">
            
                        <div class="regular">
                            <p>Freshmen</p>
                            <p>Transferee</p>
                            <p>Returnee</p>
                            <p>Non-sequential Students</p>
                        </div>
                        </div>

                        <!-- Main Form -->
                        <div class="Form-regular" style="background-color: #f9f9f9;">
                        <p class="description">Regular Application</p>
                        <p class="description--1">
                            Please complete the application form below to apply as a regular student at our institution. Thank you!
                        </p>
                        
                        <form>
                            <div class="form-section">
                            <!-- Name Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first-name">First Name</label>
                                    <input type="text" id="first-name" name="first-name">
                                </div>
                                <div class="form-group">
                                    <label for="middle-initial">Middle Initial</label>
                                    <input type="text" id="middle-initial" name="middle-initial">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" id="last-name" name="last-name">
                                </div>
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" id="suffix" name="suffix">
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob">
                                </div>
                                <div class="form-group">
                                    <label for="sex">Sex</label>
                                    <select id="sex" name="sex">
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email">
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="address">Street Address</label>
                                    <input type="text" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" id="province" name="province">
                                </div>
                                <div class="form-group">
                                    <label for="zip-code">Zip Code</label>
                                    <input type="text" id="zip-code" name="zip-code">
                                </div>
                            </div>

                            <!-- Program Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="program">Program</label>
                                    <select id="program" name="program">
                                        <option value="">Select a program</option>
                                        <option value="program1">Program 1</option>
                                        <option value="program2">Program 2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="form-137">Form 137</label>
                                    <input type="file" id="form-137" name="form-137">
                                </div>
                                <div class="form-group">
                                    <label for="form-138">Form 138</label>
                                    <input type="file" id="form-138" name="form-138">
                                </div>
                                <div class="form-group">
                                    <label for="picture">1x1 Picture</label>
                                    <input type="file" id="picture" name="picture">
                                </div>
                            </div>

                            <!-- Submit Section -->
                            <!-- <div class="form-actions"> -->
                            <button type="submit"> <a href="stud-summary.php" style="color: white;">Submit</a></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </main>


</body>
</html>
