<?php
require_once "lib/lib.php";

if (!isset($_SESSION["dayList"])) {
  $_SESSION["dayList"] = 7;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (isset($_POST['dayList'])) {
    $inputDays = (int)$_POST['dayList'];

    if ($inputDays < 2) {
      $_SESSION["dayList"] = 2;
    } else {
      $_SESSION["dayList"] = $inputDays;
    }
  }
}

function getDayUsers($db)
{
  $limit = $_SESSION["dayList"];
  $sql = "SELECT DATE(time) AS log_date, COUNT(DISTINCT id) AS unique_users
            FROM loginLog
            GROUP BY DATE(time)
            ORDER BY log_date DESC
            LIMIT :limit";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$dbResults = getDayUsers($db);
$loginData = array_column($dbResults, 'unique_users', 'log_date');
$chartData = [];

for ($i = $_SESSION["dayList"] - 1; $i >= 0; $i--) {
  $date = date('Y-m-d', strtotime("-$i days"));
  $chartLabels[] = date('M d', strtotime($date));
  $chartData[] = [
    'count' => $loginData[$date] ?? 0
  ];
}

$chartValues = [];
foreach ($chartData as $data) {
  $chartValues[] = $data['count'];
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard Data</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
  </div>
</div>

<div class="row">
  <div class="col-12">
    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
  </div>
</div>

<form method="POST" action="" class="d-flex form">
  <label for="dayList">Shown Days</label><br>
  <input type="number" id="dayList" name="dayList" value="<?php echo ($_SESSION["dayList"]) ?>"><br><br>

  <input class="submit" type="submit" value="Go">

</form>

<script>
  const dynamicChartLabels = <?= json_encode($chartLabels ?? ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']); ?>;
  const dynamicChartData = <?= json_encode($chartValues ?? [0, 0, 0, 0, 0, 0, 0]); ?>;
</script>


<style>
  .form {
    gap: 20px;
    display: flex;
  }
</style>