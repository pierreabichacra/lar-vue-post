import Vue from 'vue'
import App from './App.vue'
import router from './router'
import Antd from 'ant-design-vue';
import VueSession from 'vue-session'
import axios from 'axios'
import VueAxios from 'vue-axios'
import vuetify from './plugins/vuetify'

import 'ant-design-vue/dist/antd.css'; // or 'ant-design-vue/dist/antd.less'


Vue.use(VueAxios, axios)
Vue.use(Antd);
Vue.use(VueSession)


Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')