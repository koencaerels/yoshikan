import './styles/inschrijving.css';
import '@oruga-ui/oruga-next/dist/oruga-full.min.css';

import {createApp} from "vue";
import Oruga from '@oruga-ui/oruga-next';
import appInschrijving from './components/appInschrijving.vue';

const app = createApp(appInschrijving);
app.use(Oruga);
app.mount('#appInschrijving');
