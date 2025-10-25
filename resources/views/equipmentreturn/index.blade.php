@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

<div class="container mt-5">
    <div class="card mb-2">
        <div class="card-body">
            <h2>รายการการคืนครุภัณฑ์</h2>
            <div>
                <a href="{{ route('equipmentreturn.create') }}" class="btn btn-success">เพิ่มการคืนครุภัณฑ์</a>
                <a href="{{ route('equipmentreturn.exportPdf') }}" class="btn btn-info">
                    <i class="fas fa-file-pdf me-1"></i> ดาวน์โหลด PDF
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
            @endif

            <table class="table table-bordered text-center mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ครุภัณฑ์</th>
                        <th>จำนวน</th>
                        <th>ชื่อผู้คืน</th>
                        <th>วันที่คืน</th>
                        <th>หมายเหตุผู้คืน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returned as $return)
                    <tr>
                        <td>{{ ($returned->currentPage() - 1) * $returned->perPage() + $loop->iteration }}</td>
                        <td>{{ $return->equipment->equipment_name }}</td>
                        <td>{{ $return->quantity }} {{ $return->equipment_type->equipmenttype_name }}</td>
                        <td>{{ $return->user->username }}</td>
                        <td>{{ $return->return_date }}</td>
                        <td>{{ $return->remarks }}</td>
                        <td>
                            @if ($return->status === 'returned')
                                <span class="badge bg-success">คืนแล้ว</span><br>
                            @else ($return->status === 'not_returned')
                                <span class="badge bg-success">ยังไม่คืน</span><br>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-2">
                {{ $returned->links() }}
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3" id="commentInputGroup">
                        <label for="manager_remarks" class="form-label">ความเห็น</label>
                        <textarea name="manager_remarks" id="manager_remarks" class="form-control" rows="3"></textarea>
                    </div>
                    <div id="commentViewGroup" style="display:none;">
                        <label class="form-label">ความคิดเห็นผู้จัดการ</label>
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
    function openApprovalModal(id, status, remarks = '') {
        const form = document.getElementById('approvalForm');
        const modalStatus = document.getElementById('modalStatus');
        const remarksInput = document.getElementById('manager_remarks');
        const remarksView = document.getElementById('manager_remarks_view');
        const commentInputGroup = document.getElementById('commentInputGroup');
        const commentViewGroup = document.getElementById('commentViewGroup');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');
        const modalTitle = document.getElementById('approvalModalLabel');

        form.action = `/equipmentreturn/${id}/update-status/${status}`;
        modalStatus.value = status;

        if (status === 'view') {
            commentInputGroup.style.display = 'none';
            commentViewGroup.style.display = 'block';
            remarksView.textContent = remarks;
            modalSubmitBtn.style.display = 'none';
            modalTitle.textContent = 'ความคิดเห็นผู้จัดการ';
        } else {
            commentInputGroup.style.display = 'block';
            commentViewGroup.style.display = 'none';
            remarksInput.value = '';
            modalSubmitBtn.style.display = 'inline-block';
            modalTitle.textContent = (status === 'approved') ? 'อนุมัติการคืน' : 'ไม่อนุมัติการคืน';
        }

        const approvalModal = new bootstrap.Modal(document.getElementById('approvalModal'));
        approvalModal.show();
    }
</script>
@endsection
