<?php


// Query to count verified, unverified, and suspended shops
$sql = "SELECT 
            SUM(CASE WHEN verify = 1 THEN 1 ELSE 0 END) AS total_verified,
            SUM(CASE WHEN verify = 0 THEN 1 ELSE 0 END) AS total_unverified,
            SUM(CASE WHEN verify = 2 THEN 1 ELSE 0 END) AS total_suspended
        FROM shop_profiles";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$totalVerified = $row['total_verified'];
$totalUnverified = $row['total_unverified'];
$totalSuspended = $row['total_suspended'];

// Close connection
$conn->close();
?>

<!-- Step 2: HTML and Chart.js Visualization -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart of Shop Verification Status</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Shop Verification Status Distribution</h2>
    <canvas id="pieChart" width="400" height="200"></canvas>

    <script>
        // Data from PHP
        const totalVerified = <?php echo $totalVerified; ?>;
        const totalUnverified = <?php echo $totalUnverified; ?>;
        const totalSuspended = <?php echo $totalSuspended; ?>;

        // Initialize Chart.js
        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'bar', // Set to 'pie' for pie chart
            data: {
                labels: ['Verified Shops', 'Unverified Shops', 'Suspended Shops'],
                datasets: [{
                    data: [totalVerified, totalUnverified, totalSuspended],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',  // Color for verified
                        'rgba(255, 99, 132, 0.6)',  // Color for unverified
                        'rgba(255, 206, 86, 0.6)'    // Color for suspended
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                const currentValue = tooltipItem.dataset.data[tooltipItem.dataIndex];
                                const percentage = ((currentValue / total) * 100).toFixed(2);
                                return tooltipItem.label + ': ' + currentValue + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
