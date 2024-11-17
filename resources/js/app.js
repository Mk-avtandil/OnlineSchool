    import "./bootstrap";
    import 'bootstrap/dist/css/bootstrap.min.css';
    import 'bootstrap';

    import { createApp } from "vue";
    import router from "./router/index";
    import App from "./App.vue";
    import Navbar from './components/Navbar.vue';
    import store from "./store/index.js";

    const app = createApp(App);

    app.component('navbar', Navbar);

    app.use(router)
        .use(store)
        .mount("#app");
