<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Checklist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: black;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            color: black;
        }
        th {
            background-color: #555;
        }
        .semester-header {
            background-color: #2DB2FF; /* Darker section for semester */
            padding: 10px;
            font-weight: bold;
            color: white;
            text-align: center;
        }
        .btn {
            cursor: pointer;
            color: white;
            background-color: #666;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 2px;
        }
        .btn:hover {
            background-color: #777;
        }
        .passed-btn {
            background-color: #4CAF50; /* Green for passed */
        }
        .delete-btn {
            background-color: #d9534f; /* Red for delete or fail */
        }
        .download-btn {
            float: right;
            background-color: #2DB2FF; /* Green for download */
        }
        #sidebar ul {
            padding: 0;
            list-style-type: none; 
        }
    </style>
</head>
<body>
<?php include "stud-sidebar.php"; ?>

    <main>
</div>
</div>
<div class="container">
    <div class="table-container">
        <div class="header">Curriculum Checklist <button class="btn download-btn">Download</button></div>
        <div class="semester-header">1ST YEAR - FIRST SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 02</td>
                    <td>Ethics</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 05</td>
                    <td>Purposive Communication</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 11</td>
                    <td>Kontekswalisadong Komunikasyon sa Filipino</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>COSC 50A</td>
                    <td>Discrete Structure</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 21A</td>
                    <td>Introduction to Computing</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 22A</td>
                    <td>Computer Programming 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 1</td>
                    <td>Movement Enhancement</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>CVSU 101</td>
                    <td>Institutional Orientation</td>
                    <td>1.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>NSTP 1</td>
                    <td>National Service Training Program 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">1ST YEAR - SECOND SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 01</td>
                    <td>ART APPRECIATION</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 06</td>
                    <td>SCIENCE, TECHNOLOGY AND SOCIETY</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 14</td>
                    <td>KPANITIKANG PANLIPUNAN</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 03</td>
                    <td>MATHEMATICS IN THE MODERN WORLD</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 23A</td>
                    <td>COMPUTER PROGRAMMING 2</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 50A</td>
                    <td>WEB SYSTEM AND TECHNOLOGIES 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 2</td>
                    <td>FOTNESS EXERCISE</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>NSTP 2</td>
                    <td>NATIONAL SERVICE TRAINING PROGRAM 2</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">2NDYEAR - FIRST SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 04</td>
                    <td>MGA BABASAHIN HINGGIL SA KASAYSAYAN NG PILIPINAS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 07</td>
                    <td>THE CONTEMPORATY WORLD</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 10A</td>
                    <td>GENDER AND SOCIETY</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 55A</td>
                    <td>PLATFORM TECHNOLOGIES</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 23A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 24A</td>
                    <td>INFORMATION MANAGEMENT</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 23A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 50A</td>
                    <td>OBJECT ORIENTED PROGRAMMING</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 23A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 3</td>
                    <td>PHYSICAL ACTIVITIES TOWARDS HEALTH AND FITNESS 1</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>FITT 1</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">2ND YEAR - SECOND SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 08</td>
                    <td>UNDERSTANDING THE SELF</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 25A</td>
                    <td>DATA STRUCTURES AND ALGORITHMS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 50A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 60A</td>
                    <td>INTEGRATED PROGRAMMING AND TECHNOLOGIES 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 50A,ITEC 55A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 65A</td>
                    <td>OPEN SOURCE TECHNOLOGIES</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>COSC 50A, DCIT 21A, DCIT 22A, DCIT 23A,<br>
                    ITEC 50A, ITEC 55A, DCIT 50A, DCIT 24A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 55A</td>
                    <td>ADVANCE DATABASE MANAGEMENT SYSTEM</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 24A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 70A</td>
                    <td>MULTIMEDIA SYSTEMS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>COSC 50A, DCIT 21A, DCIT 22A, DCIT 23A,<br> 
                    ITEC 50A, ITEC 55A, DCIT 50A, DCIT 24A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 4</td>
                    <td>PHYSICAL ACTIVITIES TOWARDS HEALTH AND FITNESS 2</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>FITT 1</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">2ND YEAR - SUMMER SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>STATS 2A </td>
                    <td>APPLIED STATISTICS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 70A, DCIT 55A, ITEC 65A, ITEC 60A, DCIT 25A,<br>
                    DCIT 50A, DCIT 24A, ITEC 55A, ITEC 50A, DCIT 23A, DCIT 22A, DCIT 21A, COSC 50A</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 75A</td>
                    <td>SYSTEM INTEGRATION AND ARCHITECTURE 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 60A</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">3RD YEAR - FIRST SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ITEC 80A</td>
                    <td>INTRODUCTION TO HUMAN COMPUTER INTERACTION</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 70A, DCIT 55A, ITEC 65A, ITEC 60A, DCIT 25A, DCIT 50A, <br>
                    DCIT 24A, ITEC 55A, ITEC 75A, ITEC 50A, DCIT 23A, DCIT 22A, DCIT 21A, COSC 50A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 85A</td>
                    <td>INFORMATION ASSURANCE AND SECURITY 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 75A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 90</td>
                    <td>NETWORK FUNDAMENTALS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 55A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>INSY 55</td>
                    <td>SYSTEM ANALYSIS AND DESIGN</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 75A, ITEC 70A, DCIT 55A, ITEC 65A, ITEC 60A, DCIT 25A,<br>
                    DCIT 50A, DCIT 24A, ITEC 55A, ITEC 50A, DCIT 23A, DCIT 22A, DCIT 21A, COSC 50A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 26/td>
                    <td>APPLICATION DEVELOPMENT AND EMERGING TECHNOLOGIES</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>DCIT 55A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 60A</td>
                    <td>METHODS OF RESEARCH</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 75A, ITEC 70A, DCIT 55A, ITEC 65A, ITEC 60A, DCIT 25A,<br>
                    DCIT 50A, DCIT 24A, ITEC 55A, ITEC 50A, DCIT 23A, DCIT 22A, DCIT 21A, COSC 50A</td>
                    <td>
                        <button type="button" class="btn passed-btn">Passed</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">3RD YEAR - SECOND SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 09</td>
                    <td>RIZAL'S LIFE AND WORKS</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>GNED 04</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 95</td>
                    <td>QUANTITATIVE METHODS (MODELING & SIMULATION)</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>COSC 50A, STAT 2A</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 101A</td>
                    <td>IT ELECTIVE 1 (HUMAN COMPUTER INTERACTION 2)</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 80A</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 106A</td>
                    <td>IT ELECTIVE 2 (WEB SYSTEM AND TECHNOLOGIES 2)</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>-</td>
                    <td>ITEC 50A</td>
                    <td>
                        <button type="button" the class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>ITEC 100</td>
                    <td>INFORMATION ASSURANCE AND SECURITY 2</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 22A</td>
                    <td>Computer Programming 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 1</td>
                    <td>Movement Enhancement</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>S</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>CVSU 101</td>
                    <td>Institutional Orientation</td>
                    <td>1.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>NSTP 1</td>
                    <td>National Service Training Program 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">4TH YEAR - FIRST SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 02</td>
                    <td>Ethics</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.75</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 05</td>
                    <td>Purposive Communication</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 11</td>
                    <td>Kontekswalisadong Komunikasyon sa Filipino</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>COSC 50A</td>
                    <td>Discrete Structure</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" the class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 21A</td>
                    <td>Introduction to Computing</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 22A</td>
                    <td>Computer Programming 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 1</td>
                    <td>Movement Enhancement</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>S</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>CVSU 101</td>
                    <td>Institutional Orientation</td>
                    <td>1.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>NSTP 1</td>
                    <td>National Service Training Program 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="semester-header">4TH YEAR - SECOND SEMESTER</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Major</th>
                    <th>Pre-Requisite</th>
                    <th>Grade</th>
                    <th>Completion</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>GNED 02</td>
                    <td>Ethics</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.75</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 05</td>
                    <td>Purposive Communication</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.00</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>GNED 11</td>
                    <td>Kontekswalisadong Komunikasyon sa Filipino</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>COSC 50A</td>
                    <td>Discrete Structure</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" the class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 21A</td>
                    <td>Introduction to Computing</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>DCIT 22A</td>
                    <td>Computer Programming 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>FITT 1</td>
                    <td>Movement Enhancement</td>
                    <td>2.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.50</td>
                    <td>Passed</td>
                    <td>S</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>CVSU 101</td>
                    <td>Institutional Orientation</td>
                    <td>1.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
                <tr>
                    <td>NSTP 1</td>
                    <td>National Service Training Program 1</td>
                    <td>3.00</td>
                    <td>N/A</td>
                    <td>-</td>
                    <td>1.25</td>
                    <td>Passed</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn delete-btn">X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
