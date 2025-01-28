<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Tracking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eaf4fc;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: left;
            margin-bottom: 20px;
            color: #2a5d9f;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        .tab {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
        }
        .tab.active {
            background-color: #2DB2FF;
            color: #fff;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table thead {
            background-color: #FFFFFF;
            color: rgb(16, 16, 16);
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table td {
            position: relative;
        }
        table td .action-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border: 2px solid #000;
            border-radius: 50%;
            background-color: white;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
        }
        table td .action-btn:hover {
            background-color: #f0f0f0;
            transform: scale(1.1);
        }
        table td .action-btn:active {
            transform: scale(0.9);
        }
        table td .action-btn svg {
            width: 24px;
            height: 24px;
            fill: black;
        }
        @media (max-width: 768px) {
            table thead {
                display: none;
            }
            table tr {
                display: block;
                margin-bottom: 10px;
            }
            table td {
                display: block;
                text-align: right;
                border: none;
                padding-left: 50%;
                position: relative;
            }
            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment <span style="color: #007BFF;">Tracking</span></h1>

        <div class="tabs">
            <div class="tab active">Completed Payments</div>
            <div class="tab">Pending Payments</div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Control Number</th>
                        <th>Program</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Methods</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Name">Giuliani Calais</td>
                        <td data-label="Control Number">202231140</td>
                        <td data-label="Program">BSIT</td>
                        <td data-label="Date">11/11/2024</td>
                        <td data-label="Amount">₱2,000</td>
                        <td data-label="Methods">Bank</td>
                        <td data-label="Action">
                            <button class="action-btn" onclick="viewDetails('202231140')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 4.5c-5 0-9.27 3.11-11 7.5 1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Name">Giuliani Calais</td>
                        <td data-label="Control Number">202231140</td>
                        <td data-label="Program">BSIT</td>
                        <td data-label="Date">11/11/2024</td>
                        <td data-label="Amount">₱2,000</td>
                        <td data-label="Methods">Bank</td>
                        <td data-label="Action">
                            <button class="action-btn" onclick="viewDetails('202231140')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 4.5c-5 0-9.27 3.11-11 7.5 1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Tab navigation logic
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                // Add logic to toggle table content
            });
        });

        // View details function
        function viewDetails(controlNumber) {
            alert(`View details for control number: ${controlNumber}`);
        }
    </script>
</body>
</html>
