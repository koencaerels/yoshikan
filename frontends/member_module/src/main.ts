import {createApp} from 'vue'
import {createPinia} from 'pinia'
import router from "@/router";

import App from './App.vue'

import PrimeVue from 'primevue/config';

// ---------------------------------------------------------------------------------- prime vue
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Divider from "primevue/divider";
import TabMenu from 'primevue/tabmenu';
import Menu from 'primevue/menu';
import Sidebar from 'primevue/sidebar';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import ConfirmPopup from "primevue/confirmpopup";
import RadioButton from 'primevue/radiobutton';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import OverlayPanel from 'primevue/overlaypanel';
import Badge from 'primevue/badge';
import Fieldset from 'primevue/fieldset';
import InputSwitch from 'primevue/inputswitch';
import Checkbox from 'primevue/checkbox';
import Toast from 'primevue/toast';
import ProgressSpinner from 'primevue/progressspinner';
import Skeleton from 'primevue/skeleton';
import ToggleButton from 'primevue/togglebutton';
import SelectButton from 'primevue/selectbutton';
import Tooltip from 'primevue/tooltip';
import ColorPicker from 'primevue/colorpicker';
import Dialog from 'primevue/dialog';
import Chips from 'primevue/chips';
import DataView from 'primevue/dataview';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Image from 'primevue/image';

// ----------------------------------------------------------------------------------- services
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";

// -------------------------------------------------------------------------------- stylesheets
import './assets/tailwind.css';
import './assets/application.css';
import 'primevue/resources/primevue.min.css';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primeicons/primeicons.css';

// ------------------------------------------------------------------- set default url for axios
import axios from "axios";

axios.defaults.baseURL = import.meta.env.VITE_API_URL as string;

// --------------------------------------------------------------------------------- application
const app = createApp(App)

// ---------------------------------------------------------------------------------- components
app.component("InputText", InputText);
app.component("Button", Button);
app.component("Divider", Divider);
app.component("TabMenu", TabMenu);
app.component("Menu", Menu);
app.component("Sidebar", Sidebar);
app.component("Splitter", Splitter);
app.component("SplitterPanel", SplitterPanel);
app.component("ConfirmPopup", ConfirmPopup);
app.component("RadioButton", RadioButton);
app.component("Dropdown", Dropdown);
app.component("Textarea", Textarea);
app.component("OverlayPanel", OverlayPanel);
app.component("Badge", Badge);
app.component("Fieldset", Fieldset);
app.component("InputSwitch", InputSwitch);
app.component("Checkbox", Checkbox);
app.component("Toast", Toast);
app.component("ProgressSpinner", ProgressSpinner);
app.component("Skeleton", Skeleton);
app.component("ToggleButton", ToggleButton);
app.component("SelectButton", SelectButton);
app.component("ColorPicker", ColorPicker);
app.component("Dialog", Dialog);
app.component("Chips", Chips);
app.component("DataView", DataView);
app.component("TabView", TabView);
app.component("TabPanel", TabPanel);
app.component("Image", Image);

app.directive('tooltip', Tooltip);

// ---------------------------------------------------------------------- vue progress bar
// @ts-ignore
import VueProgressBar from '@aacassandra/vue3-progressbar';

const options = {
    color: "#324bed",
    failedColor: "#ff0000",
    thickness: "2px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300,
    },
    autoRevert: true,
    location: "bottom",
    inverse: false,
};
app.use(VueProgressBar, options);

// -------------------------------------------------------------------- font awesome icons
import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

// -- icons
import {faMedal} from '@fortawesome/free-solid-svg-icons';

library.add(faMedal);
app.component('font-awesome-icon', FontAwesomeIcon);

// ---------------------------------------------------------------------------------------
app.use(router)
app.use(createPinia())
app.use(PrimeVue, {ripple: true});
app.use(ConfirmationService);
app.use(ToastService);

app.mount('#mm_module');
