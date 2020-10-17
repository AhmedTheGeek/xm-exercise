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
      <router-link to="/"
        ><button type="button" class="btn btn-outline-danger">
          <svg
            width="1em"
            height="1em"
            viewBox="0 0 16 16"
            class="bi bi-arrow-left-square-fill"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm9.5 8.5a.5.5 0 0 0 0-1H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5z"
            ></path>
          </svg>
          Go back to start over.
        </button></router-link
      >
    </div>
  </div>
</template>
<script>
import TradingVue from "trading-vue-js";
const dateFormat = require("dateformat");

export default {
  name: "HistoricalChart",
  components: {
    TradingVue,
  },
  beforeMount() {
    if (this.$route.params && this.$route.params.response) {
      let chartData = this.$route.params.response.data;
      chartData = chartData
        .filter((item) => item.open !== undefined && item.open !== null)
        .map((item) => {
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
