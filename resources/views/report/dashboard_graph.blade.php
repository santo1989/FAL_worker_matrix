<div class="container">
    @php
        use Carbon\Carbon;

        // Get data for workers grouped by recommended grade for the last month
        // MODIFIED: Changed 'created_at' to 'updated_at' to fetch recent data
        $last_year_grade_list_with_worker = DB::table('worker_entries')
            ->select('recomanded_grade', DB::raw('COUNT(id_card_no) as total_workers'))
            ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->groupBy('recomanded_grade')
            ->get();

        $last_month_total = $last_year_grade_list_with_worker->sum('total_workers');

        // Get data for workers grouped by recommended grade for the current month
        // MODIFIED: Changed 'created_at' to 'updated_at' to fetch recent data
        $this_year_grade_list_with_worker = DB::table('worker_entries')
            ->select('recomanded_grade', DB::raw('COUNT(id_card_no) as total_workers'))
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->groupBy('recomanded_grade')
            ->get();

        $this_month_total = $this_year_grade_list_with_worker->sum('total_workers');

        // Calculate service length groups (2-year intervals)
        $distinct_service_length_groups = DB::table('worker_entries')
            ->select(
                DB::raw('FLOOR(DATEDIFF(DAY, joining_date, GETDATE()) / (365 * 2)) as service_length_group'), // Groups every 2 years
                DB::raw('COUNT(DISTINCT id_card_no) as total_workers'), // Count distinct workers
            )
            ->whereNull('old_matrix_Data_status')
            ->groupBy(DB::raw('FLOOR(DATEDIFF(DAY, joining_date, GETDATE()) / (365 * 2))'))
            ->get();

        $total_workers = $distinct_service_length_groups->sum('total_workers');
        $all_time_total_recomanded_grade = DB::table('worker_entries')
            ->select('recomanded_grade', DB::raw('COUNT(DISTINCT id_card_no) as total_workers'))
            ->whereNull('old_matrix_Data_status')
            //  ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('recomanded_grade')
            ->get();

        //count total worker except old matrix data and null recomanded grade
        $all_time_total_workers = DB::table('worker_entries')
            ->whereNull('old_matrix_Data_status')
            ->whereNotNull('recomanded_grade')
            ->count();

        // Uncomment to debug
        // dd($service_length_groups);

    @endphp

    <div class="row justify-content-center text-center p-2">
        <div class="col-sm-6 pb-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Last Month</h4>
                </div>
                <div class="card-body">
                    {{-- <canvas id="last_year" width="100" height="100" width="100vw" height="40vh"></canvas> --}}
                    <div id="last_year"></div>
                    <span class="text-muted
                        ">Total Workers: {{ $last_month_total }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 pb-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">This Month</h4>
                </div>
                <div class="card-body">

                    {{-- <canvas id="this_year" width="100vw" height="40vh"></canvas> --}}
                    <div id="this_year"></div>
                    <span class="text-muted">Total Workers: {{ $this_month_total }}</span>


                </div>
            </div>
        </div>

        <div class="col-sm-12 pb-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ALL Time Total Evalueted Record</h4>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Total Workers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_time_total_recomanded_grade as $row)
                                <tr>
                                    @if ($row->recomanded_grade == '')
                                        <td><span class="badge badge-danger">Not Update Yet</span> <a  href="{{ route('empty_grade_list') }}"
                                                class="btn btn-sm btn-primary">Unfinished list</a></td>
                                    </td>
                                    @else
                                        <td>{{ $row->recomanded_grade }}</td>
                                    @endif
                                    @if ($row->recomanded_grade == '')
                                        <td><span class="badge badge-danger">
                                                @php
                                                    $rowtotal_workers = $row->total_workers - $all_time_total_workers;

                                                @endphp
                                                {{ $rowtotal_workers }}
                                            </span></td>
                                    @else
                                        <td>{{ $row->total_workers }}</td>
                                    @endif

                                </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
                                <td>{{ $all_time_total_workers }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div class="col-sm-12 pb-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Service Length</h4>
                </div>
                <div class="card-body">

                    {{-- <canvas id="service_length" width="100vw" height="40vh"></canvas> --}}

                    <div id="service_length"></div>
                    <span class="text-muted">Total Workers: {{ $total_workers }}</span>


                </div>
            </div>
        </div>

    </div>
</div>

@php

    // Initialize an empty array to store the data for the pie chart
    $last_year_chart_data = [];

    // Loop through the database results and prepare the data for Highcharts
    foreach ($last_year_grade_list_with_worker as $row) {
        $last_year_chart_data[] = [
            'name' => $row->recomanded_grade,
            'y' => (int) $row->total_workers, // Convert to integer
        ];
    }

    // Convert the data array to JSON format for Highcharts
    $last_year_chart__json_data = json_encode($last_year_chart_data);

    // Initialize an empty array to store the data for the pie chart
    $this_year_chart_data = [];

    // Loop through the database results and prepare the data for Highcharts
    foreach ($this_year_grade_list_with_worker as $row) {
        $this_year_chart_data[] = [
            'name' => $row->recomanded_grade,
            'y' => (int) $row->total_workers, // Convert to integer
        ];
    }

    // Convert the data array to JSON format for Highcharts
    $this_year_chart__json_data = json_encode($this_year_chart_data);

    // Initialize arrays to store data for the chart
    $serviceLengthGroups = [];
    $totalWorkers = [];
    $totalWorkersPercentage = [];

    // Loop through the database results to calculate the total number of workers
    $totalWorkersCount = 0;
    foreach ($distinct_service_length_groups as $row) {
        $totalWorkersCount += (int) $row->total_workers;
    }

    // echo $totalWorkersCount;
    // Check if totalWorkersCount is zero to avoid division by zero error
    if ($totalWorkersCount != 0) {
        // Loop through the database results and prepare the data for Highcharts
        foreach ($distinct_service_length_groups as $row) {
            // Calculate the lower and upper bounds of the service length group
            $lowerBound = (int) $row->service_length_group * 2;
            $upperBound = $lowerBound + 2;
            $serviceLengthGroup = $lowerBound . '-' . $upperBound;

            // Store data in arrays
            $serviceLengthGroups[] = $serviceLengthGroup;

            $totalWorkers[] = (int) $row->total_workers;

            $totalWorkersPercentage[] = round(((int) $row->total_workers / $totalWorkersCount) * 100, 2); // Calculate percentage
        }
    }

    // dd($serviceLengthGroups, $totalWorkers, $totalWorkersPercentage);
    //convert all data according to serviceLengthGroups value assending order
    // Extract the starting value from each range
    $startingValues = array_map(function ($group) {
        return (int) explode('-', $group)[0]; // Get the first part of the range
    }, $serviceLengthGroups);

    // Use array_multisort to sort by the extracted starting values
    array_multisort($startingValues, SORT_ASC, $serviceLengthGroups, $totalWorkers, $totalWorkersPercentage);

    // Convert arrays to JSON format for Highcharts
    $serviceLengthGroupsJson = json_encode($serviceLengthGroups);
    $totalWorkersJson = json_encode($totalWorkers);
    $totalWorkersPercentageJson = json_encode($totalWorkersPercentage);
@endphp

<script src="https://code.highcharts.com/highcharts.js"></script>


<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Create the pie chart using Highcharts 

    Highcharts.chart('last_year', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Worker Grades Distribution Last Month'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        credits: {
            enabled: false // Remove the Highcharts logo
        },
        series: [{
            name: 'Total Workers',
            colorByPoint: true,
            data: <?php echo $last_year_chart__json_data; ?>
        }]
    });

    // Create the pie chart using Highcharts
    Highcharts.chart('this_year', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Worker Grades Distribution This Month'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        credits: {
            enabled: false // Remove the Highcharts logo
        },
        series: [{
            name: 'Total Workers',
            colorByPoint: true,
            data: <?php echo $this_year_chart__json_data; ?>
        }]
    });

    // Create the column chart using Highcharts


    Highcharts.chart('service_length', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Workers by Service Length Group'
        },
        xAxis: {
            categories: <?php echo $serviceLengthGroupsJson; ?>,
            labels: {
                rotation: -45, // Rotate labels for better readability
                align: 'right'
            }
        },
        yAxis: [{
                title: {
                    text: 'Total Workers'
                },
                labels: {
                    format: '{value}'
                }
            },
            {
                title: {
                    text: 'Percentage of Total'
                },
                labels: {
                    format: '{value}%',
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }
        ],
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.y}</b>',
                    inside: true
                }
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.x + '</b><br/>' +
                    'Total Workers: ' + this.y + '<br/>' +
                    'Percentage of Total: ' + <?php echo $totalWorkersPercentageJson; ?>[this.point.index] + '%';
            }

        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Total Workers',
            data: <?php echo $totalWorkersJson; ?>
        }]
    });
</script>
