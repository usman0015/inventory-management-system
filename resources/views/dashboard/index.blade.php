@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h4>
    <span class="text-muted" style="font-size:0.85rem;">Welcome back, here's your overview</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #2563eb;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Items</div>
                <div class="stat-value"><span class="counter" data-target="{{ $totalItems }}">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: #16a34a;">
                <i class="bi bi-archive"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Stock</div>
                <div class="stat-value"><span class="counter" data-target="{{ $totalStockUnits }}">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706;">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value"><span class="counter" data-target="{{ $totalOrders }}">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Completed</div>
                <div class="stat-value"><span class="counter" data-target="{{ $completedOrders }}">0</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="app-card">
            <div class="app-card-header">
                <h6 class="mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Inventory by Category</h6>
            </div>
            <div class="app-card-body" style="padding: 16px 20px;">
                <div id="inventoryChart" style="min-height: 350px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="app-card mb-4" style="animation-delay: 0.35s;">
            <div class="app-card-header" style="background: linear-gradient(135deg, #0d6efd, #6610f2); border-bottom: none;">
                <h6 class="mb-0 text-white"><i class="bi bi-cpu me-2"></i>AI Insights</h6>
            </div>
            <div class="app-card-body" style="padding: 20px;">
                <p class="mb-0" style="font-size:0.9rem; line-height:1.65; color: var(--text-secondary);">{{ $summary }}</p>
            </div>
        </div>

        <div class="app-card" style="animation-delay: 0.45s;">
            <div class="app-card-header">
                <h6 class="mb-0"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            </div>
            <div class="app-card-body" style="padding: 16px 20px;">
                <a href="{{ route('orders.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none mb-2" style="background: var(--bg-surface-2); transition: background-color 0.2s ease, border-color 0.2s ease; border: 1px solid transparent;">
                    <div style="width:42px; height:42px; border-radius:10px; background: linear-gradient(135deg, #eff6ff, #dbeafe); color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0;">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem; color: var(--text-primary);">Manage Orders</div>
                        <div style="font-size:0.78rem; color: var(--text-muted);">View & track customer orders</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color: var(--text-faint); font-size:0.8rem;"></i>
                </a>
                <a href="{{ route('items.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background: var(--bg-surface-2); transition: background-color 0.2s ease, border-color 0.2s ease; border: 1px solid transparent;">
                    <div style="width:42px; height:42px; border-radius:10px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); color:#059669; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem; color: var(--text-primary);">Manage Items</div>
                        <div style="font-size:0.78rem; color: var(--text-muted);">Add & organize your inventory</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color: var(--text-faint); font-size:0.8rem;"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    function isDarkTheme() {
        return document.documentElement.getAttribute('data-bs-theme') === 'dark';
    }

    function buildOptions() {
        var dark = isDarkTheme();
        var labelColor = dark ? '#94a3b8' : '#6b7280';
        var gridColor = dark ? '#24375c' : '#f3f4f6';

        return {
            chart: {
                type: 'bar',
                height: 380,
                toolbar: { show: false },
                background: 'transparent',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 900,
                    animateGradually: { enabled: true, delay: 200 }
                },
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
            },
            series: [{
                name: 'Items in Stock',
                data: @json($data)
            }],
            xaxis: {
                categories: @json($labels),
                labels: {
                    style: { colors: labelColor, fontSize: '13px', fontWeight: 500 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                title: { text: 'Total Items', style: { fontSize: '13px', color: labelColor } },
                labels: { style: { colors: labelColor, fontSize: '12px' } }
            },
            colors: ['#0d6efd'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '55%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: true,
                style: { colors: ['#fff'], fontWeight: 600, fontSize: '12px' },
                background: { enabled: false }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
                padding: { left: 10 }
            },
            tooltip: {
                theme: dark ? 'dark' : 'light',
                style: { fontSize: '13px' },
                y: { formatter: function(val) { return val + " items"; } }
            },
            states: {
                hover: { filter: { type: 'darken', value: 0.85 } }
            }
        };
    }

    var options = buildOptions();
    var chart = new ApexCharts(document.querySelector("#inventoryChart"), options);
    chart.render();

    window.addEventListener('themeChanged', function (e) {
        chart.updateOptions(buildOptions());
    });
});
</script>
@endsection
