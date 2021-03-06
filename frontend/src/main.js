import Vue from "vue";
import App from "./App.vue";
import Vuelidate from "vuelidate";
import router from "./router/index";

Vue.config.productionTip = false;
Vue.use(Vuelidate);

new Vue({
  render: (h) => h(App),
  router,
}).$mount("#app");
