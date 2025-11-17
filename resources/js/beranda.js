import Chart from 'chart.js/auto';

// --- Chart.js ---
const ctx = document.getElementById('weeklyChart').getContext('2d');

// Membuat gradient fill
const gradientPemasukan = ctx.createLinearGradient(0, 0, 0, 150);
gradientPemasukan.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
gradientPemasukan.addColorStop(1, 'rgba(99, 102, 241, 0)');

const gradientPengeluaran = ctx.createLinearGradient(0, 0, 0, 150);
gradientPengeluaran.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
gradientPengeluaran.addColorStop(1, 'rgba(239, 68, 68, 0)');

const weeklyChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Pemasukan',
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: '#6366F1', // Indigo-500
            backgroundColor: gradientPemasukan,
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#6366F1',
            pointRadius: 0,
            pointHoverRadius: 5,
        }, {
            label: 'Pengeluaran',
            data: [28, 48, 40, 19, 86, 27, 90],
            borderColor: '#EF4444', // Red-500
            backgroundColor: gradientPengeluaran,
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#EF4444',
            pointRadius: 0,
            pointHoverRadius: 5,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 50,
                    color: '#9CA3AF'
                },
                grid: {
                    drawBorder: false,
                    color: '#E5E7EB',
                }
            },
            x: {
                ticks: {
                    color: '#9CA3AF'
                },
                grid: {
                    display: false,
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    boxWidth: 20,
                    padding: 20,
                    color: '#374151',
                }
            },
            tooltip: {
                backgroundColor: '#1F2937',
                titleFont: { size: 14 },
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                boxPadding: 4
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
    }
});