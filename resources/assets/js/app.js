/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import * as uiv from 'uiv';
import moment from 'moment';

window.Vue = require('vue');
Vue.use(uiv);

Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('MMM/DD/YYYY, h:mm:ss a');
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('prescription-component', require('./components/PrescriptionComponent'));
Vue.component('prescription-template-component', require('./components/PrescriptionTemplateComponent'));
Vue.component('prescription-template-edit-component', require('./components/PrescriptionTemplateEditComponent'));
Vue.component('patient-reefer', require('./components/PatientReeferComponent'));

const app = new Vue({
    el: '#app'
});
