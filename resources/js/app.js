import './bootstrap';

import { createApp } from 'vue';
import PaymentComponent from './components/PaymentComponent.vue';

const app = createApp({});
app.component('payment-component', PaymentComponent);
app.mount('#app');
