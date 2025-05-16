<?php
include "../dbcon.php";
include "session_check.php";

$allSubjects = [];
$subject_query = "SELECT SubjID, SubCode, SubName FROM subject";
$subject_result = mysqli_query($conn, $subject_query);
while ($row = mysqli_fetch_assoc($subject_result)) {
  $allSubjects[] = $row;
}

$courses = [];
$course_query = "SELECT CourseID, CourseName FROM course";
$course_result = mysqli_query($conn, $course_query);
while ($course_row = mysqli_fetch_assoc($course_result)) {
  $courses[] = $course_row;
}

if (isset($_POST['add_subject'])) {
  $SubCode = $_POST['SubCode'];
  $SubName = $_POST['SubName'];
  $Units = $_POST['Units'];
  $rawPrerequisites = $_POST['PreRequisites'];
  $decodedPrereqs = json_decode($rawPrerequisites, true);

  $prereqValues = [];

  if (is_array($decodedPrereqs)) {
    foreach ($decodedPrereqs as $item) {
      if (isset($item['value'])) {

        $code = explode(" - ", $item['value'])[0];
        $prereqValues[] = $code;
      }
    }
  }
  $PreRequisites = implode(", ", $prereqValues);

  $Fee = $_POST['Fee'];
  $LinkProgram = !empty($_POST['LinkProgram']) ? $_POST['LinkProgram'] : "NULL";

  $query = "INSERT INTO subject (SubCode, SubName, Units, PreRequisites, Fee, CourseID) 
              VALUES ('$SubCode', '$SubName', '$Units', '$PreRequisites', '$Fee', $LinkProgram)";
  mysqli_query($conn, $query);
}

if (isset($_POST['edit_subject']) && isset($_POST['SubjID'])) {
  $SubjID = $_POST['SubjID'];
  $SubCode = $_POST['editSubCode'];
  $SubName = $_POST['editSubName'];
  $Units = $_POST['editUnits'];
  $rawPrerequisites = $_POST['editPreRequisites'];
  $decodedPrereqs = json_decode($rawPrerequisites, true);
  $prereqValues = [];

  if (is_array($decodedPrereqs)) {
    foreach ($decodedPrereqs as $item) {
      if (isset($item['value'])) {
        $code = explode(" - ", $item['value'])[0];
        $prereqValues[] = $code;
      }
    }
  }
  $PreRequisites = implode(", ", $prereqValues);

  $Fee = $_POST['editFee'];
  $CourseID = $_POST['editCourse'];

  $query = "UPDATE subject SET SubCode = '$SubCode', SubName = '$SubName', 
              Units = '$Units', PreRequisites = '$PreRequisites', Fee = '$Fee', 
              CourseID = '$CourseID' 
              WHERE SubjID = '$SubjID'";

  mysqli_query($conn, $query);
}

