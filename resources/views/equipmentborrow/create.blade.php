@extends('template.backend')

@section('content')
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* บังคับให้ cursor กระพริบในช่องค้นหา Select2 และเพิ่มสไตล์การโฟกัสให้ชัดเจน */
        .select2-container--open .select2-search__field {
            caret-color: auto !important; /* ให้เคอร์เซอร์แสดงอัตโนมัติ */
            outline: none !important; /* ลบเส้นกรอบสีน้ำเงินเริ่มต้นที่อาจจะเกิดจากการโฟกัส */
            border: 1px solid #007bff !important; /* เพิ่มสี border เมื่อโฟกัส (Bootstrap primary) */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important; /* เพิ่ม shadow เมื่อโฟกัส (Bootstrap focus style) */
            animation: caretBlink 1s infinite;
        }

        @keyframes caretBlink {
            0%, 100% { border-right-color: #000; }
            50% { border-right-color: transparent; }
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-2 w-75">
        <div class="container mt-0">
            <div class="card shadow-lg w-75 mx-auto">
                <h2 class="text-center mt-3">เพิ่มข้อมูลการยืมครุภัณฑ์</h2>
                <form action="{{ route('equipmentborrow.store') }}" method="POST" class="mb-3 p-4">
                    @csrf

                    <div class="mb-2">
                        <label for="equipments_id" class="form-label">ครุภัณฑ์:</label>
                        <select name="equipments_id" id="equipments_id" class="form-control select2" required>
                            <option value="">-- พิมพ์เพื่อค้นหาและเลือกครุภัณฑ์ --</option>
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}" {{ old('equipments_id') == $equipment->id ? 'selected' : '' }}>
                                    {{ $equipment->equipment_name }} | คงเหลือ: {{ $equipment->stock }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipments_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">จำนวน:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity') }}" required>
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="equipment_type_id" class="form-label">ประเภทครุภัณฑ์:</label>
                        <select name="equipment_type_id" id="equipment_type_id" class="form-control" required>
                            <option value="">-- เลือกหน่วยนับ --</option>
                            @foreach($equipmentTypes as $type)
                                <option value="{{ $type->id }}" {{ old('equipment_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->equipmenttype_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_type_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="user_id">ชื่อผู้ยืม</label>
                        @if(Auth::user()->role === 'admin')
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">-- เลือกชื่อผู้ขอเบิก --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="text" class="form-control-plaintext" value="{{ Auth::user()->username }}" readonly>
                        @endif
                        @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="borrow_date" class="form-label">วันที่ยืม:</label>
                        <input type="date" name="borrow_date" id="borrow_date" class="form-control" value="{{ old('borrow_date') }}" required>
                        @error('borrow_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">วันที่กำหนดคืน:</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                        @error('due_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">หมายเหตุ:</label>
                        <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                        @error('remarks')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    {{-- JS Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#equipments_id').select2({
                placeholder: "-- พิมพ์เพื่อค้นหาและเลือกพัสดุ --",
                allowClear: true,
                width: '100%',
            });

            $('#equipments_id').on('select2:open', function () {
                requestAnimationFrame(function() {
                    setTimeout(function() {
                        let $searchField = $('.select2-container--open .select2-search__field');
                        if ($searchField.length) {
                            $searchField.trigger('focus');
                            let searchFieldNative = $searchField[0];
                            if (searchFieldNative.setSelectionRange) {
                                searchFieldNative.setSelectionRange(searchFieldNative.value.length, searchFieldNative.value.length);
                            }
                        }
                    }, 1);
                });
            });
        });
    </script>
@endsection
