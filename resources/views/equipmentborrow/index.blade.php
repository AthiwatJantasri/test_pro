@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

<div class="container mt-5">
    <div class="card mb-2">
        <div class="card-body">
            <h2>รายการการยืมครุภัณฑ์</h2>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('equipmentborrow.create') }}" class="btn btn-success">เพิ่มการยืมครุภัณฑ์</a>
                <a href="{{ route('equipmentborrow.exportPdf') }}" class="btn btn-info">
                    <i class="fas fa-file-pdf me-1"></i> ดาวน์โหลด PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ลำดับ</th>
                            <th>พัสดุ</th>
                            <th>จำนวน</th>
                            <th>ชื่อผู้ยืม</th>
                            <th>วันที่ยืม</th>
                            <th>วันที่กำหนดคืน</th> {{-- เพิ่มบรรทัดนี้ --}}
                            <th>หมายเหตุผู้ยืม</th>
                            <th>สถานะ</th>
                            <th>ความคิดเห็นผู้อำนวยการ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrows as $borrow)
                        <tr>
                            <td>{{ ($borrows->currentPage() - 1) * $borrows->perPage() + $loop->iteration }}</td>
                            <td>{{ $borrow->equipment->equipment_name }}</td>
                            <td>{{ $borrow->quantity }} {{ $borrow->equipment_type->equipmenttype_name }}</td>
                            <td>{{ $borrow->user->username }}</td>
                            <td>{{ $borrow->borrow_date }}</td>
                            <td>{{ $borrow->due_date }}</td> {{-- แสดง due_date --}}
                            <td>{{ $borrow->remarks }}</td>
                            <td>
                                @if ($borrow->status === 'pending')
                                    @if(auth()->user() && auth()->user()->role === 'manager')
                                        <button type="button" class="btn btn-success btn-sm mt-1"
                                            onclick="openApprovalModal({{ $borrow->id }}, 'approved')">อนุมัติ</button>
                                        <button type="button" class="btn btn-danger btn-sm mt-1"
                                            onclick="openApprovalModal({{ $borrow->id }}, 'rejected')">ไม่อนุมัติ</button>
                                    @else
                                        <span class="badge bg-warning">รอดำเนินการ</span>
                                    @endif
                                @elseif ($borrow->status === 'approved')
                                    <span class="badge bg-success">อนุมัติ</span>
                                @elseif ($borrow->status === 'overdue')
                                    <span class="badge bg-danger">เกินกำหนดคืน</span>
                                @else
                                    <span class="badge bg-danger">ไม่อนุมัติ</span>
                                @endif
                            </td>
                            <td>
                                @if($borrow->status !== 'pending')
                                    <button class="btn btn-outline-info btn-sm"
                                        onclick="openApprovalModal({{ $borrow->id }}, 'view')">ดูความคิดเห็น</button>
                                @else
                                    <span>ยังไม่มีความคิดเห็น</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->role !== 'user')
                                    @if ($borrow->status === 'pending')
                                        <a href="{{ route('equipmentborrow.edit', $borrow->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                        <form action="{{ route('equipmentborrow.destroy', $borrow->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">ลบ</button>
                                        </form>
                                    @else
                                        <button class="btn btn-warning mb-1" disabled>แก้ไข</button>
                                        <button class="btn btn-danger" disabled>ลบ</button>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-2">
                    {{ $borrows->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="approvalForm" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" id="modalStatus">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">กรอกเหตุผลประกอบการตัดสินใจ</h5>
                </div>

                <div class="modal-body">
                    <div class="mb-3" id="commentInputGroup">
                        <label for="manager_remarks" class="form-label">ความเห็น</label>
                        <textarea name="manager_remarks" id="manager_remarks" class="form-control" rows="3"></textarea>
                    </div>
                    <div id="commentViewGroup" style="display:none;">
                        <label class="form-label">ความคิดเห็นผู้อำนวยการ</label>
                        <p id="manager_remarks_view" class="border rounded p-2"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">ยืนยัน</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const managerComments = {
        @foreach($borrows as $req)
            {{ $req->id }}: {!! json_encode($req->manager_remarks) !!},
        @endforeach
    };

    function openApprovalModal(requestId, status) {
        const form = document.getElementById('approvalForm');
        const commentInputGroup = document.getElementById('commentInputGroup');
        const commentViewGroup = document.getElementById('commentViewGroup');
        const managerCommentTextarea = document.getElementById('manager_remarks');
        const managerCommentView = document.getElementById('manager_remarks_view');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');
        const modalTitle = document.getElementById('approvalModalLabel');

        if (status === 'view') {
            commentInputGroup.style.display = 'none';
            commentViewGroup.style.display = 'block';
            managerCommentView.textContent = managerComments[requestId] || 'ไม่มีความคิดเห็น';
            modalSubmitBtn.style.display = 'none';
            modalTitle.textContent = 'ความคิดเห็นผู้อำนวยการ';
        } else {
            commentInputGroup.style.display = 'block';
            commentViewGroup.style.display = 'none';
            managerCommentTextarea.value = '';
            modalSubmitBtn.style.display = 'inline-block';
            modalTitle.textContent = status === 'approved' ? 'อนุมัติคำขอ' : 'ไม่อนุมัติคำขอ';

            form.action = `/equipmentborrow/${requestId}/update-status/${status}`;
        }

        document.getElementById('modalStatus').value = status;
        const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
        modal.show();
    }
</script>
@endsection
