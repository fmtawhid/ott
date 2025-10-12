import { createApp } from "vue";
import { createI18n } from "vue-i18n";
import { createPinia } from 'pinia';
import BootstrapVueNext from 'bootstrap-vue-next'
import "@vueform/multiselect/themes/default.css";
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
export const InitApp = (component) => {
  const pinia = createPinia();

  let app
  if(component != undefined) {
    app = createApp(component);
  } else {
    app = createApp();
  }
    /**
     *
     * !Usage : $t('{key_name}')
     */
    const i18n = createI18n({
        legacy: false,
        locale: "en",
        globalInjection: true,
        messages: {en: window.localMessagesUpdate} || {},
    });

    window.i18n = i18n

    app.use(pinia);
    app.use(i18n);
    app.use(BootstrapVueNext)

    return app;
};
