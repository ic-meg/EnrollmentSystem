<?php 

        include "../dbcon.php";
        include "session_check.php";

        $userID = $_SESSION['user_id'];

        $query = "SELECT name, program FROM enrollee WHERE user_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die("Error preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

     
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $studentName = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); 
            $studentCourse = htmlspecialchars($student['program'], ENT_QUOTES, 'UTF-8');
        } else {
            $studentName = "Unknown";
            $studentCourse = "Not Assigned";
        }

        $stmt->close();
        $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Subject Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include "admin-sidebar.php"; ?>
    <main>
</div>
</div>
        <div class="container">
            <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Student Subject Management</h2>

   
                <!-- Student Info -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" value="<?php echo $studentName; ?>" disabled class="mt-1 block w-full border-gray-300 rounded-lg bg-gray-100 p-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" value="<?php echo $studentCourse; ?>" disabled class="mt-1 block w-full border-gray-300 rounded-lg bg-gray-100 p-2">
                </div>

                <!-- Section Dropdown -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Section</label>
                    <select id="sectionDropdown" class="border-gray-300 rounded-lg p-2 w-full">
                        <option value="">Select a section</option>
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                        <option value="C">Section C</option>
                        <option value="D">Section D</option>
                    </select>
                </div>

                <!-- Add Subject -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Add Subject</label>
                    <div class="flex mt-2">
                        <select id="subjectDropdown" class="border-gray-300 rounded-lg p-2 flex-grow">
                            <option value="">Select a subject</option>
                            <option value="Mathematics" data-price="500" data-schedule="Mon-Wed" data-time="8:00 AM - 10:00 AM" data-room="Room 101">Mathematics - $500</option>
                            <option value="English" data-price="450" data-schedule="Tue-Thu" data-time="10:00 AM - 12:00 PM" data-room="Room 202">English - $450</option>
                            <option value="Science" data-price="550" data-schedule="Mon-Fri" data-time="1:00 PM - 3:00 PM" data-room="Lab 3">Science - $550</option>
                        </select>
                        <button onclick="addSubject()" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add</button>
                    </div>
                </div>

                <!-- Subject List -->
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Subjects</h3>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <ul id="subjectList" class="space-y-2"></ul>

                    <div class="mt-4 bg-blue-100 p-4 rounded-lg">
                        <p><strong>Tuition Fees:</strong> <span id="totalFees">$0.00</span></p>
                        <p><strong>Miscellaneous Fee:</strong> $300</p>
                        <p><strong>Total Fees:</strong> <span id="grandTotal">$300.00</span></p>
                        <p class="font-bold">TOTAL UNITS: <span id="totalUnits">0</span></p>
                    </div>
                    <button onclick="finalizeSubjects()" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 w-full">Finalize Enrollment</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let totalFees = 0;
        let totalUnits = 0;

        function updateTotal() {
            let grandTotal = totalFees + 300; // Including miscellaneous fee
            document.getElementById("totalFees").textContent = `$${totalFees.toFixed(2)}`;
            document.getElementById("grandTotal").textContent = `$${grandTotal.toFixed(2)}`;
            document.getElementById("totalUnits").textContent = totalUnits;
        }
        function removeSubject(button) {
            let subjectElement = button.closest("li"); 
            let price = parseFloat(subjectElement.dataset.price);
            totalFees -= price;
            totalUnits -= 3; 
            subjectElement.remove(); 
            updateTotal();
        }

        
        function addSubject() {
            let dropdown = document.getElementById('subjectDropdown');
            let subjectName = dropdown.options[dropdown.selectedIndex].value;
            let subjectPrice = dropdown.options[dropdown.selectedIndex].dataset.price;
            let subjectSchedule = dropdown.options[dropdown.selectedIndex].dataset.schedule;
            let subjectTime = dropdown.options[dropdown.selectedIndex].dataset.time;
            let subjectRoom = dropdown.options[dropdown.selectedIndex].dataset.room;

            if (subjectName === '') return;
            
            let list = document.getElementById('subjectList');
            let existingSubjects = Array.from(list.children).map(li => li.getAttribute("data-name"));

            if (!existingSubjects.includes(subjectName)) {
                let li = document.createElement('li');
                li.className = "bg-white p-3 rounded-lg shadow border";
                li.setAttribute("data-name", subjectName);
                li.setAttribute("data-price", subjectPrice);
                li.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <p><strong>${subjectName}</strong> - $${subjectPrice}</p>
                            <p class="text-sm text-gray-600">Schedule: ${subjectSchedule}</p>
                            <p class="text-sm text-gray-600">Time: ${subjectTime}</p>
                            <p class="text-sm text-gray-600">Room: ${subjectRoom}</p>
                        </div>
                        <button onclick="removeSubject(this)" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                `;
                list.appendChild(li);

                totalFees += parseFloat(subjectPrice);
                totalUnits += 3; // Assuming each subject is 3 units
                updateTotal();
            }
            
            dropdown.value = '';
        }

        // Default subjects
        window.onload = function() {
            const defaultSubjects = [
                { name: "Programming", price: 550, schedule: "Mon-Wed", time: "9:00 AM - 11:00 AM", room: "Room 103" },
                { name: "Data Structures", price: 600, schedule: "Tue-Thu", time: "11:00 AM - 1:00 PM", room: "Room 205" },
                { name: "Algorithms", price: 650, schedule: "Wed-Fri", time: "2:00 PM - 4:00 PM", room: "Room 301" }
            ];
            
            let list = document.getElementById('subjectList');
            defaultSubjects.forEach(subject => {
                let li = document.createElement('li');
                li.className = "bg-white p-3 rounded-lg shadow border";
                li.setAttribute("data-name", subject.name);
                li.setAttribute("data-price", subject.price);
                li.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <p><strong>${subject.name}</strong> - $${subject.price}</p>
                            <p class="text-sm text-gray-600">Schedule: ${subject.schedule}</p>
                            <p class="text-sm text-gray-600">Time: ${subject.time}</p>
                            <p class="text-sm text-gray-600">Room: ${subject.room}</p>
                        </div>
                        <button onclick="removeSubject(this)" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                `;
                list.appendChild(li);
                totalFees += subject.price;
                totalUnits += 3;
            });
            updateTotal();
        }
    </script>
</body>
</html>
