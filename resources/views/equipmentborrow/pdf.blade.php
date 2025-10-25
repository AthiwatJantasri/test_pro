<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการการยืมพัสดุ</title>
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
    <h2 class="text-center">รายการการยืมพัสดุ</h2>

    <!-- วันที่ปัจจุบัน -->
    <p style="text-align: center; font-size:20px; font-weight:bold;">
        วันที่: {{ \Carbon\Carbon::now()->locale('th')->translatedFormat('j F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>พัสดุ</th>
                <th>จำนวน</th>
                <th>ชื่อผู้ยืม</th>
                <th>วันที่ยืม</th>
                <th>หมายเหตุผู้ยืม</th>
                <th>สถานะ</th>
                <th>ความคิดเห็นผู้อำนวยการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrows as $borrow)
            <tr>
                <td>{{ $borrow->id }}</td>
                <td>{{ optional($borrow->equipment)->equipment_name }}</td>
                <td>{{ $borrow->quantity }} {{ optional($borrow->equipment_type)->equipmenttype_name }}</td>
                <td>{{ optional($borrow->user)->username }}</td>
                <td>{{ $borrow->borrow_date }}</td>
                <td>{{ $borrow->remarks }}</td>
                <td>
                    @if($borrow->status === 'approved')
                    อนุมัติ
                    @elseif($borrow->status === 'rejected')
                    ไม่อนุมัติ
                    @elseif($borrow->status === 'pending')
                    รอดำเนินการ
                    @else
                    {{ $borrow->status }}
                    @endif
                </td>
                <td>{{ $borrow->manager_remarks ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>