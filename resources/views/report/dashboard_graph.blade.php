<x-backend.layouts.master>

    <x-slot name="pageTitle">
        Graphical Report
    </x-slot>
    <div class="container">
        <div class="row justify-content-center text-center p-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Last Year</h4>
                    </div>
                    <div class="card-body">
                        {{-- <canvas id="last_year" width="100" height="100" width="100vw" height="40vh"></canvas> --}}
                        <!-- Add a container for the pie chart -->
                        <div id="last_year" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">This Year</h4>
                    </div>
                    <div class="card-body">

                        {{-- <canvas id="this_year" width="100vw" height="40vh"></canvas> --}}
                        <!-- Add a container for the pie chart -->
                        <div id="this_year" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


                    </div>
                </div>
            </div>

        </div>
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Service Length</h4>
                    </div>
                    <div class="card-body">

                        {{-- <canvas id="service_length" width="100vw" height="40vh"></canvas> --}}

                        <!-- Add a container for the bar chart -->
                        <div id="service_length" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


                    </div>
                </div>
            </div>

        </div>
    </div>


    @php
        $last_year_grade_list_with_worker = DB::table('worker_entries')
            ->select('recomanded_grade', DB::raw('COUNT(id_card_no) as total_workers'))
            ->whereYear('created_at', date('Y') - 1)
            ->groupBy('recomanded_grade')
            ->get();

        $this_year_grade_list_with_worker = DB::table('worker_entries')
            ->select('recomanded_grade', DB::raw('COUNT(id_card_no) as total_workers'))
            ->groupBy('recomanded_grade')
            ->get();

        $distinct_service_length_groups = DB::table('worker_entries')
            ->select(
                DB::raw('FLOOR(DATEDIFF(DAY, joining_date, GETDATE()) / (365 * 2)) as service_length_group'),
                DB::raw('COUNT(id_card_no) as total_workers'),
            )
            ->groupBy(DB::raw('FLOOR(DATEDIFF(DAY, joining_date, GETDATE()) / (365 * 2))'))
            ->get();

        // dd($distinct_service_length_groups)

    @endphp


    <!-- Highcharts start -->
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

    <!-- Include Highcharts library -->
    <script src="https://code.highcharts.com/highcharts.js"></script>


    <script>
        // Create the pie chart using Highcharts
        Highcharts.chart('last_year', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Worker Grades Distribution Last Year'
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
                text: 'Worker Grades Distribution This Year'
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
    <!-- Highcharts CDN End -->

</x-backend.layouts.master>
