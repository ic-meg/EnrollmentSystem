<?php

error_reporting(E_ALL & ~E_NOTICE);

include "../dbcon.php";
include "session_check.php";

$userID = isset($_GET['user_id']) ? (int) $_GET['user_id'] : null;
$enrolleeId = null;

if ($userID) {
    $stmt = $conn->prepare("SELECT EnrolleeID FROM enrollee WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $enrolleeId = $result->fetch_assoc()['EnrolleeID'];
    }
    $stmt->close();
}

$studentName = "Unknown";
$studentCourse = "Not Assigned";


if ($userID) {
    $stmt = $conn->prepare("SELECT name, program, enrollment_type FROM enrollee WHERE user_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $studentName = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');
            $studentCourse = htmlspecialchars($student['program'], ENT_QUOTES, 'UTF-8');
            $enrollmentType = $student['enrollment_type'];
            $filePreviewLinks = [];

            switch (strtolower($enrollmentType)) {
                case 'freshmen':
                    $stmt = $conn->prepare("SELECT Form137, Form138, Picture FROM freshmen WHERE user_id = ?");
                    break;
                case 'transferee':
                    $stmt = $conn->prepare("SELECT TOR, GoodMoral FROM transferee WHERE user_id = ?");
                    break;
                case 'returnee':
                    $stmt = $conn->prepare("SELECT TOR, MedCert, IDPhoto FROM returnee WHERE user_id = ?");
                    break;
                default:
                    $stmt = null;
            }

            if ($stmt) {
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $filePreviewLinks = $result->fetch_assoc();
                }
            }
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$freshmanSubjects = [];

if (strtolower($enrollmentType) === "freshmen") {
    $stmt = $conn->prepare("
    SELECT 
        s.SubjID,
        s.SubCode,
        s.SubName,
        s.Fee,
        s.Units,
        sch.Day AS Schedule,
        sch.TimeStart,
        sch.TimeEnd,
        sch.Room
    FROM subject s
    LEFT JOIN schedule sch ON s.SubjID = sch.SubID
    WHERE s.CourseID = (
        SELECT CourseID FROM course WHERE CourseName = ? LIMIT 1
    )
    ORDER BY s.SubjID ASC
    LIMIT 5
");


    if (!$stmt) {
        die("SQL Prepare Failed: " . $conn->error);
    }

    $stmt->bind_param("s", $studentCourse);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($sub = $result->fetch_assoc()) {
        $freshmanSubjects[] = $sub;
    }


    $stmt->close();
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Subject Enrollment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include "admin-sidebar.php"; ?>
    <main>

        </div>
        </div>
        <main class="py-10 px-4 sm:px-8 lg:px-12">
            <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-md p-8">
                <header class="mb-8 border-b pb-4 flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-700">Subject Enrollment</h1>
                        <p class="text-sm text-gray-500">Manage and finalize your enrollment subjects.</p>
                    </div>

                    <?php if (!empty($filePreviewLinks)): ?>
                        <div class="flex flex-wrap gap-3">
                            <?php foreach ($filePreviewLinks as $label => $filename): ?>
                                <?php if (!empty($filename)): ?>
                                    <a href="../student/uploads/<?= htmlspecialchars($filename) ?>" target="_blank" title="<?= htmlspecialchars($label) ?>" class="inline-block">
                                        <img src="../admin/assets/img/file-icon.ico" class="w-6 h-6 hover:scale-110 transition-transform" alt="<?= htmlspecialchars($label) ?>">
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </header>


                <!-- Student Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Row 1 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Student Name</label>
                        <input type="text" value="<?= $studentName ?>" disabled class="mt-1 w-full rounded-md bg-gray-100 border border-gray-300 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Course</label>
                        <input type="text" value="<?= $studentCourse ?>" disabled class="mt-1 w-full rounded-md bg-gray-100 border border-gray-300 px-3 py-2">
                    </div>

                    <!-- Row 2 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Enrollment Type</label>
                        <input type="text" value="<?= htmlspecialchars($enrollmentType) ?>" disabled class="mt-1 w-full rounded-md bg-gray-100 border border-gray-300 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Select Section</label>

                        <!-- Section Selector -->
                        <select id="sectionDropdown" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2" required>
                            <option value="">Select a section</option>
                            <option value="A">Section A</option>
                            <option value="B">Section B</option>
                            <option value="C">Section C</option>
                            <option value="D">Section D</option>
                            <option value="E">Section E</option>
                        </select>
                    </div>
                </div>



                <!-- Subject Selector -->
                <div class="mb-6">
                    <label class="block text-sm font-medium">Add Subject</label>
                    <div class="flex flex-col sm:flex-row gap-3 mt-2">
                        <select id="subjectDropdown" class="flex-grow rounded-md border border-gray-300 px-3 py-2">
                            <option value="" disabled selected hidden>Select a subject</option>
                            <?php
                            include "../dbcon.php";
                            $subjectDropdown = [];

                            $dropdownQuery = $conn->prepare("
                    SELECT s.SubjID, s.SubCode, s.SubName, s.Fee, s.Units, sch.Day AS Schedule, sch.TimeStart, sch.TimeEnd, sch.Room
                    FROM subject s
                    LEFT JOIN schedule sch ON s.SubjID = sch.SubID
                    WHERE s.CourseID = (
                        SELECT CourseID FROM course WHERE CourseName = ? LIMIT 1
                    )
                ");
                            $dropdownQuery->bind_param("s", $studentCourse);
                            $dropdownQuery->execute();
                            $dropdownResult = $dropdownQuery->get_result();

                            while ($row = $dropdownResult->fetch_assoc()) {
                                $subCode = htmlspecialchars($row['SubCode']);
                                $subName = htmlspecialchars($row['SubName']);
                                $fee = htmlspecialchars($row['Fee']);
                                $schedule = htmlspecialchars(isset($row['Schedule']) ? $row['Schedule'] : 'TBA');
                                $timeStart = isset($row['TimeStart']) ? $row['TimeStart'] : '';
                                $timeEnd = isset($row['TimeEnd']) ? $row['TimeEnd'] : '';
                                $time = $timeStart && $timeEnd ? "$timeStart - $timeEnd" : 'TBA';
                                $room = htmlspecialchars(isset($row['Room']) ? $row['Room'] : 'TBA');

                                echo "<option value='{$subCode}' 
                            data-id='{$row['SubjID']}'
                            data-price='{$fee}' 
                            data-schedule='{$schedule}' 
                            data-time='{$time}' 
                            data-room='{$room}'>
                            {$subName}
                        </option>";
                            }

                            $dropdownQuery->close();
                            ?>
                        </select>


                        <button onclick="addSubject()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add</button>
                    </div>
                </div>

                <!-- Subject List -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Enlisted Subjects</h2>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <ul id="subjectList" class="space-y-3"></ul>

                        <!-- Summary -->
                        <div class="mt-6 bg-blue-50 p-4 rounded-lg border text-sm">
                            <p><strong>Subject Fees:</strong> <span id="totalFees">₱0.00</span></p>
                            <p><strong>Miscellaneous Fee:</strong> ₱300.00</p>
                            <p><strong>Total Fees:</strong> <span id="grandTotal">₱300.00</span></p>
                            <p class="font-bold mt-2">Total Units: <span id="totalUnits">0</span></p>
                        </div>

                        <button onclick="finalizeSubjects()" class="w-full mt-4 bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Finalize Enrollment</button>
                    </div>
                </section>
            </div>


        </main>

        <script>
            const defaultSubjects = <?= json_encode($freshmanSubjects, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
            let totalFees = 0;
            let totalUnits = 0;

            function updateTotal() {
                const grandTotal = totalFees + 300;
                document.getElementById("totalFees").textContent = `₱${totalFees.toFixed(2)}`;
                document.getElementById("grandTotal").textContent = `₱${grandTotal.toFixed(2)}`;
                document.getElementById("totalUnits").textContent = totalUnits;
            }

            function removeSubject(button) {
                const item = button.closest("li");
                const price = parseFloat(item.dataset.price);
                totalFees -= price;
                totalUnits -= 3;
                item.remove();
                updateTotal();
            }

            function addSubject() {
                const dropdown = document.getElementById('subjectDropdown');
                const selected = dropdown.options[dropdown.selectedIndex];
                console.log("Selected option:", selected.outerHTML);

                const subjId = selected.dataset.id;
                const subCode = selected.value;
                const subName = selected.textContent.trim();
                const price = parseFloat(selected.dataset.price);
                const schedule = selected.dataset.schedule;
                const time = selected.dataset.time;
                const room = selected.dataset.room;

                if (!subCode || !subjId) {
                    alert("Please select a valid subject.");
                    return;
                }

                const list = document.getElementById('subjectList');
                const exists = [...list.children].some(li => li.dataset.name === subCode);
                if (exists) return;

                const li = document.createElement("li");
                li.className = "bg-white border rounded-md p-3 shadow-sm";
                li.dataset.name = subCode;
                li.dataset.price = price;
                li.dataset.subjid = subjId;

                li.innerHTML = `
        <div class="flex justify-between items-start">
            <div>
                <p class="font-medium">${subName} - ₱${price}</p>
                <p class="text-xs text-gray-600">Schedule: ${schedule}</p>
                <p class="text-xs text-gray-600">Time: ${time}</p>
                <p class="text-xs text-gray-600">Room: ${room}</p>
            </div>
            <button onclick="removeSubject(this)" class="text-sm text-red-600 hover:text-red-800">Remove</button>
        </div>`;

                list.appendChild(li);
                totalFees += price;
                totalUnits += 3;
                updateTotal();
                dropdown.value = '';
            }




            //subjects list

            window.onload = function() {
                if (defaultSubjects && Array.isArray(defaultSubjects)) {
                    defaultSubjects.forEach(subject => {
                        console.log("Rendering subject with SubjID:", subject.SubjID);

                        const li = document.createElement("li");
                        li.className = "bg-white border rounded-md p-3 shadow-sm";
                        li.dataset.name = subject.SubCode;
                        li.dataset.price = subject.Fee;
                        li.dataset.subjid = subject.SubjID;

                        const schedule = subject.Schedule || 'TBA';
                        const time = (subject.TimeStart && subject.TimeEnd) ?
                            `${subject.TimeStart} - ${subject.TimeEnd}` :
                            'TBA';
                        const room = subject.Room || 'TBA';

                        li.innerHTML = `
        <div class="flex justify-between items-start">
        <div>
            <p class="font-medium">${subject.SubName} - ₱${subject.Fee}</p>
            <p class="text-xs text-gray-600">Schedule: ${schedule}</p>
            <p class="text-xs text-gray-600">Time: ${time}</p>
            <p class="text-xs text-gray-600">Room: ${room}</p>
        </div>
        <button onclick="removeSubject(this)" class="text-sm text-red-600 hover:text-red-800">Remove</button>
        </div>`;

                        document.getElementById("subjectList").appendChild(li);
                        totalFees += parseFloat(subject.Fee ?? 0);
                        totalUnits += parseInt(subject.Units ?? 3);
                    });

                    updateTotal();
                }
            };

            function finalizeSubjects() {
                const enrolleeId = <?= isset($enrolleeId) ? $enrolleeId : 'null' ?>;

                const section = document.getElementById("sectionDropdown").value.trim();
                const subjectListItems = document.querySelectorAll("#subjectList li");

                if (!enrolleeId) {
                    alert("Invalid enrollee ID.");
                    return;
                }

                if (!section) {
                    alert("Please select a section.");
                    return;
                }

                if (subjectListItems.length === 0) {
                    alert("Please add at least one subject.");
                    return;
                }

                const subjects = Array.from(subjectListItems).map(li => ({
                    SubjID: parseInt(li.dataset.subjid),
                    SubCode: li.dataset.name,
                    SubName: li.querySelector("p.font-medium")?.textContent?.split(" - ")[0]?.trim() || "",
                    Fee: parseFloat(li.dataset.price) || 0,
                    Units: 3,
                    Schedule: li.querySelector("p:nth-child(2)")?.textContent.replace("Schedule: ", "").trim() || "TBA",
                    Time: li.querySelector("p:nth-child(3)")?.textContent.replace("Time: ", "").trim() || "TBA",
                    Room: li.querySelector("p:nth-child(4)")?.textContent.replace("Room: ", "").trim() || "TBA"
                }));


                const payload = {
                    enrollee_id: enrolleeId,
                    section: section,
                    subjects: subjects
                };

                fetch("finalize_enrollment.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async response => {
                        const text = await response.text();

                        try {
                            const json = JSON.parse(text);

                            if (json.success) {
                                alert("Enrollment finalized successfully! A confirmation email has been sent.");
                                window.location.href = "adminAdmissionManagement.php";
                            } else {
                                alert("Error: " + (json.message || "Unknown error"));
                            }
                        } catch (err) {
                            console.error("Invalid JSON received:", text);
                            alert("Server error: Received non-JSON response.\n" + text);
                        }
                    })
                    .catch(error => {
                        console.error("Request failed:", error);
                        alert("Request failed. Please check your network or contact support.");
                    });
            }
        </script>


</body>

</html>