<template>
    <Bar

        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />
</template>

<script setup>
import { ref, watch } from 'vue'
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,ChartDataLabels)
const props= defineProps(['labels','data'])



const chartData = ref({
    labels:  props.labels,

    datasets: [{
        axis: 'y',
        data: props.data,
        fill: true,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ],
        borderWidth: 1,
        label:'Количество оценок',

    }],

})

const chartOptions = ref({

    indexAxis: 'y',
    backgroundColor:  'rgba(0, 0, 0, 0)',
    scales: {
        x: {
            display: false, // Убираем ось X
            grid: {
                display: false // Убираем сетку по оси X
            },
            ticks: {
                // Include a dollar sign in the ticks
               display:true,
                showLabelBackdrop:false,
                font: {
                    weight: 'bold', // Устанавливаем жирный шрифт для меток оси Y,

                }

            }
        },
        y: {
            grid: {
                display: false // Убираем сетку по оси Y
            },
            ticks: {
                font: {
                    weight: 'bold', // Устанавливаем жирный шрифт для меток оси Y
                    size:16
                }
            }

        }
    },
    plugins: {

        legend: {
            display: false // Убираем легенду
        },
        datalabels: {
            color: 'blue',
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                },
                value: {
                    color: 'green'
                }
            }
        }
    },
})




</script>
