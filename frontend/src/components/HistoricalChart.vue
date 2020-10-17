<template>
  <div>
    <div class="row">
      <div class="col-md-6 mx-auto text-center">
        <h4>
          Historical data for {{ currentCompany }}, {{ startDate }} -
          {{ endDate }}
        </h4>
        <hr />
      </div>
    </div>
    <div class="row">
      <TradingVue
        id="trading-chart"
        class="container-fluid"
        :data="chart"
        :color-back="colors.colorBack"
        :color-grid="colors.colorGrid"
        :color-text="colors.colorText"
      ></TradingVue>
    </div>
    <div class="row">
      <HistoricalTable v-bind:items="this.filteredData" />
    </div>
    <div class="row">
      <router-link to="/"
        ><button type="button" class="btn btn-outline-danger">
          Go back to start over.
        </button></router-link
      >
    </div>
  </div>
</template>
<script>
import HistoricalTable from "./HistoricalTable";
import TradingVue from "trading-vue-js";
const dateFormat = require("dateformat");

export default {
  name: "HistoricalChart",
  components: {
    TradingVue,
    HistoricalTable,
  },
  beforeMount() {
    if (this.$route.params && this.$route.params.response) {
      let chartData = this.$route.params.response.data;
      this.filteredData = chartData.filter(
        (item) => item.open !== undefined && item.open !== null
      );
      chartData = this.filteredData.map((item) => {
        return [
          item.date * 1000,
          item.open,
          item.high,
          item.low,
          item.close,
          item.volume,
        ];
      });
      chartData.sort((a, b) => {
        return a[0] - b[0];
      });
      this.chart.ohlcv = chartData;
    } else {
      this.$router.push("/");
    }
    if (this.$route.params.symbol) {
      this.currentCompany = this.$route.params.symbol.companyName;
      this.startDate = this.formatTimestamp(this.$route.params.startDate);
      this.endDate = this.formatTimestamp(this.$route.params.endDate);
    }
  },
  methods: {
    formatTimestamp(timestamp) {
      return dateFormat(new Date(timestamp), "dd/mmmm/yyyy");
    },
  },
  data() {
    return {
      currentCompany: null,
      startDate: null,
      endDate: null,
      filteredData: [],
      chart: {
        type: "Candles",
        ohlcv: [],
      },
      colors: {
        colorBack: "#fff",
        colorGrid: "#eee",
        colorText: "#333",
      },
    };
  },
};
</script>
