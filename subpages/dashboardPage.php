<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard Data</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
    </div>
</div>

<script>
  // Supply the chart data to dashboard.js dynamically
  const dynamicChartData = <?= json_encode($chartValues ?? [15339, 21345, 18483, 24003, 23489, 24092, 12034]); ?>;
</script>