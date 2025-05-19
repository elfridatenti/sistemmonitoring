@extends('layout.header-sidebar')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistem Informasi Mesin Molding</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            :root {
                --primary-color: #3b82f6;
                --primary-light: #93c5fd;
                --secondary-color: #0f172a;
                --text-color: #1e293b;
                --text-light: #64748b;
                --bg-color: #eeeeee;
                --card-bg: #ffffff;
                --card-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --danger-color: #ef4444;
                --info-color: #06b6d4;
            }

            /* Base styles */
            body {
                background-color: var(--bg-color);
                font-family: 'Inter', sans-serif;
                color: var(--text-color);
                line-height: 1.5;
            }

            /* Card styles */
            .dashboard-cards {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 20px;
            }

            .stat-card {
                background: var(--card-bg);
                border-radius: 10px;
                box-shadow: var(--card-shadow);
                padding: 20px;
                flex: 1;
                min-width: 260px;
                border: 1px solid rgba(226, 232, 240, 0.8);
                transition: transform 0.2s ease;
            }

            .stat-card:hover {
                transform: translateY(-3px);
            }

            .stat-header {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }

            .icon-circle {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
            }

            .user-icon {
                background-color: #dbeafe;
                color: var(--primary-color);
            }

            .downtime-icon {
                background-color: #fee2e2;
                color: var(--danger-color);
            }

            .setup-icon {
                background-color: #fef3c7;
                color: var(--warning-color);
            }

            .stat-title {
                color: var(--text-light);
                font-size: 0.9rem;
                font-weight: 500;
                margin: 0;
            }

            .stat-value {
                font-size: 2rem;
                font-weight: 550;
                color: var(--secondary-color);
                margin: 5px 0 15px 0;
            }

            .stat-badges {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .stat-badge {
                font-size: 0.75rem;
                padding: 4px 8px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                font-weight: 500;
            }

            .badge-waiting {
                background-color: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
            }

            .badge-processing {
                background-color: rgba(59, 130, 246, 0.1);
                color: var(--primary-color);
            }

            .badge-qc {
                background-color: rgba(6, 182, 212, 0.1);
                color: var(--info-color);
            }

            .badge-completed {
                background-color: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .badge-dot {
                display: inline-block;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                margin-right: 6px;
            }

            .dot-waiting {
                background-color: var(--warning-color);
            }

            .dot-processing {
                background-color: var(--primary-color);
            }

            .dot-qc {
                background-color: var(--info-color);
            }

            .dot-completed {
                background-color: var(--success-color);
            }

            /* Chart card */
            .chart-card {
                background: var(--card-bg);
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                padding: 20px;
                margin-bottom: 20px;
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            .chart-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .chart-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--secondary-color);
                margin: 0;
            }

            .chart-container {
                height: 380px;
            }

            .total-defects {
                display: flex;
                align-items: center;
            }

            /* Responsive adjustments */
            @media (max-width: 992px) {
                .dashboard-cards {
                    flex-direction: column;
                }

                .stat-card {
                    width: 100%;
                }

                .chart-container {
                    height: 300px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            <div class="dashboard-cards">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="icon-circle user-icon">
                            <i class="bi bi-people" style="font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <h4 class="stat-title">Total Users</h4>
                        </div>
                    </div>
                    <div class="stat-value">{{ $data['user']['total'] }}</div>
                    <div class="stat-badges">
                        <span class="stat-badge badge-waiting">
                            <span class="badge-dot dot-waiting"></span>
                            Teknisi: {{ $data['user']['teknisi'] }}
                        </span>
                        <span class="stat-badge badge-processing">
                            <span class="badge-dot dot-processing"></span>
                            Leader: {{ $data['user']['leader'] }}
                        </span>
                        <span class="stat-badge badge-qc">
                            <span class="badge-dot dot-qc"></span>
                            IPQC: {{ $data['user']['ipqc'] }}
                        </span>
                        <span class="stat-badge badge-completed">
                            <span class="badge-dot dot-completed"></span>
                            Admin: {{ $data['user']['admin'] }}
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="icon-circle downtime-icon">
                            <i class="bi bi-clock-history" style="font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <h3 class="stat-title">Downtime</h3>
                        </div>
                    </div>
                    <div class="stat-value">{{ $data['downtime']['total'] }}</div>
                    <div class="stat-badges">
                        <span class="stat-badge badge-waiting">
                            <span class="badge-dot dot-waiting"></span>
                            Waiting: {{ $data['downtime']['Waiting'] }}
                        </span>
                        <span class="stat-badge badge-processing">
                            <span class="badge-dot dot-processing"></span>
                            Processed: {{ $data['downtime']['In_Progress'] }}
                        </span>
                        <span class="stat-badge badge-qc">
                            <span class="badge-dot dot-qc"></span>
                            Waiting QC: {{ $data['downtime']['Waiting_QC_Approve'] }}
                        </span>
                        <span class="stat-badge badge-completed">
                            <span class="badge-dot dot-completed"></span>
                            Completed: {{ $data['downtime']['Completed'] }}
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="icon-circle setup-icon">
                            <i class="bi bi-gear" style="font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <h3 class="stat-title">Setup Requests</h3>
                        </div>
                    </div>
                    <div class="stat-value">{{ $data['setup']['total'] }}</div>
                    <div class="stat-badges">
                        <span class="stat-badge badge-waiting">
                            <span class="badge-dot dot-waiting"></span>
                            Waiting: {{ $data['setup']['Waiting'] }}
                        </span>
                        <span class="stat-badge badge-processing">
                            <span class="badge-dot dot-processing"></span>

                            Processed: {{ $data['setup']['In Progress'] }}
                        </span>
                        <span class="stat-badge badge-qc">
                            <span class="badge-dot dot-qc"></span>
                            Waiting QC: {{ $data['setup']['Waiting_QC_Approve'] }}
                        </span>
                        <span class="stat-badge badge-completed">
                            <span class="badge-dot dot-completed"></span>
                            Selesai: {{ $data['setup']['Completed'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Distribusi Kategori Defect</h3>
                    <div class="total-defects">
                        <span class="stat-badge badge-completed">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Total Downtime: <span id="totalDefectCount">0</span>
                        </span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="defectChart"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetch('/dashboard/defect-chart')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const totalDefects = data.counts.reduce((a, b) => a + b, 0);
                        document.getElementById('totalDefectCount').textContent = totalDefects.toLocaleString();

                        const canvas = document.getElementById('defectChart');
                        if (!canvas) {
                            console.error('Canvas element not found');
                            return;
                        }

                        const ctx = canvas.getContext('2d');

                        if (!data.categories || !data.counts) {
                            console.error('Invalid data format');
                            return;
                        }

                        const colors = [
                            '#60a5fa', // blue
                            '#f87171', // red
                            '#34d399', // green
                            '#fbbf24', // yellow
                            '#a78bfa', // purple
                            '#22d3ee', // cyan
                            '#3b82f6' // blue
                        ];

                        const backgroundColors = colors.map(color => `${color}dd`);
                        const borderColors = colors;

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.categories,
                                datasets: [{
                                    label: 'Jumlah Defect',
                                    data: data.counts,
                                    backgroundColor: backgroundColors,
                                    borderColor: borderColors,
                                    borderWidth: 1,
                                    borderRadius: 4,
                                    maxBarThickness: 60
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.04)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(15, 23, 42, 0.8)',
                                        padding: 12
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching chart data:', error);
                        const chartContainer = document.querySelector('.chart-container');
                        chartContainer.innerHTML = `
                    <div style="background-color: #fee2e2; color: #b91c1c; padding: 16px; border-radius: 8px; text-align: center;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Gagal memuat data chart. Silakan coba lagi nanti.
                    </div>
                `;
                    });
            });
        </script>
    </body>

    </html>
@endsection
