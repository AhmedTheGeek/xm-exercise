<template>
  <div>
    <VueApexCharts
      type="candlestick"
      height="350"
      :options="chartOptions"
      :series="series"
    ></VueApexCharts>
    <router-link to="/">Go back!</router-link>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
  name: "HistoricalChart",
  components: {
    VueApexCharts,
  },
  beforeMount() {
    if (this.$route.params && this.$route.params.response) {
      let chartData = this.$route.params.response;
      this.series.push({
        data: chartData.prices.map((item) => {
          return [
            item.date * 1000,
            [
              parseFloat(item.open).toFixed(2),
              parseFloat(item.high).toFixed(2),
              parseFloat(item.low).toFixed(2),
              parseFloat(item.close).toFixed(2),
            ],
          ];
        }),
      });
    }
  },
  data() {
    return {
      series: [],
      chartOptions: {
        chart: {
          type: "candlestick",
          height: 350,
        },
        title: {
          text: "CandleStick Chart",
          align: "left",
        },
        xaxis: {
          type: "datetime",
        },
        yaxis: {
          tooltip: {
            enabled: true,
          },
        },
      },
    };
  },
};
</script>
