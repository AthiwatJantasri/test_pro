<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการพัสดุ</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        @font-face {
            font-family: 'THSarabunNew';
            src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
    </style>
</head>

<body>
    <h2 class="text-center">รายการการคืนพัสดุ</h2>
    <table>
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>พัสดุ</th>
                <th>จำนวน</th>
                <th>ชื่อผู้คืน</th>
                <th>วันที่คืน</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returned as $return)
                <tr>
                    <td>{{ $return->id }}</td>
                    <td>{{ $return->equipment->equipment_name }}</td>
                    <td>{{ $return->quantity }} {{ $return->equipment_type->equipmenttype_name }}</td>
                    <td>{{ $return->user->username }}</td>
                    <td>{{ $return->return_date }}</td>
                    <td>{{ $return->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
