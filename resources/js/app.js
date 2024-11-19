import './bootstrap'; // Bootstrap import, as needed
import { createApp } from 'vue';
import axios from 'axios';

// Register your Vue component
import LeaveManagement from './components/LeaveManagement.vue';

const app = createApp({});

app.component('leave-management', LeaveManagement);
app.mount('#app');
