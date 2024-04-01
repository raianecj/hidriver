// Alterar SIDEBAR
var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar(){
    if(!sidebarOpen){
        sidebar.classList.add("sidebar-responsive");
        sidebarOpen = true;
    }
}

function closeSidebar(){
    if(sidebarOpen) {
        sidebar.classList.remove("sidebar-responsive");
        sidebarOpen = false;
    }
}

// ----------- Relatórios - ApexCharts ----------
// Relatório de Barra
// https://apexcharts.com/javascript-chart-demos/bar-charts/basic/
var barChartOptions = {
    series: [{
    data: [10, 8, 6, 4, 2]
  }],
    chart: {
    type: 'bar',
    height: 350,
    toolbar: {
        show: false
    },
  },
  colors: [
    '#246dec', '#cc3c43', '#367952', '#f5b74f', '#4f35a1'
  ],
  plotOptions: {
    bar: {
        distributed: true,
      borderRadius: 4,
      horizontal: false,
      columnWidth: '40%',
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
  xaxis: {
    categories: ['Fiesta', 'Fazer 150cc', 'Jimny'
    ],
  },
  yaxis: {
    title: {
        text: "Count"
    }
  }
  };

  var barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
  barChart.render();

// Relatório Area
// https://apexcharts.com/javascript-chart-demos/mixed-charts/line-area/
var areaChartOptions = {
    series: [{
    name: 'Ordem de Compra',

    data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33]
  }, {
    name: 'Ordem de Venda',

    data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43]
  }],
    chart: {
    height: 350,
    type: 'area',
    toolbar: {
        show: false,
    },
  },
  colors: ['#4f35a1', '#246dec'],
  dataLabels:{
    enabled:false,
  },
  stroke: {
    curve: 'smooth'
  },
  labels: ['Dec 01', 'Dec 02','Dec 03','Dec 04','Dec 05','Dec 06','Dec 07','Dec 08','Dec 09 ','Dec 10','Dec 11'],
  markers: {
    size: 0
  },
  yaxis: [
    {
      title: {
        text: 'Ordem de Compra',
      },
    },
    {
      opposite: true,
      title: {
        text: 'Ordem de Venda',
      },
    },
  ],
  tooltip: {
    shared: true,
    intersect: false,
   
  }
  };

  var areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartOptions);
  areaChart.render();


