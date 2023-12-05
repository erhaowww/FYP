@extends('admin/master')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
              <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
              <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-right"></i>
              </h4>
              <h2 class="mb-5">RM {{ number_format($totalSalesThisWeek, 2) }}</h2>
              <h6 class="card-text">Sales {{ $salesChange >= 0 ? 'Increased' : 'Decreased' }} by {{ number_format(abs($salesChange), 2) }}%</h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
              <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
              <h4 class="font-weight-normal mb-3">Weekly Orders <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
              </h4>
              <h2 class="mb-5">{{ $totalOrdersThisWeek }}</h2>
              <h6 class="card-text">Orders {{ $ordersChange >= 0 ? 'Increased' : 'Decreased' }} by {{ number_format(abs($ordersChange), 2) }}%</h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
              <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
              <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-right"></i>
              </h4>
              <h2 class="mb-5">95,5741</h2>
              <h6 class="card-text">Increased by 5%</h6>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="clearfix">
                <h4 class="card-title float-left">Sales and Order Statistics</h4>
                <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
              </div>
              <canvas id="visit-sale-chart" class="mt-4"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Traffic Sources</h4>
              <canvas id="traffic-chart"></canvas>
              <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Recent Tickets</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th> Assignee </th>
                      <th> Subject </th>
                      <th> Status </th>
                      <th> Last Update </th>
                      <th> Tracking ID </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <img src="assets/images/faces/face1.jpg" class="me-2" alt="image"> David Grey
                      </td>
                      <td> Fund is not recieved </td>
                      <td>
                        <label class="badge badge-gradient-success">DONE</label>
                      </td>
                      <td> Dec 5, 2017 </td>
                      <td> WD-12345 </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="assets/images/faces/face2.jpg" class="me-2" alt="image"> Stella Johnson
                      </td>
                      <td> High loading time </td>
                      <td>
                        <label class="badge badge-gradient-warning">PROGRESS</label>
                      </td>
                      <td> Dec 12, 2017 </td>
                      <td> WD-12346 </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="assets/images/faces/face3.jpg" class="me-2" alt="image"> Marina Michel
                      </td>
                      <td> Website down for one week </td>
                      <td>
                        <label class="badge badge-gradient-info">ON HOLD</label>
                      </td>
                      <td> Dec 16, 2017 </td>
                      <td> WD-12347 </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="assets/images/faces/face4.jpg" class="me-2" alt="image"> John Doe
                      </td>
                      <td> Loosing control on server </td>
                      <td>
                        <label class="badge badge-gradient-danger">REJECTED</label>
                      </td>
                      <td> Dec 3, 2017 </td>
                      <td> WD-12348 </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Recent Updates</h4>
              <div class="d-flex">
                <div class="d-flex align-items-center me-4 text-muted font-weight-light">
                  <i class="mdi mdi-account-outline icon-sm me-2"></i>
                  <span>jack Menqu</span>
                </div>
                <div class="d-flex align-items-center text-muted font-weight-light">
                  <i class="mdi mdi-clock icon-sm me-2"></i>
                  <span>October 3rd, 2018</span>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-6 pe-1">
                  <img src="assets/images/dashboard/img_1.jpg" class="mb-2 mw-100 w-100 rounded" alt="image">
                  <img src="assets/images/dashboard/img_4.jpg" class="mw-100 w-100 rounded" alt="image">
                </div>
                <div class="col-6 ps-1">
                  <img src="assets/images/dashboard/img_2.jpg" class="mb-2 mw-100 w-100 rounded" alt="image">
                  <img src="assets/images/dashboard/img_3.jpg" class="mw-100 w-100 rounded" alt="image">
                </div>
              </div>
              <div class="d-flex mt-5 align-items-top">
                <img src="assets/images/faces/face3.jpg" class="img-sm rounded-circle me-3" alt="image">
                <div class="mb-0 flex-grow">
                  <h5 class="me-2 mb-2">School Website - Authentication Module.</h5>
                  <p class="mb-0 font-weight-light">It is a long established fact that a reader will be distracted by the readable content of a page.</p>
                </div>
                <div class="ms-auto">
                  <i class="mdi mdi-heart-outline text-muted"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Project Status</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Name </th>
                      <th> Due Date </th>
                      <th> Progress </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td> 1 </td>
                      <td> Herman Beck </td>
                      <td> May 15, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 2 </td>
                      <td> Messsy Adam </td>
                      <td> Jul 01, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 3 </td>
                      <td> John Richards </td>
                      <td> Apr 12, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 4 </td>
                      <td> Peter Meggik </td>
                      <td> May 15, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 5 </td>
                      <td> Edward </td>
                      <td> May 03, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> 5 </td>
                      <td> Ronald </td>
                      <td> Jun 05, 2015 </td>
                      <td>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-white">Todo</h4>
              <div class="add-items d-flex">
                <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
              </div>
              <div class="list-wrapper">
                <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Call John </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Create invoice </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Print Statements </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script>
      (function($) {
  'use strict';
  $(function() {

    Chart.defaults.global.legend.labels.usePointStyle = true;
    
    if ($("#visit-sale-chart").length) {
      var maxSales = Math.max(...@json($statistics['sales']));
      var maxOrders = Math.max(...@json($statistics['orders']));
      var maxValue = Math.max(maxSales, maxOrders);
      var stepSize = Math.ceil(maxValue / 6);

      Chart.defaults.global.legend.labels.usePointStyle = true;
      var ctx = document.getElementById('visit-sale-chart').getContext("2d");

      var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeViolet.addColorStop(0, 'rgba(218, 140, 255, 1)');
      gradientStrokeViolet.addColorStop(1, 'rgba(154, 85, 255, 1)');
      var gradientLegendViolet = 'linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))';
      
      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 360);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($statistics['dates']),
            datasets: [
              {
                label: "Sales",
                borderColor: gradientStrokeViolet,
                backgroundColor: gradientStrokeViolet,
                hoverBackgroundColor: gradientStrokeViolet,
                legendColor: gradientLegendViolet,
                pointRadius: 0,
                fill: false,
                borderWidth: 1,
                fill: 'origin',
                data: @json($statistics['sales'])
              },
              {
                label: "Orders",
                borderColor: gradientStrokeRed,
                backgroundColor: gradientStrokeRed,
                hoverBackgroundColor: gradientStrokeRed,
                legendColor: gradientLegendRed,
                pointRadius: 0,
                fill: false,
                borderWidth: 1,
                fill: 'origin',
                data: @json($statistics['orders'])
              }
          ]
        },
        options: {
          responsive: true,
          legend: false,
          legendCallback: function(chart) {
            var text = []; 
            text.push('<ul>'); 
            for (var i = 0; i < chart.data.datasets.length; i++) { 
                text.push('<li><span class="legend-dots" style="background:' + 
                           chart.data.datasets[i].legendColor + 
                           '"></span>'); 
                if (chart.data.datasets[i].label) { 
                    text.push(chart.data.datasets[i].label); 
                } 
                text.push('</li>'); 
            } 
            text.push('</ul>'); 
            return text.join('');
          },
          scales: {
              yAxes: [{
                  ticks: {
                      display: false,
                      min: 0,
                      stepSize: stepSize,
                      max: maxValue
                  },
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(235,237,242,1)',
                    zeroLineColor: 'rgba(235,237,242,1)'
                  }
              }],
              xAxes: [{
                  gridLines: {
                    display:false,
                    drawBorder: false,
                    color: 'rgba(0,0,0,1)',
                    zeroLineColor: 'rgba(235,237,242,1)'
                  },
                  ticks: {
                      padding: 20,
                      fontColor: "#9c9fa6",
                      autoSkip: true,
                  },
                  categoryPercentage: 0.5,
                  barPercentage: 0.5
              }]
            }
          },
          elements: {
            point: {
              radius: 0
            }
          }
      })
      $("#visit-sale-chart-legend").html(myChart.generateLegend());
    }
   
    
  });
})(jQuery);

      </script>
@endsection