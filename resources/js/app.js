import './bootstrap';

import { createApp } from 'vue'
import Index from './components/IndexComponent.vue'
 
const app = createApp({
    components : {
        Index,
    }
})
 
app.mount('#app')