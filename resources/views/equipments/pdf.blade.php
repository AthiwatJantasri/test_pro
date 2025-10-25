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
            text-align: center;
        }

        img {
            max-width: 300px;
            height: auto;
            display: inline-block;
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
    <img src="02.png" alt="โลโก้" />
    <h2 style="text-align: center;">รายการพัสดุในระบบ</h2>

    <!-- วันที่ปัจจุบัน -->
    <p style="text-align: center; font-size:20px; font-weight:bold;">
        วันที่: {{ \Carbon\Carbon::now()->locale('th')->translatedFormat('j F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อพัสดุ</th>
                <th>จำนวนที่มีอยู่ในคลัง</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $index => $equipment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $equipment->equipment_name }}</td>
                <td>{{ $equipment->stock }} {{ $equipment->equipmentType->equipmenttype_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>