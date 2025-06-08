<?php 
include "session_check.php";
include "../dbcon.php";
include "permissions.php"; 

$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$start = ($page - 1) * $perPage;

$subjectsResult = mysqli_query($conn, "SELECT SubjID, SubCode FROM subject");
if (!$subjectsResult) {
  die("Query failed: " . mysqli_error($conn));
}

$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM schedule");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $perPage);

$query = "
  SELECT schedule.*, subject.SubCode 
  FROM schedule 
  JOIN subject ON schedule.SubID = subject.SubjID 
  LIMIT $start, $perPage
";

$schedules = mysqli_query($conn, $query);

if (!$schedules) {
  die("Schedule query failed: " . mysqli_error($conn));
}

// Only allow modifications if user has edit permissions
if (canEdit()) {
    if (isset($_POST['addSchedule'])) {
        $SubCode = $_POST['SubCode'];
        $Section = $_POST['Section'];
        $Day = $_POST['Day'];
        $Start = $_POST['start'];
        $End = $_POST['end'];
        $Room = $_POST['room'];

        $insertQuery = "INSERT INTO schedule (SubID, Section, Day, TimeStart, TimeEnd, Room) VALUES (?,?,?,?,?,?)";

        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ssssss", $SubCode, $Section, $Day, $Start, $End, $Room);
        mysqli_stmt_execute($stmt);

        header("Location: ScheduleManagement.php?success=1");
        exit();
    }

    if (isset($_POST['updateSched'])) {
        $editSubCode = $_POST['editSubCode'];
        $editSection = $_POST['editSection'];
        $editDay = $_POST['editDay'];
        $editStart = $_POST['editStart'];
        $editEnd = $_POST['editEnd'];
        $editRoom = $_POST['editRoom'];
        $editSchedID = $_POST['editSchedID'];

        $updateQuery = "UPDATE schedule SET SubID = ?, Section = ?, Day = ?, TimeStart = ?, TimeEnd = ?, Room = ? WHERE SchedID = ?";

        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssssssi", $editSubCode, $editSection, $editDay, $editStart, $editEnd, $editRoom, $editSchedID);
        mysqli_stmt_execute($stmt);

        header("Location: ScheduleManagement.php?success=1");
        exit();
    }

    if (isset($_POST['deleteSched'])) {
        $deleteID = $_POST['deleteSchedID'];
        $deleteQuery = "DELETE FROM schedule WHERE SchedID = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $deleteID);
        mysqli_stmt_execute($stmt);

        header("Location: ScheduleManagement.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Subject Management</title>
  <link rel="stylesheet" href="Subject_management.css">
</head>
<style>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    /* default hidden */
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
    /* semi-transparent backdrop */
    z-index: 1000;
  }

  .modal-box {
    background-color: white;
    padding: 2rem;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }
  
  /* Style for view-only mode */
  .view-only-btn {
    cursor: not-allowed;
    opacity: 0.6;
  }
  .view-only-btn:hover {
    background-color: transparent !important;
  }
</style>

<body>
  <?php include "admin-sidebar.php"; ?>
  <main>
    </div>
    </div>
    <main class="main-content">
      <div class="top-bar">
        <h1 class="title">Subject Schedule Management</h1>
        <div>
          <?php if (canEdit()): ?>
          <form action="import_schedule.php" method="POST" enctype="multipart/form-data" style="display: inline-block;">
            <label class="btn btn-sm btn-outline-secondary me-2" style="cursor: pointer;">
              📁 Import
              <input type="file" name="import_file" accept=".xlsx" hidden onchange="this.form.submit()">
            </label>
          </form>
          <button class="add-subject-btn btn btn-sm btn-outline-primary">+ Add New Schedule</button>
          <?php endif; ?>
        </div>
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
              <?php if (canEdit()): ?>
              <th>Action</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($schedules) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($schedules)): ?>
                <tr>
                  <td><?= $row['SchedID'] ?></td>
                  <td><?= $row['SubCode'] ?></td>
                  <td><?= $row['Section'] ?></td>
                  <td><?= $row['Day'] ?></td>
                  <td><?= $row['TimeStart'] ?></td>
                  <td><?= $row['TimeEnd'] ?></td>
                  <td><?= $row['Room'] ?></td>
                  <?php if (canEdit()): ?>
                  <td>
                    <button class="action-btn edit-btn"
                      data-schedid="<?= $row['SchedID'] ?>"
                      data-subid="<?= $row['SubID'] ?>"
                      data-section="<?= $row['Section'] ?>"
                      data-day="<?= $row['Day'] ?>"
                      data-start="<?= $row['TimeStart'] ?>"
                      data-end="<?= $row['TimeEnd'] ?>"
                      data-room="<?= $row['Room'] ?>">
                      <img src="adminPic/EditPen.svg" alt="Edit" class="icon-btn">
                    </button>
                    <button class="action-btn delete-btn" data-schedid="<?= $row['SchedID'] ?>">
                      <img src="adminPic/Trash_Full.svg" alt="Delete" class="icon-btn">
                    </button>
                  </td>
                  <?php endif; ?>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="<?= canEdit() ? '8' : '7' ?>">No schedules found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php
      $startItem = ($page - 1) * $perPage + 1;
      $endItem = min($startItem + $perPage - 1, $totalItems);
      $prevPage = $page > 1 ? $page - 1 : 1;
      $nextPage = $page < $totalPages ? $page + 1 : $totalPages;

      ?>
      <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-top: 20px; font-family: sans-serif; font-size: 14px;">
        <span><?= "$startItem - $endItem of $totalItems" ?></span>

        <a href="ScheduleManagement.php?page=<?= $prevPage ?>" style="text-decoration: none; font-size: 18px;">❮</a>

        <div style="display: flex; gap: 5px;">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="ScheduleManagement.php?page=<?= $i ?>" style="
              padding: 4px 10px;
              border-radius: 4px;
              text-decoration: none;
              background: <?= $i == $page ? '#0d6efd' : '#eee' ?>;
              color: <?= $i == $page ? '#fff' : '#000' ?>;
              font-weight: <?= $i == $page ? 'bold' : 'normal' ?>;
            ">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
        <a href="ScheduleManagement.php?page=<?= $nextPage ?>" style="text-decoration: none; font-size: 18px;">❯</a>
      </div>

    </main>

    <!-- Add Schedule Modal (only shown for admins) -->
    <?php if (canEdit()): ?>
    <div id="addSubjectModal">
      <div class="modal-box">
        <button class="close-btn">&times;</button>
        <h2>Add New Subject Schedule</h2>
        <form method="POST" action="ScheduleManagement.php">
          <label for="subjectCode">Subject ID</label>
          <select id="subjectCode" name="SubCode" required>
            <option value="" disabled selected hidden>Select a Subject</option>
            <?php while ($subject = mysqli_fetch_assoc($subjectsResult)): ?>
              <option value="<?= $subject['SubjID'] ?>">
                <?= htmlspecialchars($subject['SubCode']) ?>
              </option>
            <?php endwhile; ?>
          </select>

          <label for="section">Section</label>
          <select name="Section">
            <option value="" disabled selected hidden>Select Section</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
          </select>

          <label for="day">Day</label>
          <select name="Day" require>
            <option value="" disabled selected hidden>Select a Day</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
          </select>

          <label for="timestart">Time Start</label>
          <select name="start">
            <option value="" disabled selected hidden>Select a Time</option>
            <option value="8:00:00">8:00:00</option>
            <option value="9:00:00">9:00:00</option>
            <option value="10:00:00">10:00:00</option>
            <option value="11:00:00">11:00:00</option>
            <option value="12:00:00">12:00:00</option>
          </select>

          <label for="end">Time End</label>
          <select name="end">
            <option value="" disabled selected hidden>Select a Time End</option>
            <option value="11:00:00">11:00:00</option>
            <option value="12:00:00">12:00:00</option>
            <option value="13:00:00">13:00:00</option>
            <option value="14:00:00">14:00:00</option>
            <option value="15:00:00">15:00:00</option>
          </select>

          <label for="room">Room</label>
          <select id="room" name="room">
            <option value="" disabled selected hidden>Select a Room</option>
            <option value="101">101</option>
            <option value="102">102</option>
            <option value="103">103</option>
            <option value="104">104</option>
            <option value="105">105</option>
          </select>

          <div class="button-group">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="submit" class="add-btn" name="addSchedule">Add Subject</button>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Edit Modal (only shown for admins) -->
    <?php if (canEdit()): ?>
    <div id="editSubjectModal">
      <div class="modal-box">
        <button class="close-btn">&times;</button>
        <h2>Edit Subject</h2>
        <form method="POST" action="ScheduleManagement.php">
          <input type="hidden" id="editSchedID" name="editSchedID">

          <label for="editSubjectID">Subject ID</label>
          <select id="editSubjectID" name="editSubCode" required>
            <option value="" disabled selected hidden>Select a Subject</option>
            <?php
            $subjectsResult2 = mysqli_query($conn, "SELECT SubjID, SubCode FROM subject");
            while ($subject = mysqli_fetch_assoc($subjectsResult2)):
            ?>
              <option value="<?= $subject['SubjID'] ?>">
                <?= htmlspecialchars($subject['SubCode']) ?>
              </option>
            <?php endwhile; ?>
          </select>

          <label for="editSection">Section</label>
          <select name="editSection" id="editSection">
            <option value="" disabled selected hidden>Select Section</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
          </select>

          <label for="editDay">Day</label>
          <select id="editDay" name="editDay">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
          </select>

          <label for="timestart">Time Start</label>
          <select id="editStart" name="editStart">
            <option value="8:00:00">8:00:00</option>
            <option value="9:00:00">9:00:00</option>
            <option value="10:00:00">10:00:00</option>
            <option value="11:00:00">11:00:00</option>
            <option value="12:00:00">12:00:00</option>
          </select>

          <label for="end">Time End</label>
          <select id="editEnd" name="editEnd">
            <option value="11:00:00">11:00:00</option>
            <option value="12:00:00">12:00:00</option>
            <option value="13:00:00">13:00:00</option>
            <option value="14:00:00">14:00:00</option>
            <option value="15:00:00">15:00:00</option>
          </select>

          <label for="room">Room</label>
          <select id="editRoom" name="editRoom">
            <option value="" disabled selected hidden>Select a Room</option>
            <option value="101">101</option>
            <option value="102">102</option>
            <option value="103">103</option>
            <option value="104">104</option>
            <option value="105">105</option>
          </select>

          <div class="button-group">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="submit" class="save-btn" name="updateSched">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Delete Modal (only shown for admins) -->
    <?php if (canEdit()): ?>
    <div id="deleteModalOverlay" class="modal-overlay">
      <div class="modal-box">
        <form method="POST" action="ScheduleManagement.php">
          <input type="hidden" name="deleteSchedID" id="deleteSchedID">
          <h2>Confirm Deletion</h2>
          <p>Are you sure you want to delete this schedule?</p>
          <div class="button-group">
            <button type="button" class="cancel-btn" onclick="document.getElementById('deleteModalOverlay').style.display='none'">Cancel</button>
            <button type="submit" name="deleteSched" class="save-btn" style="background-color: red;">Delete</button>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <script>
      <?php if (canEdit()): ?>
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
      const editButtons = document.querySelectorAll(".action-btn img[alt='Edit']"); 
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

      document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
          document.getElementById('editSubjectID').value = button.dataset.subid;
          document.getElementById('editSection').value = button.dataset.section;
          document.getElementById('editDay').value = button.dataset.day;
          document.getElementById('editStart').value = button.dataset.start;
          document.getElementById('editEnd').value = button.dataset.end;
          document.getElementById('editRoom').value = button.dataset.room;
          document.getElementById('editSchedID').value = button.dataset.schedid;

          document.getElementById('editSubjectModal').style.display = 'flex';
        });
      });
      
      //delete modal
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
          const schedID = button.dataset.schedid;
          document.getElementById('deleteSchedID').value = schedID;
          document.getElementById('deleteModalOverlay').style.display = 'flex';
        });
      });
      <?php endif; ?>
    </script>

</body>
</html>