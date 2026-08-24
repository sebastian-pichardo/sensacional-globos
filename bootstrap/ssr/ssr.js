import { createInertiaApp } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { renderToString } from "@vue/server-renderer";
import { createSSRApp, h } from "vue";
import { ZiggyVue } from "ziggy-js";
async function resolvePageComponent(path, pages) {
  for (const p of Array.isArray(path) ? path : [path]) {
    const page = pages[p];
    if (typeof page === "undefined") {
      continue;
    }
    return typeof page === "function" ? page() : page;
  }
  throw new Error(`Page not found: ${path}`);
}
const appName = "Globos-Sensacional";
createServer(
  (page) => createInertiaApp({
    page,
    render: renderToString,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(
      `./Pages/${name}.vue`,
      /* @__PURE__ */ Object.assign({ "./Pages/Auth/ConfirmPassword.vue": () => import("./assets/ConfirmPassword-BnLcrIWq.js"), "./Pages/Auth/ForgotPassword.vue": () => import("./assets/ForgotPassword-CK8rdBCI.js"), "./Pages/Auth/Login.vue": () => import("./assets/Login-BY82GIG6.js"), "./Pages/Auth/Register.vue": () => import("./assets/Register-LMAzKS5m.js"), "./Pages/Auth/ResetPassword.vue": () => import("./assets/ResetPassword-BoxxH_yP.js"), "./Pages/Auth/VerifyEmail.vue": () => import("./assets/VerifyEmail-FP-AO_jQ.js"), "./Pages/AvisoPrivacidad.vue": () => import("./assets/AvisoPrivacidad-Cn4Z64zk.js"), "./Pages/ComingSoon.vue": () => import("./assets/ComingSoon-BIAPxamO.js"), "./Pages/Dashboard.vue": () => import("./assets/Dashboard-DzKliRIq.js"), "./Pages/EncuentraDistribuidor.vue": () => import("./assets/EncuentraDistribuidor-CAMoZwaq.js"), "./Pages/HazloTuMismo.vue": () => import("./assets/HazloTuMismo-ClqNR6I0.js"), "./Pages/Home.vue": () => import("./assets/Home-Btm2b234.js"), "./Pages/Inspirate.vue": () => import("./assets/Inspirate-DitVPgAS.js"), "./Pages/Nosotros.vue": () => import("./assets/Nosotros-DhabiI1I.js"), "./Pages/Productos.vue": () => import("./assets/Productos-D3u8e2Go.js"), "./Pages/Profile/Edit.vue": () => import("./assets/Edit-BWN7uith.js"), "./Pages/Profile/Partials/DeleteUserForm.vue": () => import("./assets/DeleteUserForm-CBpOevIw.js"), "./Pages/Profile/Partials/UpdatePasswordForm.vue": () => import("./assets/UpdatePasswordForm-CfPB1ECr.js"), "./Pages/Profile/Partials/UpdateProfileInformationForm.vue": () => import("./assets/UpdateProfileInformationForm-BSo1blrE.js"), "./Pages/Welcome.vue": () => import("./assets/Welcome-Cg79Qbzx.js") })
    ),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) }).use(plugin).use(ZiggyVue, {
        ...page.props.ziggy,
        location: new URL(page.props.ziggy.location)
      });
    }
  })
);
