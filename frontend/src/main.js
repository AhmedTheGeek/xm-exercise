import Vue from "vue";
import App from "./App.vue";

Vue.config.productionTip = false;
import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

new Vue({
  render: (h) => h(App),
}).$mount("#app");
