<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Subject Management</title>
  <link rel="stylesheet" href="Subject_management.css">
  <!-- Add your font/icon library here if needed -->
</head>
<body>
  <?php include "admin-sidebar.php"; ?>

  <main class="main-content">
    <div class="top-bar">
      <h1 class="title">Subject Management</h1>
      <button class="add-subject-btn">+ Add New Subject</button>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Subject Code</th>
            <th>Subject Title</th>
            <th>Linked Programs</th>
            <th>Pre-requisites</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>IT101</td>
            <td>Introduction to Programming</td>
            <td>BSIT, BSCS</td>
            <td>None</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>HM201</td>
            <td>Fundamentals of Hospitality</td>
            <td>BSHM</td>
            <td>None</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>BM102</td>
            <td>Principles of Management</td>
            <td>BSBM, BSENTREP</td>
            <td>None</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>ENT203</td>
            <td>Entrepreneurial Mindset</td>
            <td>BSENTREP, BSBM</td>
            <td>None</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>OA101</td>
            <td>Office Productivity Tools</td>
            <td>BSOA, BSHM</td>
            <td>Basic Computer Skills</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>PSY101</td>
            <td>General Psychology</td>
            <td>BS Psychology</td>
            <td>None</td>
            <td>
            <button class="action-btn">
                <img src="images/edit.png" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="images/bin.png" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
    </div>
  </main>

  <!-- Modal -->
  <div id="addSubjectModal">
  <div class="modal-box">
    <button class="close-btn">&times;</button>
    <h2>Add New Subject</h2>
    <form>
      <label for="subjectCode">Subject Code</label>
      <input type="text" id="subjectCode" placeholder="Enter Subject Code" />

      <label for="subjectTitle">Subject Title</label>
      <input type="text" id="subjectTitle" placeholder="Enter Subject Title" />

      <label for="linkedPrograms">Linked Programs</label>
<select id="linkedPrograms" name="linkedPrograms">
  <option value="BSIT">BSIT</option>
  <option value="BSCS">BSCS</option>
  <option value="BSHM">BSHM</option>
  <option value="BSBM">BSBM</option>
  <option value="BSENTREP">BSENTREP</option>
  <!-- Add more options as needed -->
</select>

<label for="prerequisites">Pre-requisites</label>
<select id="prerequisites" name="prerequisites">
  <option value="None">None</option>
  <option value="Basic Math">Basic Math</option>
  <option value="Basic Computer Skills">Basic Computer Skills</option>
  <!-- Add more options as needed -->
</select>




      <div class="button-group">
        <button type="button" class="cancel-btn">Cancel</button>
        <button type="submit" class="add-btn">Add Subject</button>
      </div>
    </form>
  </div>
</div>

<div id="editSubjectModal">
  <div class="modal-box">
    <button class="close-btn">&times;</button>
    <h2>Edit Subject</h2>
    <form>
      <label for="editSubjectCode">Subject Code</label>
      <input type="text" id="editSubjectCode" value="IT101" />

      <label for="editSubjectTitle">Subject Title</label>
      <input type="text" id="editSubjectTitle" value="Introduction to Programming" />

      <label for="editLinkedPrograms">Linked Programs</label>
<select id="editLinkedPrograms" name="linkedPrograms">
  <option value="BSIT">BSIT</option>
  <option value="BSCS">BSCS</option>
  <option value="BSHM">BSHM</option>
  <option value="BSBM">BSBM</option>
  <option value="BSENTREP">BSENTREP</option>
  <!-- Add more options as needed -->
</select>

<label for="editPrerequisites">Pre-requisites</label>
<select id="editPrerequisites" name="prerequisites">
  <option value="None">None</option>
  <option value="Basic Math">Basic Math</option>
  <option value="Basic Computer Skills">Basic Computer Skills</option>
  <!-- Add more options as needed -->
</select>



      <div class="button-group">
        <button type="button" class="cancel-btn">Cancel</button>
        <button type="submit" class="save-btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>










<script>
  const addSubjectModal = document.getElementById("addSubjectModal");
const addSubjectBtn = document.querySelector(".add-subject-btn");
const closeModalBtn = document.querySelector(".close-btn");
const cancelBtn = document.querySelector(".cancel-btn");

addSubjectBtn.addEventListener("click", () => {
  addSubjectModal.style.display = "flex";
});

closeModalBtn.addEventListener("click", () => {
  addSubjectModal.style.display = "none";
});

cancelBtn.addEventListener("click", () => {
  addSubjectModal.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === addSubjectModal) {
    addSubjectModal.style.display = "none";
  }
});

const editSubjectModal = document.getElementById("editSubjectModal");
const editButtons = document.querySelectorAll(".action-btn img[alt='Edit']"); // Edit buttons
const closeEditModalBtn = editSubjectModal.querySelector(".close-btn");
const cancelEditBtn = editSubjectModal.querySelector(".cancel-btn");

// Open the modal
editButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    editSubjectModal.style.display = "flex";
  });
});

// Close the modal
closeEditModalBtn.addEventListener("click", () => {
  editSubjectModal.style.display = "none";
});

cancelEditBtn.addEventListener("click", () => {
  editSubjectModal.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === editSubjectModal) {
    editSubjectModal.style.display = "none";
  }
});



</script>


</body>
</html>
