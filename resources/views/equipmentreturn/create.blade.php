@extends('template.backend')

@section('content')
    <!-- Core CSS -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container mt-2 w-75">
        <div class="container mt-0">
            <div class="card shadow-lg w-75 mx-auto">
                <h2 class="text-center mt-3">เพิ่มการคืนพัสดุ</h2>
                <form action="{{ route('equipmentreturn.store') }}" method="POST" class="mb-3 p-4">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="borrow_id">เลือกการยืม:</label>
                        <select name="borrow_id" id="borrow_id" class="form-control" required>
                            <option value="">-- เลือกไอดีการยืม --</option>
                            @foreach($borrows as $borrow)
                                @php
                                    $totalReturned = $returnedQuantities[$borrow->id] ?? 0;
                                    $remaining = $borrow->quantity - $totalReturned;
                                @endphp
                                <option value="{{ $borrow->id }}" data-remaining="{{ $remaining }}">
                                    ID: {{ $borrow->id }} |
                                    อุปกรณ์: {{ $borrow->equipment->equipment_name }}
                                    (ยืม {{ $borrow->quantity }} {{ $borrow->equipment_type->equipmenttype_name }},
                                    คืนแล้ว {{ $totalReturned }}, คงเหลือ {{ $remaining }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- เอาช่องจำนวนที่คืนออก หรือจะทำให้กรอกได้เท่าที่เหลือ --}}
                    <div class="form-group mb-3">
                        <label for="quantity">จำนวนที่คืน (ไม่เกินจำนวนคงเหลือ):</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="return_date">วันที่คืน:</label>
                        <input type="date" name="return_date" id="return_date" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="remarks">หมายเหตุ:</label>
                        <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">บันทึกการคืน</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // จำกัดจำนวนคืนให้ไม่เกินจำนวนคงเหลือของ borrow ที่เลือก
        const borrowSelect = document.getElementById('borrow_id');
        const quantityInput = document.getElementById('quantity');

        borrowSelect.addEventListener('change', function () {
            const selectedOption = borrowSelect.options[borrowSelect.selectedIndex];
            const remaining = selectedOption.getAttribute('data-remaining');

            quantityInput.max = remaining;
            quantityInput.value = remaining > 0 ? 1 : 0;
            quantityInput.min = 1;
            if (remaining == 0) {
                quantityInput.disabled = true;
            } else {
                quantityInput.disabled = false;
            }
        });

        // trigger change event on page load to set proper max/min
        borrowSelect.dispatchEvent(new Event('change'));
    </script>
@endsection