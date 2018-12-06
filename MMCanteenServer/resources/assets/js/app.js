require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import VueAxios from "vue-axios";
import axios from "axios";

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.component("App", require("./components/App.vue"));

import routes from "./routes";

const router = new VueRouter({
  mode: "history",
  routes: routes,
  linkActiveClass: "active",
  linkExactActiveClass: "active"
});

const app = new Vue(Vue.util.extend({ router })).$mount("#app");
