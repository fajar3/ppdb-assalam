<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Loading from "@/Components/Loading.vue";

const loading = ref(true);
const remove = ref(false);

defineProps({
    canLogin: {
        type: Boolean,
    },
});

const scrollY = ref(0);

const handleHeader = () => {
    scrollY.value = window.scrollY || 0;
};

onMounted(() => {
    window.addEventListener("scroll", handleHeader);
    nextTick(() => {
        setTimeout(() => {
            loading.value = false;
        }, 3500);

        setTimeout(() => {
            remove.value = true;
        }, 4200);
    });
});

onBeforeUnmount(() => {
    window.removeEventListener("scroll", handleHeader);
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div > <div

    >
        <Loading :loading="loading" :remove="remove" />

            <nav
                class="fixed w-full z-20 top-0 start-0 bg-emerald-50/90 backdrop-blur-sm transition-all duration-500 border-b border-emerald-100 shadow-sm"
                :class="{
                    'h-20': scrollY >= 270,
                    'h-24': scrollY <= 270,
                }"
            >
                <div
                    class="mx-auto px-4 sm:px-6 lg:px-8 h-full flex justify-between"
                >
                    <div class="flex flex-row">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center gap-3">
                            <Link href="/">
                                <ApplicationLogo class="block h-9 w-auto" />
                            </Link>
                            <h1
                                class="text-lg md:text-2xl inline-flex items-center font-bold text-emerald-800 px-3 leading-relaxed"
                            >
                                {{ $page.props.web_settings.title_home }}
                            </h1>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="flex justify-center gap-2">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('login')"
                                class="inline-flex items-center text-emerald-800 hover:text-emerald-100 font-bold capitalize"
                            >
                                Masuk
                            </Link>
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('register')"
                                class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-emerald-500 rounded-lg tracking-widest hover:bg-emerald-100 focus:outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-500 transition duration-150 ease-in-out shadow-md"
                            >
                                daftar
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-emerald-600 rounded-lg tracking-widest hover:bg-emerald-500 focus:outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-500 transition duration-150 ease-in-out shadow-md"
                            >
                                Dashboard
                            </Link>
                        </div>
                    </div>

                    <!-- Hamburger Start -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center p-2 rounded-md text-emerald-800 hover:text-emerald-100 hover:bg-emerald-100 focus:outline-none focus:bg-emerald-100 transition duration-150 ease-in-out"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-emerald-50/90 backdrop-blur-sm border-b border-emerald-100 shadow-md"
                >
                    <div
                        v-if="$page.props.auth.user"
                        class="pt-2 pb-3 space-y-1 px-4"
                    >
                        <ResponsiveNavLink :href="route('dashboard')"
                            >Dashboard
                        </ResponsiveNavLink>
                    </div>
                    <div v-else class="pt-2 pb-3 space-y-1 px-4">
                        <ResponsiveNavLink :href="route('login')"
                            ><i class="fa-solid fa-user-graduate pr-2"></i>
                            Masuk
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')"
                            ><i class="fa-solid fa-right-to-bracket pr-2"></i>
                            Daftar
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            <main class="flex-grow w-full relative z-10 bg-emerald-50/80 backdrop-blur-sm">
                <slot />
            </main>

            <footer
                data-aos="fade-up"
                data-aos-duration="2000"
                class="py-10 px-6 md:px-16 lg:px-12 xl:px-16 bg-emerald-900"
            >
                <div class="mx-auto max-w-full">
                    <div class="grid grid-cols-1 md:grid-cols-8 gap-4 text-sm text-emerald-100">
                        <div
                            class="flex flex-col gap-3 col-span-1 md:col-span-3"
                        >
                            <div class="flex gap-2 items-center">
                                <ApplicationLogo class="block h-9 w-auto" />

                                <h3 class="font-bold text-lg text-emerald-100">
                                    {{ $page.props.web_settings.title_home }}
                                </h3>
                            </div>
                            <ul class="list-none list-outside">
                                <li>
                                    <i
                                        class="fa-solid fa-location-dot pr-2 text-emerald-100"
                                    ></i>
                                    {{
                                        $page.props.web_settings.contact_address
                                    }}
                                </li>
                                <li>
                                    <i class="fa-solid fa-envelope pr-2 text-emerald-100"></i>
                                    {{ $page.props.web_settings.contact_email }}
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone pr-2 text-emerald-100"></i>+ 0761
                                    33815
                                </li>
                                <li>
                                    <i class="fa-solid fa-print pr-2 text-emerald-100"></i>+ 0761
                                    33815
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <h3 class="font-bold text-lg pb-2 text-emerald-100">
                                Situs Akademik
                            </h3>
                            <ul class="list-disc list-inside capitalize">
                                <li>
                                    <a
                                        class="hover:text-emerald-100"
                                        target="_blank"
                                        href="https://siakadm.htp.ac.id/"
                                        >Sistem informasi Administrasi
                                        Akademik</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="hover:text-emerald-100"
                                        target="_blank"
                                        href="https://spmb.htp.ac.id/"
                                        >Sistem Pendaftaran Siswa Baru</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="hover:text-emerald-100"
                                        target="_blank"
                                        href="https://tracer.htp.ac.id/"
                                        >Tracer Study</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="hover:text-emerald-100"
                                        target="_blank"
                                        href="https://survei.htp.ac.id/"
                                        >Survey</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-1 md:col-span-3">
                            <h3 class="font-bold text-lg pb-2 text-emerald-100">
                                Lokasi Kampus
                            </h3>
                            <iframe
                                allowfullscreen
                                width="100%"
                                height="100%"
                                frameborder="0"
                                scrolling="no"
                                marginheight="0"
                                marginwidth="0"
                                :src="
                                    $page.props.web_settings.contact_maps_link
                                "
                            ></iframe>
                        </div>
                    </div>
                    <hr class="border-t-2 border-emerald-200 my-4 mt-10" />
                    <div
                        class="flex flex-col md:flex-row justify-between items-center gap-4 text-emerald-100 text-center md:text-left"
                    >
                        <p class="text-sm tracking-wide">
                            <span v-html="$page.props.web_settings.footer" />
                        </p>
                        <div class="flex gap-3">
                            <a
                                v-if="$page.props.web_settings.contact_facebook"
                                :href="
                                    $page.props.web_settings.contact_facebook
                                "
                                target="_blank"
                                class="text-emerald-100 hover:text-emerald-500"
                            >
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a
                                v-if="
                                    $page.props.web_settings.contact_instagram
                                "
                                :href="
                                    $page.props.web_settings.contact_instagram
                                "
                                target="_blank"
                                class="text-emerald-100 hover:text-emerald-500"
                            >
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a
                                v-if="$page.props.web_settings.contact_youtube"
                                :href="$page.props.web_settings.contact_youtube"
                                target="_blank"
                                class="text-emerald-100 hover:text-emerald-500"
                            >
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a
                                v-if="$page.props.web_settings.contact_twitter"
                                :href="$page.props.web_settings.contact_twitter"
                                target="_blank"
                                class="text-emerald-100 hover:text-emerald-500"
                            >
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
