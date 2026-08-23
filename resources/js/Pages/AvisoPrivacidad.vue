<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Aviso de Privacidad de Globos Sensacional. Conoce cómo tratamos tus datos personales conforme a la LFPDPPP.',
);
const canonical = computed(() => `${appUrl.value}/aviso-de-privacidad`);
</script>

<template>
    <PublicLayout>
        <Head title="Aviso de Privacidad">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Aviso de Privacidad | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
        </Head>

        <div class="pt-40 sm:pt-36">
            <section class="bg-white py-12 sm:py-16" aria-labelledby="aviso-titulo">
                <article class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                        Legal
                    </p>
                    <h1
                        id="aviso-titulo"
                        class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Aviso de Privacidad
                    </h1>

                    <div class="mt-8 space-y-8 text-base leading-relaxed text-gray-700">
                        <p>
                            <strong class="font-semibold text-gray-900">GLOBOS QUALATEX DE PIONEER</strong>
                            (en lo sucesivo, “El Responsable”), con domicilio en Av. Guadalajara # 101,
                            Acatlán de Juárez, Mexico, 45738 y portal de internet
                            <a
                                href="https://www.globossensacional.com"
                                class="font-medium text-brand-cyan underline-offset-2 hover:underline"
                                target="_blank"
                                rel="noopener noreferrer"
                            >www.globossensacional.com</a>,
                            es el responsable del uso y protección de sus datos personales, y al
                            respecto le informa lo siguiente:
                        </p>

                        <section aria-labelledby="fines-titulo">
                            <h2 id="fines-titulo" class="text-xl font-extrabold text-gray-900">
                                1. ¿Para qué fines utilizaremos sus datos personales?
                            </h2>
                            <p class="mt-3">
                                Los datos personales que recopilamos a través de nuestros formularios
                                de contacto, cotización o registro serán utilizados para las siguientes
                                finalidades principales y necesarias para el servicio que solicita:
                            </p>
                            <ul class="mt-4 list-disc space-y-2 pl-5">
                                <li>
                                    Atender, procesar y dar seguimiento a sus solicitudes de
                                    información, cotizaciones o atención al cliente.
                                </li>
                                <li>
                                    Contactarlo vía correo electrónico, teléfono o WhatsApp para
                                    brindarle asesoría sobre nuestros productos y servicios.
                                </li>
                                <li>
                                    Elaborar comprobantes, notas de venta o facturación en caso de
                                    concretar una contratación o compra.
                                </li>
                                <li>
                                    Hacerlo parte de programas o servicios en pro del desarrollo
                                    técnico de su habilidad con los globos, generar comunidad en torno
                                    al producto.
                                </li>
                            </ul>

                            <h3 class="mt-6 text-lg font-bold text-gray-900">
                                Finalidades secundarias (Opcional):
                            </h3>
                            <p class="mt-3">
                                De manera adicional, utilizaremos su información personal para las
                                siguientes finalidades que no son necesarias para el servicio
                                solicitado, pero que nos permiten brindar una mejor atención:
                            </p>
                            <ul class="mt-4 list-disc space-y-2 pl-5">
                                <li>
                                    Envío de promociones, boletines informativos (newsletters),
                                    catálogo de novedades y lanzamientos.
                                </li>
                                <li>
                                    Evaluaciones de calidad del servicio y encuestas de satisfacción.
                                </li>
                            </ul>
                            <p class="mt-4">
                                Si no desea que sus datos personales sean tratados para estas
                                finalidades secundarias, puede enviarnos un correo indicándolo a
                                <a
                                    href="mailto:info@pioneerballoon.com"
                                    class="font-medium text-brand-cyan underline-offset-2 hover:underline"
                                >info@pioneerballoon.com</a>.
                            </p>
                        </section>

                        <section aria-labelledby="datos-titulo">
                            <h2 id="datos-titulo" class="text-xl font-extrabold text-gray-900">
                                2. ¿Qué datos personales recopilamos?
                            </h2>
                            <p class="mt-3">
                                Para llevar a cabo las finalidades descritas en el presente aviso de
                                privacidad, utilizaremos los siguientes datos personales recolectados
                                a través de nuestros formularios web:
                            </p>
                            <ul class="mt-4 list-disc space-y-2 pl-5">
                                <li>
                                    <strong class="font-semibold text-gray-900">Datos de identificación:</strong>
                                    Nombre completo.
                                </li>
                                <li>
                                    <strong class="font-semibold text-gray-900">Datos de contacto:</strong>
                                    Correo electrónico, número de teléfono y/o WhatsApp.
                                </li>
                                <li>
                                    <strong class="font-semibold text-gray-900">Datos de ubicación:</strong>
                                    Ciudad o estado.
                                </li>
                                <li>
                                    <strong class="font-semibold text-gray-900">Datos de redes sociales:</strong>
                                    Usuario de redes sociales.
                                </li>
                                <li>
                                    <strong class="font-semibold text-gray-900">Datos sobre la solicitud:</strong>
                                    Detalles del tipo de producto/servicio de interés, fechas o
                                    ubicación del proyecto.
                                </li>
                            </ul>
                            <p class="mt-4">
                                <strong class="font-semibold text-gray-900">Aclaración:</strong>
                                No solicitamos ni tratamos datos personales sensibles (como datos
                                financieros, de salud, creencias o ideologías) a través de nuestros
                                formularios web de contacto general.
                            </p>
                        </section>

                        <section aria-labelledby="transferencia-titulo">
                            <h2 id="transferencia-titulo" class="text-xl font-extrabold text-gray-900">
                                3. Transferencia de datos personales
                            </h2>
                            <p class="mt-3">
                                Le informamos que sus datos personales no serán compartidos, vendidos,
                                ni transferidos a terceros dentro o fuera del país, salvo por las
                                excepciones previstas en el artículo 37 de la LFPDPPP o cuando sea
                                estrictamente necesario para cumplir con requerimientos legales de
                                autoridades competentes.
                            </p>
                        </section>

                        <section aria-labelledby="arco-titulo">
                            <h2 id="arco-titulo" class="text-xl font-extrabold text-gray-900">
                                4. ¿Cómo puede acceder, rectificar o cancelar sus datos personales, u
                                oponerse a su uso? (Derechos ARCO)
                            </h2>
                            <p class="mt-3">
                                Usted tiene derecho a conocer qué datos personales tenemos de usted,
                                para qué los utilizamos y las condiciones del uso que les damos
                                (Acceso). Asimismo, es su derecho solicitar la corrección de su
                                información personal en caso de que esté desactualizada, sea inexacta
                                o incompleta (Rectificación); que la eliminemos de nuestros registros
                                o bases de datos cuando considere que la misma no está siendo utilizada
                                adecuadamente (Cancelación); así como oponerse al uso de sus datos
                                personales para fines específicos (Oposición). Estos se conocen como
                                Derechos ARCO.
                            </p>
                            <p class="mt-4">
                                Para el ejercicio de cualquiera de los derechos ARCO, usted deberá
                                presentar la solicitud respectiva enviando un correo electrónico a:
                                <a
                                    href="mailto:info@pioneerballoon.com"
                                    class="font-medium text-brand-cyan underline-offset-2 hover:underline"
                                >info@pioneerballoon.com</a>
                            </p>
                            <p class="mt-4">La solicitud deberá contener:</p>
                            <ul class="mt-4 list-disc space-y-2 pl-5">
                                <li>
                                    Su nombre completo y medio de contacto (correo o teléfono) para
                                    comunicarle la respuesta.
                                </li>
                                <li>
                                    Copia de un documento oficial que acredite su identidad (INE o
                                    Pasaporte).
                                </li>
                                <li>
                                    La descripción clara de los datos respecto de los cuales busca
                                    ejercer alguno de los derechos ARCO.
                                </li>
                            </ul>
                        </section>

                        <section aria-labelledby="cookies-titulo">
                            <h2 id="cookies-titulo" class="text-xl font-extrabold text-gray-900">
                                5. Uso de Cookies y Tecnologías de Rastreo
                            </h2>
                            <p class="mt-3">
                                Le informamos que en nuestra página web utilizamos cookies o web
                                beacons para analizar el tráfico web, recordar sus preferencias de
                                navegación y mejorar su experiencia de usuario. Los datos recopilados
                                mediante estas tecnologías son anónimos. Puede desactivar o configurar
                                el uso de cookies directamente en las opciones de configuración de su
                                navegador de internet.
                            </p>
                        </section>

                        <section aria-labelledby="cambios-titulo">
                            <h2 id="cambios-titulo" class="text-xl font-extrabold text-gray-900">
                                6. Cambios al Aviso de Privacidad
                            </h2>
                            <p class="mt-3">
                                El presente aviso de privacidad puede sufrir modificaciones, cambios o
                                actualizaciones derivadas de nuevos requerimientos legales, de nuestras
                                propias necesidades por los productos o servicios que ofrecemos, o de
                                nuestras prácticas de privacidad.
                            </p>
                            <p class="mt-4">
                                Nos comprometemos a mantenerlo informado sobre los cambios que pueda
                                sufrir el presente aviso de privacidad a través de nuestra página de
                                internet
                                <a
                                    href="https://www.globossensacional.com"
                                    class="font-medium text-brand-cyan underline-offset-2 hover:underline"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >www.globossensacional.com</a>.
                            </p>
                        </section>

                        <p class="border-t border-gray-200 pt-6 text-sm text-gray-500">
                            Última actualización: 23 de Agosto de 2026
                        </p>
                    </div>
                </article>
            </section>
        </div>
    </PublicLayout>
</template>
