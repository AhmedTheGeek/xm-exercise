<template>
  <div class="container">
    <Header />
    <HistoricalForm />
    <Footer />
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

import HistoricalForm from "./components/HistoricalForm";

export default {
  name: "App",
  components: {
    Header,
    Footer,
    HistoricalForm,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
