@extends('template.backend')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container mt-5">
    <h1 class="mb-4 text-center">จำนวนครุภัณฑ์ที่ยืมได้</h1>

    <!-- แสดงวันที่ปัจจุบัน (ภาษาไทย) -->
    <p class="text-center text-muted">วันที่: {{ \Carbon\Carbon::now()->locale('th')->translatedFormat('j F Y') }}</p>

    <div class="row justify-content-center">
        <!-- กราฟจำนวนอุปกรณ์ใน Stock -->
        <div class="col-md-10 col-lg-8"> 
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">กราฟจำนวนครุภัณฑ์ในคลัง</h5>
                    <canvas id="equipmentsChart" style="max-height: 400px;"></canvas>

                    <script>
                        const equipmentData = @json($equipmentData);
                        const labelsEquipments = equipmentData.map(data => data.equipment_name);
                        const stockValuesEquipments = equipmentData.map(data => data.stock);

                        const ctxEquipments = document.getElementById('equipmentsChart').getContext('2d');
                        new Chart(ctxEquipments, {
                            type: 'bar',
                            data: {
                                labels: labelsEquipments,
                                datasets: [{
                                    label: 'จำนวนในคลัง',
                                    data: stockValuesEquipments,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                    },
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
