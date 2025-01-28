<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="enrollment-returnee.css">
  <title>Oxford Academe | Enrollment Form - Returnee</title>
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
    resize: none; /* Prevent resizing */
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

        <!-- Returnee Form -->
        <div class="Form-regular">
          <p class="description">Returnee Application</p>
          <p class="description--1">
            Please complete the application form below to apply as a returnee student. Ensure that you attach all required documents.
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

              <!-- Return Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="last-enrollment">Last Enrollment Date</label>
                  <input type="date" id="last-enrollment" name="last-enrollment">
                </div>
                <div class="form-group">
                  <label for="reason">Reason for Returning</label>
                  <textarea id="reason" name="reason" placeholder="State your reason for returning" rows="4"></textarea>
                </div>
              </div>

              <!-- Additional Fields -->
              <div class="form-row">
                <div class="form-group">
                  <label for="prev-course">Previous Course/Program</label>
                  <input type="text" id="prev-course" name="prev-course" placeholder="Enter your previous course or program">
                </div>
                <div class="form-group">
                  <label for="expected-graduation">Expected Graduation Date</label>
                  <input type="date" id="expected-graduation" name="expected-graduation">
                </div>
              </div>

              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="transcript">Transcript of Records</label>
                  <input type="file" id="transcript" name="transcript">
                </div>
                <div class="form-group">
                  <label for="clearance">Clearance Certificate</label>
                  <input type="file" id="clearance" name="clearance">
                </div>
                <div class="form-group">
                  <label for="id-photo">ID Photo</label>
                  <input type="file" id="id-photo" name="id-photo">
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
