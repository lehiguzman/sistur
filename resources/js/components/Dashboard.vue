<template>
  <div class="small">
    <h4>Reportes del Venta Junio</h4>
    <line-chart :chart-data="datacollection" :height="500"></line-chart>
  </div>
</template>
<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">SISTEMA DE CALIDAD DE TURISMO</a></li>
    </ol>

    <div class="container-fluid">


        <div class="card">
            <div class="card-header">
                <h3 class="text-primary text-center">Graficos estadisticos</h3>
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4 class="text-center">Ausencias por mes</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <barChart :chartData="datacollection" :height="300"></barChart>
                                    <!--<canvas id="compras">                                                
                                    </canvas> -->
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4 class="text-center">Tendencia de encuestas</h4>
                                <h4 class="text-center">Calidad de turismo</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="doughnut-chart" height="100" width="150"></canvas>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</template>

<style lang="css">
.small {
  max-width: 800px;
  /* max-height: 500px; */
  margin:  50px auto;
}
</style>

<script>

import barChart from './vueCharts/barChart.js'
import doughnutChart from './vueCharts/doughnutChart.js'

export default {
  components: {
    barChart,
    doughnutChart    
  },
  data(){
    return {
      datacollection: {},
      datacollection2: {}
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {

    fillData ()
    {
      this.datacollection = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
          datasets: [
            {
              label: 'Ausencias',
              backgroundColor: '#F9A54C',
              data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
            }
          ]
        }

        new Chart(document.getElementById("doughnut-chart"), {
            type: 'doughnut',
            data: {
              labels: ["Positivas", "Negativas"],
              datasets: [
                {
                  label: "Respuestas",
                  backgroundColor: ["#1B37DA", "#F72D39"],
                  data: [10, 20]
                }
              ]
            },
            options: {
              title: {
                display: true,
                text: 'Respuestas'
              },
              animateRotate:true,
            }
        });
    }
  }
}
</script>