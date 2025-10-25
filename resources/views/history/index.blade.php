@extends('template.backend')

@section('content')
<div class="container mt-5">
    <div class="card mb-2">
        <div class="card-body">
            <h2>ประวัติการยืมคืนของคุณ</h2>

            {{-- ตารางการยืม --}}
            <h4 class="mt-4">การยืม</h4>
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ครุภัณฑ์</th>
                        <th>จำนวน</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่กำหนดคืน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrows as $borrow)
                        <tr>
                            <td>{{ ($borrows->currentPage() - 1) * $borrows->perPage() + $loop->iteration }}</td>
                            <td>{{ $borrow->equipment->equipment_name }}</td>
                            <td>{{ $borrow->quantity }} {{ $borrow->equipment_type->equipmenttype_name }}</td>
                            <td>{{ $borrow->borrow_date }}</td>
                            <td>{{ $borrow->due_date }}</td>
                            <td>
                                @if ($borrow->status === 'pending')
                                    <span class="badge bg-warning">รอดำเนินการ</span>
                                @elseif ($borrow->status === 'approved')
                                    <span class="badge bg-success">อนุมัติ</span>
                                @elseif ($borrow->status === 'overdue')
                                    <span class="badge bg-danger">เกินกำหนดคืน</span>
                                @else
                                    <span class="badge bg-danger">ไม่อนุมัติ</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">ไม่มีประวัติการยืม</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-2">
                {{ $borrows->appends(['returns_page' => request('returns_page')])->links() }}
            </div>

            {{-- ตารางการคืน --}}
            <h4 class="mt-5">การคืน</h4>
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ครุภัณฑ์</th>
                        <th>จำนวน</th>
                        <th>วันที่คืน</th>
                        <th>หมายเหตุ</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr>
                            <td>{{ ($returns->currentPage() - 1) * $returns->perPage() + $loop->iteration }}</td>
                            <td>{{ $return->equipment->equipment_name }}</td>
                            <td>{{ $return->quantity }} {{ $return->equipment_type->equipmenttype_name }}</td>
                            <td>{{ $return->return_date }}</td>
                            <td>{{ $return->remarks }}</td>
                            <td>
                                @if ($return->status === 'returned')
                                    <span class="badge bg-success">คืนแล้ว</span>
                                @else
                                    <span class="badge bg-danger">ยังไม่คืน</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">ไม่มีประวัติการคืน</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-2">
                {{ $returns->appends(['borrows_page' => request('borrows_page')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
