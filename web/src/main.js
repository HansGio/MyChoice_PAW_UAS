import Vue from "vue";
import App from "./App.vue";
import vuetify from "@/plugins/vuetify";
import router from "./router";
import axios from "axios";

Vue.config.productionTip = false;

Vue.prototype.$http = axios;
Vue.prototype.$api = "https://my-choice-api.herokuapp.com/api";

new Vue({
	vuetify,
	router,
	render: (h) => h(App),
}).$mount("#app");
