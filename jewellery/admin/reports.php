<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once 'includes/auth.php';
requireAdmin();

// Base Metrics
$totalOrders   = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalRevenue  = (float)$pdo->query("SELECT SUM(total) FROM orders WHERE status != 'cancelled'")->fetchColumn();
$totalItems    = (int)$pdo->query("SELECT SUM(quantity) FROM order_items oi JOIN orders o ON oi.order_id=o.id WHERE o.status != 'cancelled'")->fetchColumn();

// Sales by Category
$catSales = $pdo->query("
  SELECT c.name as cat_name, COALESCE(SUM(oi.price * oi.quantity), 0) as revenue 
  FROM categories c 
  LEFT JOIN products p ON c.id = p.category_id 
  LEFT JOIN order_items oi ON p.id = oi.product_id
  LEFT JOIN orders o ON oi.order_id = o.id AND o.status != 'cancelled'
  GROUP BY c.id 
  ORDER BY revenue DESC
")->fetchAll();

// Top Selling Products
$topProducts = $pdo->query("
  SELECT p.name, p.image1, SUM(oi.quantity) as sold_qty, SUM(oi.price * oi.quantity) as revenue
  FROM products p 
  JOIN order_items oi ON p.id = oi.product_id 
  JOIN orders o ON oi.order_id = o.id 
  WHERE o.status != 'cancelled' 
  GROUP BY p.id 
  ORDER BY sold_qty DESC 
  LIMIT 5
")->fetchAll();

// Order Status Distribution
$statusDist = $pdo->query("
  SELECT status, COUNT(*) as count 
  FROM orders 
  GROUP BY status
")->fetchAll();

$adminTitle = 'Reports & Analytics';
include 'includes/header.php';
?>

<div class="admin-cards">
  <div class="admin-card">
    <div class="card-icon gold"><i class="fas fa-box" style="color:#c9a227;font-size:22px;"></i></div>
    <div><div class="card-num"><?= number_format($totalOrders) ?></div><div class="card-lbl">Total Orders</div></div>
  </div>
  <div class="admin-card green-border">
    <div class="card-icon green"><i class="fas fa-indian-rupee-sign" style="color:#27ae60;font-size:22px;"></i></div>
    <div><div class="card-num">₹<?= number_format($totalRevenue/1000, 1) ?>K</div><div class="card-lbl">Total Revenue</div></div>
  </div>
  <div class="admin-card blue-border">
    <div class="card-icon blue"><i class="fas fa-cubes" style="color:#2980b9;font-size:22px;"></i></div>
    <div><div class="card-num"><?= number_format($totalItems) ?></div><div class="card-lbl">Items Sold</div></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
  <!-- Sales by Category Chart -->
  <div class="chart-wrap" style="position:relative; height:350px;">
    <h3>📊 Sales by Category</h3>
    <canvas id="categoryChart"></canvas>
  </div>

  <!-- Order Status Chart -->
  <div class="chart-wrap" style="position:relative; height:350px;">
    <h3>📌 Order Status Distribution</h3>
    <canvas id="statusChart"></canvas>
  </div>
</div>

<div class="admin-table-wrap">
  <div class="admin-table-head">
    <h3>⭐ Top Selling Products</h3>
  </div>
  <table>
    <thead><tr><th>Product Name</th><th>Units Sold</th><th>Total Revenue Generated</th></tr></thead>
    <tbody>
      <?php foreach ($topProducts as $p): ?>
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            <img src="<?= SITE_URL ?>/uploads/products/<?= safeHtml($p['image1']) ?>" style="width:40px;height:40px;border-radius:6px;object-fit:cover;"/>
            <span style="font-size:13px;font-weight:500;"><?= safeHtml($p['name']) ?></span>
          </div>
        </td>
        <td><strong><?= $p['sold_qty'] ?></strong> Units</td>
        <td><span class="badge badge-gold">₹<?= number_format($p['revenue']) ?></span></td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($topProducts)): ?><tr><td colspan="3" style="text-align:center;">No sales data available yet.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Category Chart
const ctxCat = document.getElementById('categoryChart').getContext('2d');
new Chart(ctxCat, {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_column($catSales,'cat_name')) ?>,
    datasets: [{
      data: <?= json_encode(array_column($catSales,'revenue')) ?>,
      backgroundColor: ['#c9a227','#27ae60','#2980b9','#e74c3c','#8e44ad','#f39c12'],
      borderWidth: 0,
      hoverOffset: 4
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'right', labels: { boxWidth: 12, usePointStyle: true } }
    }
  }
});

// Status Chart
const ctxStatus = document.getElementById('statusChart').getContext('2d');
new Chart(ctxStatus, {
  type: 'pie',
  data: {
    labels: <?= json_encode(array_map(function($s){ return ucwords(str_replace('_',' ',$s['status'])); }, $statusDist)) ?>,
    datasets: [{
      data: <?= json_encode(array_column($statusDist,'count')) ?>,
      backgroundColor: ['#3498db','#2ecc71','#f1c40f','#e67e22','#e74c3c','#95a5a6'],
      borderWidth: 0,
      hoverOffset: 4
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'right', labels: { boxWidth: 12, usePointStyle: true } }
    }
  }
});
</script>

<?php include 'includes/footer.php'; ?>
