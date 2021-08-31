/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 import 'bootstrap';
 import '../css/style.css';
 import '../sass/modal.scss';
 import '../css/fontawesome.min.css';
 import '../css/all.css';

 import {createApp} from 'vue';
 import { createRouter, createWebHistory } from 'vue-router'; 
import App from "./App.vue";

const routes = [   
    { path: '/login', name: 'login', component: function() {        
        return import('./components/LoginComponent.vue');
      },  
    },
    { path: '/trips', name: 'trips', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/TripsComponent.vue');
      },  
    },
    { path: '/trips/:id', name: 'trip', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/TripComponent.vue');
      },  
    },
    { path: '/trips/edit/:id', name: 'tripedit', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/TripEditComponent.vue');
      },  
    },
    { path: '/children/:id', name: 'child', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/ChildComponent.vue');
      },  
    },
    { path: '/payments', name: 'payments', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/PaymentsComponent.vue');
      },  
    },
    { path: '/payments/:id', name: 'payment', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/PaymentComponent.vue');
      },  
    }, 
    { path: '/payments/edit/:id', name: 'paymentedit', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/PaymentEditComponent.vue');
      },  
    },
    { path: '/profile', name: 'profile', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/ProfileComponent.vue');
      },  
    },  
    { path: '/profile/edit/:id', name: 'profileedit', component: function() {
        if (localStorage.getItem("token") == null) {          
          document.location = <any>"/";
        }
        return import('./components/ProfileEditComponent.vue');
      },  
    },  
    { path: '/**', redirect: { name: 'login' }},
    { path: '/', redirect: { name: 'login' }}
]

const router = createRouter({    
    history: createWebHistory(),
    routes
}) 

const app = createApp(App);
app.use(router);
app.mount('#app');
