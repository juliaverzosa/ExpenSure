document.addEventListener('DOMContentLoaded', () => {
    const reportTypeSelect = document.getElementById('report-type');
    const datewiseForm = document.getElementById('datewise-form');
    const monthlyForm = document.getElementById('monthly-form');
    const yearlyForm = document.getElementById('yearly-form');

    reportTypeSelect.addEventListener('change', () => {
        const selectedType = reportTypeSelect.value;
        datewiseForm.style.display = 'none';
        monthlyForm.style.display = 'none';
        yearlyForm.style.display = 'none';

        if (selectedType === 'datewise') {
            datewiseForm.style.display = 'block';
        } else if (selectedType === 'monthly') {
            monthlyForm.style.display = 'block';
        } else if (selectedType === 'yearly') {
            yearlyForm.style.display = 'block';
        }
    });

    const ctx = document.getElementById('expense-chart').getContext('2d');
    let expenseChart;

    const createChart = (data, labels, type) => {
        if (expenseChart) {
            expenseChart.destroy();
        }
        expenseChart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Expenses',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    };

    const fetchReportData = async (url, formData) => {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        return result;
    };

    document.getElementById('datewise-report-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const result = await fetchReportData('fetch_datewise_report.php', formData);
        createChart(result.data, result.labels, 'line');
    });

    document.getElementById('monthly-report-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const result = await fetchReportData('fetch_monthly_report.php', formData);
        createChart(result.data, result.labels, 'bar');
    });

    document.getElementById('yearly-report-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const result = await fetchReportData('fetch_yearly_report.php', formData);
        createChart(result.data, result.labels, 'bar');
    });
});
