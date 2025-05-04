<?php 
    include "session_check.php";

?>

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
  <main> 
  </div>
  </div>
  <br>
  <br>
  <main class="main-content">
    <div class="top-bar">
      <h1 class="title">Subject Schedule Management</h1>
      <button class="add-subject-btn">+ Add New Subject</button>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Schedule ID</th>
            <th>Subject ID</th>
            <th>Section</th>
            <th>Day</th>
            <th>Time Start</th>
            <th>Time End</th>
            <th>Room</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>IT101</td>
            <td>D</td>
            <td>WTH</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>Room 100</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td>HM201</td>
            <td>A</td>
            <td>TTH	</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>CL 5</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td>BM102</td>
            <td>A</td>
            <td>MW</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>Room 101</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td>ENT203</td>
            <td>A</td>
            <td>T</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>Room 57</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td>OA101</td>
            <td>B</td>
            <td>TTH	</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>Room 5</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
              </button>
            </td>
          </tr>
          <tr>
            <td>1</td>  
            <td>PSY101</td>
            <td>C</td>
            <td>TTH	</td>
            <td>8:00</td>
            <td>10:00</td>
            <td>Room 5</td>
            <td>
            <button class="action-btn">
                <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
              </button>
              <button class="action-btn">
                <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
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
    <h2>Add New Subject Schedule</h2>
    <form>
      <label for="subjectCode">Subject ID</label>
      <input type="text" id="subjectCode" placeholder="Enter Subject ID" />

      <label for="subjectTitle">Section</label>
      <input type="text" id="subjectTitle" placeholder="Enter Section" />

      <label for="editDay">Day</label>
        <select id="editDay" name="Day">
        <option value="M">Monday</option>
        <option value="T">Tuesday</option>
        <option value="W">Wednesday</option>
        <option value="TH">Thursday</option>
        <option value="F">Friday</option>
        <!-- Add more options as needed -->
        </select>

    <label for="timestart">Time Start</label>
        <select id="start" name="prerequisites">
        <option value="None">8:00</option>
        <option value="Basic Math">9:00</option>
        <option value="10:00">10:00</option>
        <!-- Add more options as needed -->
        </select>

    <label for="end">Time End</label>
        <select id="end" name="end">
        <option value="None">11:00</option>
        <option value="Basic Math">12:00</option>
        <option value="10:00">13:00</option>
        <!-- Add more options as needed -->
        </select>

        <label for="room">Room</label>
        <input type="text" id="room" placeholder="Enter Room No." />


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
      <label for="editSubjectID">Subject ID</label>
      <input type="text" id="editSubjectID" value="IT101" />

      <label for="editSection">Section</label>
      <input type="text" id="editSection" value="A" />

      <label for="editDay">Day</label>
        <select id="editDay" name="Day">
            <option value="M">Monday</option>
            <option value="T">Tuesday</option>
            <option value="W">Wednesday</option>
            <option value="TH">Thursday</option>
            <option value="F">Friday</option>
  <!-- Add more options as needed -->
</select>

    <label for="timestart">Time Start</label>
        <select id="start" name="prerequisites">
            <option value="None">8:00</option>
            <option value="Basic Math">9:00</option>
            <option value="10:00">10:00</option>
         
        </select>

        <label for="end">Time End</label>
            <select id="end" name="end">
            <option value="None">11:00</option>
            <option value="Basic Math">12:00</option>
            <option value="10:00">13:00</option>
       
            </select>

        <label for="room">Room</label>
        <input type="text" id="room" placeholder="Enter Room No." />


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