if (isset($_POST['delete_subject']) && isset($_POST['SubjID'])) {
  $SubjID = $_POST['SubjID'];
  $query = "DELETE FROM subject WHERE SubjID = '$SubjID'";
  mysqli_query($conn, $query);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Subject Management</title>
  <link rel="stylesheet" href="Subject_management.css">
  <!-- Tagify CSS -->
  <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

  <!-- Tagify JS -->
  <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

</head>
<style>
  .modal-box {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .modal-box .modal-content {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    position: relative;
  }

  .button-group {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 1rem;
  }

  .btn {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .btn-primary {
    background-color: #0d6efd;
    color: white;
  }

  .btn-primary:hover {
    background-color: #0b5ed7;
  }

  .btn-secondary {
    background-color: #f8f9fa;
    color: #212529;
    border: 1px solid #ced4da;
  }

  .btn-secondary:hover {
    background-color: #e2e6ea;
  }

  .tagify {
    width: 100% !important;
  }
</style>

<body>
  <?php include "admin-sidebar.php"; ?>
  <main>
    </div>
    </div><br><br>
    <div class="top-bar" style="display: flex; justify-content: space-between; align-items: center;">
      <h1 class="title">Subject Management</h1>
      <div>
        <form action="import_subjects.php" method="POST" enctype="multipart/form-data" style="display: inline-block;">
          <label class="btn btn-sm btn-outline-secondary">
            📁 Import
            <input type="file" name="import_file" accept=".xlsx" hidden onchange="this.form.submit()">
          </label>
        </form>
        <button class="add-subject-btn btn btn-sm btn-outline-primary">+ Add New Subject</button>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Link Program</th>
            <th>Subject Code</th>
            <th>Subject Title</th>
            <th>Units</th>
            <th>Pre-requisites</th>
            <th>Fee</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $perPage = 10;
          $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
          $start = ($page - 1) * $perPage;

          $total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM subject");
          $total_row = mysqli_fetch_assoc($total_result);
          $total_subjects = $total_row['total'];
          $total_pages = ceil($total_subjects / $perPage);

          $query = "SELECT subject.*, course.CourseName 
            FROM subject 
            LEFT JOIN course ON subject.CourseID = course.CourseID
            LIMIT $start, $perPage";

          $result = mysqli_query($conn, $query);
          $modals = '';
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['CourseName']) . "</td>";
            echo "<td>" . $row['SubCode'] . "</td>";
            echo "<td>" . $row['SubName'] . "</td>";
            echo "<td>" . $row['Units'] . "</td>";
            echo "<td>" . $row['PreRequisites'] . "</td>";
            echo "<td>" . $row['Fee'] . "</td>";
            echo "<td>
              <button type='button' class='action-btn' onclick=\"openModal('editModal{$row['SubjID']}')\">
                <img src='adminPic/EditPen.svg' alt='Edit' class='icon-btn'>
              </button>
              <button type='button' class='action-btn' onclick=\"openModal('deleteModal{$row['SubjID']}')\">
                <img src='adminPic/Trash_Full.svg' alt='Delete' class='icon-btn'>
              </button>
            </td>";
            echo "</tr>";


            // Edit Modal
            $modals .= "
      <div id='editModal{$row['SubjID']}' class='modal-box' style='display: none;'>
        <div class='modal-content'>
          <button class='close-btn btn-close float-end' data-id='editModal{$row['SubjID']}'>×</button>
          <h2>Edit Subject</h2>
          <form method='POST' action='Subject_management.php'>
            <input type='hidden' name='SubjID' value='{$row['SubjID']}'>
      
            <label for='editSubCode{$row['SubjID']}'>Subject Code</label>
            <input type='text' id='editSubCode{$row['SubjID']}' name='editSubCode' class='form-control' value='{$row['SubCode']}' required>
            
            <label for='editCourse{$row['SubjID']}'>Link Program</label>
            <select name='editCourse' class='form-control' id='editCourse'{$row['SubjID']}' required>

              <option value=''>-- Select Program --</option>";
            foreach ($courses as $course) {
              $selected = ($course['CourseID'] == $row['CourseID']) ? "selected" : "";
              $modals .= "<option value='{$course['CourseID']}' $selected>" . htmlspecialchars($course['CourseName']) . "</option>";
            }
            $modals .= "
            </select>
      
            <label for='editSubName{$row['SubjID']}'>Subject Title</label>
            <input type='text' id='editSubName{$row['SubjID']}' name='editSubName' class='form-control' value='{$row['SubName']}' required>
      
            <label for='editUnits{$row['SubjID']}'>Units</label>
            <input type='text' id='editUnits{$row['SubjID']}' name='editUnits' class='form-control' value='{$row['Units']}' required>
      
     
          <div style='width: 100%; margin-bottom: 15px;'>
            <label for='editPreRequisites{$row['SubjID']}' style='display: block; margin-bottom: 5px;'>Pre-requisites</label>
            <input 
              
              id='editPreRequisites{$row['SubjID']}'
              name='editPreRequisites'
              class='form-control tagify-input'
              style='width: 100%; box-sizing: border-box;'
              value='{$row['PreRequisites']}'
            />
          </div>

      
            <label for='editFee{$row['SubjID']}'>Fee</label>
            <input type='text' id='editFee{$row['SubjID']}' name='editFee' class='form-control' value='{$row['Fee']}'>
      
            <div class='button-group'>
              <button type='button' class='btn btn-secondary cancel-btn' data-id='editModal{$row['SubjID']}'>Cancel</button>
              <button type='submit' name='edit_subject' class='btn btn-primary'>Save Changes</button>
            </div>
          </form>
        </div>
      </div>
      ";


            // Delete Modal
            $modals .= "<div id='deleteModal{$row['SubjID']}' class='modal-box' style='display: none;'>
    <div class='modal-content p-4 border rounded'>
      <h4>Are you sure you want to delete this subject?</h4>
      <form method='POST' action='Subject_management.php'>
        <input type='hidden' name='SubjID' value='{$row['SubjID']}'>
        <div class='mt-3 text-end'>
          <button type='button' class='btn btn-secondary cancel-btn' data-id='deleteModal{$row['SubjID']}'>Cancel</button>
          <button type='submit' name='delete_subject' class='btn btn-danger'>Delete</button>
        </div>
      </form>
    </div>
    </div>";
          }
          echo $modals;

          ?>

        </tbody>
      </table>


    </div>
    <?php
    $startItem = ($page - 1) * $perPage + 1;
    $endItem = min($startItem + $perPage - 1, $total_subjects);
    $prevPage = $page > 1 ? $page - 1 : 1;
    $nextPage = $page < $total_pages ? $page + 1 : $total_pages;
    ?>
    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-top: 20px; font-family: sans-serif; font-size: 14px;">
      <span><?= "$startItem - $endItem of $total_subjects" ?></span>

      <a href="Subject_management.php?page=<?= $prevPage ?>" style="text-decoration: none; font-size: 18px;">❮</a>

      <div style="display: flex; gap: 5px;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="Subject_management.php?page=<?= $i ?>" style="
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

      <a href="Subject_management.php?page=<?= $nextPage ?>" style="text-decoration: none; font-size: 18px;">❯</a>
    </div>

    </div>
    </div>
  </main>
  <!-- Add Subject modal -->
  <div id="addSubjectModal" class="modal-box">
    <div class="modal-content">
      <button class="close-btn" data-id="addSubjectModal">&times;</button>
      <h2>Add New Subject</h2>
      <form method="POST" action="Subject_management.php">
        <label for="SubCode">Subject Code</label>
        <input type="text" id="SubCode" name="SubCode" placeholder="Enter Subject Code" required />

        <label for="LinkProgram">Link Program</label>
        <select id="LinkProgram" name="LinkProgram">
          <option value="">-- Select Program --</option>
          <?php foreach ($courses as $course): ?>
            <option value="<?php echo $course['CourseID']; ?>">
              <?php echo htmlspecialchars($course['CourseName']); ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="SubName">Subject Title</label>
        <input type="text" id="SubName" name="SubName" placeholder="Enter Subject Title" required />

        <label for="Units">Units</label>
        <input type="text" id="Units" name="Units" placeholder="Enter Units" required />

        <label for="PreRequisites">Pre-requisites</label>
        <input id="PreRequisites" name="PreRequisites">

        </input>


        <label for="Fee">Fee</label>
        <input type="text" id="Fee" name="Fee" placeholder="Enter Fee" required />

        <div class="button-group">
          <button type="button" class="btn btn-secondary cancel-btn" data-id="addSubjectModal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="add_subject">Add Subject</button>
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
  </script>
  <!-- Edit Subject Modal -->
  <div class="modal fade" id="editModal<?php echo $row['SubjID']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['SubjID']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" action="Subject_management.php">
          <div class="modal-header">
            <h5 class="modal-title">Edit Subject</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="SubjID" value="<?php echo $row['SubjID']; ?>" />

            <label>Subject Code</label>
            <input type="text" name="editSubCode" class="form-control" value="<?php echo $row['SubCode']; ?>" required>

            <label>Subject Title</label>
            <input type="text" name="editSubName" class="form-control" value="<?php echo $row['SubName']; ?>" required>

            <label>Units</label>
            <input type="text" name="Units" class="form-control" value="<?php echo $row['Units']; ?>" required>

            <label for="editPreRequisites<?php echo $row['SubjID']; ?>">Pre-requisites</label>
            <select name="editPreRequisites[]" id="editPreRequisites<?php echo $row['SubjID']; ?>" class="form-control select-prereq" multiple="multiple">
              <?php
              $existingPrereqs = explode(", ", $row['PreRequisites']);
              foreach ($allSubjects as $subject) {
                $code = $subject['SubCode'];
                $label = $subject['SubCode'] . ' - ' . $subject['SubName'];
                $selected = in_array($code, $existingPrereqs) ? 'selected' : '';
                echo "<option value='$code' $selected>$label</option>";
              }
              ?>
            </select>


            <label>Fee</label>
            <input type="text" name="Fee" class="form-control" value="<?php echo $row['Fee']; ?>">
          </div>
          <div class="modal-footer">
            <button type="submit" name="edit_subject" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    function openModal(id) {
      document.getElementById(id).style.display = "flex";
    }

    document.querySelectorAll(".close-btn, .cancel-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const modalId = btn.getAttribute("data-id");
        if (modalId) document.getElementById(modalId).style.display = "none";
      });
    });

    window.addEventListener("click", e => {
      if (e.target.classList.contains("modal-box")) {
        e.target.style.display = "none";
      }
    });
    const input = document.querySelector('#PreRequisites');

    const tagifyWhitelist = [
      <?php foreach ($allSubjects as $subject): ?> "<?php echo htmlspecialchars($subject['SubCode'] . ' - ' . $subject['SubName']); ?>",
      <?php endforeach; ?>
    ];

    // Add Subject (ID-based)
    new Tagify(document.querySelector('#PreRequisites'), {
      whitelist: tagifyWhitelist,
      dropdown: {
        enabled: 0,
        maxItems: 10,
        classname: "tags-look",
        closeOnSelect: false
      }
    });

    // Edit Modals 
    document.querySelectorAll('.tagify-input').forEach(input => {
      new Tagify(input, {
        whitelist: tagifyWhitelist,
        dropdown: {
          enabled: 0,
          maxItems: 10,
          classname: "tags-look",
          closeOnSelect: false
        }
      });
    });
  </script>

</body>

</html>