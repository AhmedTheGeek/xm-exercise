<template>
  <div class="row">
    <div class="col-md-12" v-show="ready">
      <form @submit.prevent="validateForm" novalidate>
        <div class="mb-3">
          <label for="symbol">Company Symbol</label>
          <v-select
            v-model="selectedSymbol"
            label="companyName"
            :options="symbols"
            required
          ></v-select>
          <div
            v-if="!$v.selectedSymbol.required && $v.selectedSymbol.$dirty"
            class="text-danger"
          >
            Company symbol is required.
          </div>
        </div>

        <div class="mb-3">
          <label for="email">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            v-model="userEmail"
            placeholder="you@example.com"
            required
          />
          <div
            v-if="
              (!$v.userEmail.required || !$v.userEmail.email) &&
                $v.userEmail.$dirty
            "
            class="text-danger"
          >
            A valid Email is required.
          </div>
        </div>

        <div class="mb-3">
          <label for="startDate">Start Date</label>
          <datepicker
            v-model="startDate"
            :disabled-dates="datePicker.startDisabledDate"
            name="startDate"
            v-on:selected="updateDisabledDates"
            required
          ></datepicker>
          <div
            v-if="!$v.startDate.required && !$v.startDate.$dirty"
            class="text-danger"
          >
            Start date is required.
          </div>
        </div>

        <div class="mb-3">
          <label for="endDate">End Date</label>
          <datepicker
            v-model="endDate"
            :disabled-dates="datePicker.endDisabledDate"
            v-if="renderEndDate"
            name="endDate"
            required
          ></datepicker>
          <div
            v-if="!$v.endDate.required && !$v.endDate.$dirty"
            class="text-danger"
          >
            End date is required.
          </div>
        </div>

        <hr class="mb-4" />
        <button class="btn btn-primary btn-lg btn-block" type="submit">
          Submit
        </button>
      </form>
    </div>
    <div class="col-md-12 text-center" v-show="!ready && !error">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="col-md-12" v-show="error">
      <div class="alert alert-danger">
        <b>Communication Error: </b>couldn't reach the backend!
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";
import { required, email } from "vuelidate/lib/validators";

import "vue-select/dist/vue-select.css";

export default {
  name: "HistoricalForm",
  components: {
    vSelect,
    Datepicker,
  },
  validations: {
    userEmail: {
      required,
      email,
    },
    startDate: {
      required,
    },
    endDate: {
      required,
    },
    selectedSymbol: {
      required,
    },
  },
  created() {
    this.fetchSymbols();
  },
  data() {
    return {
      symbols: [],
      ready: false,
      selectedSymbol: null,
      userEmail: null,
      renderEndDate: true,
      error: false,
      startDate: null,
      endDate: null,
      datePicker: {
        startDisabledDate: {
          from: new Date(),
        },
        endDisabledDate: {
          from: new Date(),
        },
      },
    };
  },
  methods: {
    call(endpoint, data) {
      return new Promise((resolve, reject) => {
        const fetchURL = `${process.env.VUE_APP_V1_ENDPOINT}/${endpoint}`;
        fetch(fetchURL, data)
          .then((response) => {
            if (!response || 200 !== response.status) {
              throw new Error(
                `Server replied with status code ${response.status}`
              );
            }
            return response.json();
          })
          .then((data) => resolve(data))
          .catch((error) => reject(error));
      });
    },
    updateDisabledDates(date) {
      this.datePicker.endDisabledDate.to = date;

      if (this.endDate !== null && this.endDate.getTime() < date.getTime()) {
        this.endDate = date;
      }

      //workaround to force rerender the end date picker after disabled date update
      this.renderEndDate = false;
      this.$nextTick(() => {
        this.renderEndDate = true;
      });
    },
    validateForm() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.query();
      }
    },
    query() {
      this.call("historical", {
        method: "POST",
        headers: {
          "Content-Types": "application/json",
        },
        body: JSON.stringify({
          email: this.userEmail,
          symbol: this.selectedSymbol.symbol,
          startDate: this.startDate,
          endDate: this.endDate,
        }),
      });
    },
    fetchSymbols() {
      this.call("symbol")
        .then((response) => {
          this.symbols = response;
          this.ready = true;
        })
        .catch(() => {
          this.error = true;
        });
    },
  },
};
</script>
