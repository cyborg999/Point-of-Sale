import Vue from 'vue'
import App from './App.vue'
import router from './router.js'

Vue.config.productionTip = false

window.url = "http://localhost/inventory/api/model.php"
window.barcodeAPI = "http://localhost/inventory/api/barcode.php"
window.upload = "http://localhost/inventory/api/uploads/"
window.iframeb = "http://localhost/inventory/api/barcode.html"
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

/**
 * todos
 * timekeeping every login
 * low stock monitoring
 * sales monitoring
 * broken images
 * sidebar routing active class
 * login preloader, its slow
 */