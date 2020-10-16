import Vue from 'vue';
import Router from 'vue-router';
import HistoricalForm from '../components/HistoricalForm'
import HistoricalChart from '../components/HistoricalChart'

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: "Form",
            component: HistoricalForm
        },
        {
            path: '/chart',
            name: "HistoricalChart",
            component: HistoricalChart
        }
    ],
})