import './bootstrap'; // Bootstrap import, as needed
import { createApp } from 'vue'; // Import Vue 3
import LeaveView from './components/LeaveView.vue'; // Correct import path for LeaveView

// Create and mount the Vue app
createApp({
    components: {
        LeaveView
    }
}).mount('#app');  // Mount the app to the element with id "app"
