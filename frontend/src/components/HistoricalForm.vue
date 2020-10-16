<template>
  <div class="row">
    <div class="col-md-12" v-show="ready">
      <h4 class="mb-3">Query Historical Symbol Data</h4>
      <form @submit.prevent="validateForm" novalidate>
        <div class="mb-3">
          <label for="symbol">Company Symbol</label>
          <v-select
            v-model="selectedSymbol"
            label="companyName"
            :options="symbols"
            required
          ></v-select>
          <div class="invalid-feedback">
            Company Symbol is required
          </div>
        </div>

        <ValidationProvider name="email" rules="required|email">
          <div class="mb-3" slot-scope="{ errors }">
            <label for="email">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="userEmail"
              placeholder="you@example.com"
              required
            />
            <div class="invalid-feedback">
              {{ errors[0] }}
            </div>
          </div>
        </ValidationProvider>

        <div class="mb-3">
          <label for="startDate">Start Date</label>
          <datepicker
            v-model="datePicker.startDate"
            :disabled-dates="datePicker.startDisabledDate"
            name="startDate"
            v-on:selected="updateDisabledDates"
            required
          ></datepicker>
          <div class="invalid-feedback">
            Please select a valid date
          </div>
        </div>

        <div class="mb-3">
          <label for="endDate">End Date</label>
          <datepicker
            v-model="datePicker.endDate"
            :disabled-dates="datePicker.endDisabledDate"
            v-if="renderEndDate"
            name="endDate"
            required
          ></datepicker>
          <div class="invalid-feedback">
            Please select a valid date
          </div>
        </div>

        <hr class="mb-4" />
        <button
          class="btn btn-primary btn-lg btn-block"
          type="submit"
          v-on:click="query"
        >
          Submit
        </button>
      </form>
    </div>
    <div class="col-md-12 text-center" v-show="!ready">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";
import { ValidationProvider } from "vee-validate";

import { extend } from "vee-validate";
import { required, email } from "vee-validate/dist/rules";

import "vue-select/dist/vue-select.css";

// Add the required rule
extend("required", {
  ...required,
  message: "This field is required",
});

// Add the email rule
extend("email", {
  ...email,
  message: "This field must be a valid email",
});

export default {
  name: "HistoricalForm",
  components: {
    vSelect,
    Datepicker,
    ValidationProvider,
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
      datePicker: {
        startDisabledDate: {
          from: new Date(),
        },
        endDisabledDate: {
          from: new Date(),
        },
        startDate: null,
        endDate: null,
      },
    };
  },
  methods: {
    updateDisabledDates(date) {
      this.datePicker.endDisabledDate.to = date;

      if (
        this.datePicker.endDate !== null &&
        this.datePicker.endDate.getTime() < date.getTime()
      ) {
        this.datePicker.endDate = date;
      }

      //workaround to force rerender the end date picker after disabled date update
      this.renderEndDate = false;
      this.$nextTick(() => {
        this.renderEndDate = true;
      });
    },
    validateForm() {
      this.$validator.validate().then((valid) => {
        if (valid) {
          alert("SUCCESS!! :-)\n\n" + JSON.stringify(this.user));
        }
      });
    },
    query() {
      //   event.preventDefault();
      console.log("hola");
    },
    async fetchSymbols() {
      const response = await fetch(process.env.VUE_APP_SYMBOLS_ENDPOINT);
      if (response.status !== 200) {
        throw new Error("rqeuest failed");
      }
      this.symbols = await response.json();
      this.ready = true;
    },
  },
};
</script>
