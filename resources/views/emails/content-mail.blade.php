<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #aaaab6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 70px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #3498db;
            padding: 15px 15px;
            text-align: center;
            color: #ffffff;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }
    </style>
</head>
<body>
    <body style="background-color: gray;">
    <div class="email-container">
        <div class="header">
            <h1>Task Reminder</h1>
        </div>
        <div class="content">
            <p>Hello User,</p>
            <p>You have a task due soon:</p>

            <table>
                <tr>
                    <th>Title</th>
                    <td>{{ $task->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $task->description }}</td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <th>Due Time</th>
                    <td>{{ \Carbon\Carbon::parse($task->due_time)->format('h:i A') }}</td>
                </tr>
            </table>

            <p>Please make sure to complete it on time.</p>

            <p>Thank you,<br>Your Task Management Team</p>
        </div>
        <div class="footer">
            <p>&copy; All rights reserved.</p>
        </div>
    </div>
</body>
</html>
