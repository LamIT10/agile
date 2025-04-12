<?php
$totalRevenue = $total[0];
$today = date('Y-m-d');
for ($i = 0; $i < 7; $i++) {
    $day = date('Y-m-d', strtotime('-' . $i . ' day'));
    $revenue[] = $day;
}
foreach ($total7Day as $key => $value) {
    $date[] = $value['date'];
}
$final_data = [];
$i = 0;
foreach ($revenue as $key => $value) {
    if (in_array($value, $date)) {
        $final_data[] = $total7Day[$i]['total'];
        $i++;
    } else {
        $final_data[] = 0;
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title fw-bold text-primary">Báo cáo doanh thu</h5>
                </div>
                <div class="d-flex justify-content-between p-3 align-items-start">
                    <form action="?role=admin&action=revenue" method="post" class="p-3 border rounded shadow-sm w-100" style="max-width: 300px;">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="startDate" name="start">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="endDate" name="end">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Xem báo cáo</button>
                    </form>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 30px; font-weight: bold" class="fw-bold text-primary "><?= isset($totalRevenue['total']) ? number_format($totalRevenue['total']) . " VNĐ" : "Không có doanh thu" ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center p-5 bg-white my-4 shadow-sm rounded"><canvas id="myChart" style="width:100%;max-width:800px"></canvas></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    var xValues = [
        <?php
        for ($i = 0; $i < 7; $i++) {
            echo "'" . $revenue[$i] . "',";
        }
        ?>
    ];
    var yValues = [
        <?php
        foreach ($final_data as $key => $value) {
            echo "'" . $value . "',";
        }
        ?>
    ];
    var barColors = [
        "#3d6cd9",
        "#3d6cd9",
        "#3d6cd9",
        "#3d6cd9",
        "#3d6cd9",
        "#3d6cd9",
        "#3d6cd9"
    ];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Doanh thu 7 ngày gần nhất"
            }
        }
    });
</script>