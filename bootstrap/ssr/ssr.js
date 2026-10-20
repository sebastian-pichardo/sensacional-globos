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
      /* @__PURE__ */ Object.assign({ "./Pages/Auth/ConfirmPassword.vue": () => import("./assets/ConfirmPassword-C8WGSxWb.js"), "./Pages/Auth/ForgotPassword.vue": () => import("./assets/ForgotPassword-BWGtktDM.js"), "./Pages/Auth/Login.vue": () => import("./assets/Login-DOX2pQ3J.js"), "./Pages/Auth/Register.vue": () => import("./assets/Register-HDrpQGNf.js"), "./Pages/Auth/ResetPassword.vue": () => import("./assets/ResetPassword-zZOp2EEj.js"), "./Pages/Auth/VerifyEmail.vue": () => import("./assets/VerifyEmail-CfdwaHEd.js"), "./Pages/AvisoPrivacidad.vue": () => import("./assets/AvisoPrivacidad-CzVRpHlS.js"), "./Pages/ComingSoon.vue": () => import("./assets/ComingSoon-DPKv10sf.js"), "./Pages/Dashboard.vue": () => import("./assets/Dashboard-jdks2Oa0.js"), "./Pages/EncuentraDistribuidor.vue": () => import("./assets/EncuentraDistribuidor-BKiQEfjV.js"), "./Pages/HazloTuMismo.vue": () => import("./assets/HazloTuMismo-Bae4feNA.js"), "./Pages/Home.vue": () => import("./assets/Home-CLSO0LLZ.js"), "./Pages/Inspirate.vue": () => import("./assets/Inspirate-Cssv3Z4z.js"), "./Pages/Nosotros.vue": () => import("./assets/Nosotros-hNMf5IzR.js"), "./Pages/Productos.vue": () => import("./assets/Productos-D-GRvA7p.js"), "./Pages/Profile/Edit.vue": () => import("./assets/Edit-UV5mgC4r.js"), "./Pages/Profile/Partials/DeleteUserForm.vue": () => import("./assets/DeleteUserForm-Cfure9xx.js"), "./Pages/Profile/Partials/UpdatePasswordForm.vue": () => import("./assets/UpdatePasswordForm-BLUyY0MX.js"), "./Pages/Profile/Partials/UpdateProfileInformationForm.vue": () => import("./assets/UpdateProfileInformationForm-CJ9XAHY3.js"), "./Pages/Welcome.vue": () => import("./assets/Welcome-B_OFjUa9.js") })
    ),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) }).use(plugin).use(ZiggyVue, {
        ...page.props.ziggy,
        location: new URL(page.props.ziggy.location)
      });
    }
  })
);
