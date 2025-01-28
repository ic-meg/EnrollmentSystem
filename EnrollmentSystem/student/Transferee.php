<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe | Enrollment Form - Transferee</title>
</head>
<style>
  :root {
    --color: #000;
    --background: #2DB2FF;
    --txt-color: #B6B1B1;
    --secondary-color: white;
    --line-color:#777777;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; 
    font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .content-wrapper {
    display: flex; /* Align sidebar and form horizontally */
    justify-content: space-between; /* Distribute space evenly */
  }

  .header {
    text-align: center;
    padding: 20px;
  }

  .side--container {
    background: #DADADA;
    display: flex;
    flex-direction: column;
    width: 20%;
    margin-top: 50px;
    padding-left: 20px;
  }

  .side--container .regular p {
    margin: 10px 10px;
    padding: 10px;
    background: var(--secondary-color);
    color: var(--color);
    text-align: center;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .side--container .regular p:hover {
    background: var(--line-color);
    color: var(--secondary-color);
  }

  .Form-regular {
    margin-top: 50px;
    flex: 2;
    padding: 20px;
    background-color: var(--secondary-color);
    border-radius: 8px;
    overflow-y: auto;
  }

  .form-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }

  .form-group {
    flex: 1;
    min-width: 200px;
  }

  input, select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--line-color);
    border-radius: 4px;
    margin-bottom: 10px;
  }

  button {    
    padding: 10px 20px;
    background: var(--background);
    color: var(--secondary-color);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  button:hover {
    background: #005a9e;
  }

  @media (max-width: 768px) {
    .content-wrapper {
        flex-direction: column;
    }

    .side--container {
        width: 100%;
    }

    .Form-regular {
        width: 100%;
    }
  }
</style>
<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
    <div class="container">
      <div class="header">
        <h1>Student Enrollment</h1>
      </div>

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

        <!-- Transferee Form -->
        <div class="Form-regular">
          <p class="description">Transferee Application</p>
          <p class="description--1">
            Please complete the application form below to apply as a transferee at our institution. Ensure that you attach all required documents.
          </p>

          <form>
            <div class="form-section">
              <!-- Name Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name">First Name</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name">
                </div>
                <div class="form-group">
                  <label for="middle-initial">Middle Initial</label> 
                  <input type="text" id="middle-initial" name="middle-initial" placeholder="M.I.">
                </div>
                <div class="form-group">
                  <label for="last-name">Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name">
                </div>
              </div>

              <!-- Contact Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="contact-number">Contact Number</label>
                  <input type="text" id="contact-number" name="contact-number" placeholder="Enter your contact number">
                </div>
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input type="email" id="email" name="email" placeholder="Enter your email address">
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
              </div>

              <!-- Previous School Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="prev-school">Previous School</label>
                  <input type="text" id="prev-school" name="prev-school" placeholder="Enter your previous school">
                </div>
                <div class="form-group">
                  <label for="prev-program">Previous Program</label>
                  <input type="text" id="prev-program" name="prev-program" placeholder="Enter your previous program">
                </div>
              </div>

              <!-- Academic Preferences -->
              <div class="form-row">
                <div class="form-group">
                  <label for="intended-course">Intended Course</label>
                  <select id="intended-course" name="intended-course">
                    <option value="">Select</option>
                    <option value="course1">Information Technology</option>
                    <option value="course2">Psychology</option>
                  </select>
                </div>
              </div>

              <!-- Guardian Information -->
              <div class="form-row">
                <div class="form-group">
                  <label for="guardian-name">Guardian's Name</label>
                  <input type="text" id="guardian-name" name="guardian-name" placeholder="Enter guardian's name">
                </div>
                <div class="form-group">
                  <label for="guardian-contact">Guardian's Contact</label>
                  <input type="text" id="guardian-contact" name="guardian-contact" placeholder="Enter guardian's contact number">
                </div>
              </div>

              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="tor">Transcript of Records (TOR)</label>
                  <input type="file" id="tor" name="tor">
                </div>
                <div class="form-group">
                  <label for="good-moral">Certificate of Good Moral</label>
                  <input type="file" id="good-moral" name="good-moral">
                </div>
              </div>

              <!-- Submit Section -->
              <div class="form-actions">
                <button type="submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
