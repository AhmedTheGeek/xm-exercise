<template>
  <div class="table-responsive">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Open</th>
          <th scope="col">High</th>
          <th scope="col">Low</th>
          <th scope="col">Close</th>
          <th scope="col">Volume</th>
        </tr>
      </thead>
      <tbody>
        <tr v-bind:key="item.date" v-for="item in items">
          <th scope="row">{{ formatTimestamp(item.date) }}</th>
          <td>{{ fixDecimalCount(item.open) }}</td>
          <td>{{ fixDecimalCount(item.high) }}</td>
          <td>{{ fixDecimalCount(item.low) }}</td>
          <td>{{ fixDecimalCount(item.close) }}</td>
          <td>{{ fixDecimalCount(item.volume) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
const dateFormat = require("dateformat");

export default {
  name: "HistoricalTable",
  props: ["items"],
  methods: {
    formatTimestamp(timestamp) {
      return dateFormat(new Date(timestamp * 1000), "dd-mm-yyyy");
    },
    fixDecimalCount(number) {
      return parseFloat(number).toFixed(2);
    },
  },
};
</script>
