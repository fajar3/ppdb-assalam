<script setup>
import { Head, Link } from "@inertiajs/vue3";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";
const backgroundImage = '/images/background.jpg';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const download = async (name) => {
    try {
        const response = await fetch(`/assets/img/${name}`, {
            method: "GET",
        });

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", name);
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.log(error);
    }
};

const primacy = [
    {
        title: "Sekolah Nyaman",
        description: "Sekolah yang nyaman dan asri",
    },
    {
        title: "Fasilitas Lengkap",
        description: "Fasilitas yang lengkap dan modern",
    },
    {
        title: "Kurikulum Merdeka",
        description: "Mendukung kemandirian Siswa",
    },
    {
        title: "Tenaga Pengajar",
        description: "Tenaga pengajar yang mumpuni",
    },
    {
        title: "Lokasi Strategis",
        description: "Lokasi kampus yang strategis berada di pusat kota",
    },
    {
        title: "Kurikulum Terkini",
        description:
            "Kurikulum yang terkini dan relevan dengan kebutuhan industri",
    },
    {
        title: "Kerjasama Industri",
        description: "Kerjasama dengan industri yang luas",
    },
    {
        title: "Beasiswa",
        description: "Beasiswa yang dapat diakses oleh Siswa",
    },
    {
        title: "Kegiatan Siswa",
        description: "Kegiatan Siswa yang beragam",
    },
    {
        title: "KeSiswaan",
        description: "KeSiswaan yang aktif dan berprestasi",
    },
];

const cooperate = [
    ["https://unp.ac.id/", "https://htp.ac.id/asset/kerjasama/UNP.png"],
    ["https://umsu.ac.id/", "https://htp.ac.id/asset/kerjasama/UMSU.png"],
    ["https://uisi.ac.id/", "https://htp.ac.id/asset/kerjasama/UISI.png"],
    [
        "https://lincoln.edu.my/",
        "https://htp.ac.id/asset/kerjasama/LINCOLN.png",
    ],
    [
        "https://dinkes.riau.go.id/",
        "https://htp.ac.id/asset/kerjasama/Bakti-Husada.png",
    ],
    ["https://upiyptk.ac.id/", "https://htp.ac.id/asset/kerjasama/upi.png"],
];

const setting_carousel = {
    autoplay: 3000,
    settings: {
        itemsToShow: 1,
        snapAlign: "center",
        loop: true,
    },
    breakpoints: {
        700: {
            itemsToShow: 3.5,
            snapAlign: "center",
        },
        1024: {
            itemsToShow: 5,
            snapAlign: "start",
        },
    },
};
</script>
<template>
    <Head>
        <title>
            Penerimaan Siswa Baru
            {{ $page.props.web_settings.institution_name }}
        </title>
        <meta
            head-key="description"
            name="description"
            content="Penerimaan Siswa Baru {{ $page.props.web_settings.institution_name }}"
        />
        <link rel="icon" type="image/x-icon" href="/images/htp.png" />
    </Head>
    <HomeLayout>
        <section
            class="min-h-screen p-6 md:p-10 lg:p-12 xl:p-16 flex items-center" :style="{
            backgroundImage: `linear-gradient(rgba(255, 255, 255, 10), rgba(118, 189, 130, 0.8)), url('${backgroundImage}')`,
            backgroundSize: 'cover',
            backgroundRepeat: 'no-repeat',
            backgroundPosition: 'center',
        }"
        >
            <div class="container px-6 lg:px-8 mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-3">
                    <div class="w-full text-gray-900 text-center md:text-left">
                        <h1 class="text-2xl md:text-5xl font-bold pb-3">
                            Penerimaan Siswa Baru
                        </h1>
                        <div class="pb-3">
                            <h2 class="text-xl md:text-3xl font-semibold">
                                <span
                                    class="bg-gradient-to-r from-primary-700 to-primary bg-clip-text font-[800] text-transparent"
                                    >{{
                                        $page.props.web_settings
                                            .institution_name
                                    }}</span
                                >
                            </h2>
                            <!-- <span class="bg-gradient-to-r from-primary to-rose-500 bg-clip-text font-[800] text-transparent">Mitra TopupKuy</span> -->
                            <p class="leading-relaxed">
                                {{
                                    $page.props.web_settings
                                        .institution_synopsis
                                }}
                            </p>
                            <div
                                class="flex gap-3 pt-4 items-center justify-center md:justify-start"
                            >
                                <Link
                                    :href="route('register')"
                                    class="inline-flex items-center py-2.5 px-5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:text-gray-900 focus:text-gray-900 active:text-gray-900 hover:bg-gray-100 hover:ring-2 hover:ring-gray-500 focus:bg-gray-100 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    ><i
                                        class="fa-solid fa-user-graduate pr-2"
                                    />
                                    Daftar sekarang
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="w-full hidden lg:block ml-20">
                        <img
                            class="mx-auto"
                            src="/images/pmbcover.png"
                            alt="Cover PP Assalam"
                        />
                    </div>
                </div>
            </div>
        </section>
        <section class="py-6 md:p-16 lg:p-12 xl:p-16 bg-[#76bd8256]">
            <div
                class="container mx-auto"
                data-aos="fade-up"
                data-aos-duration="2000"
            >
                <h2
                    class="text-2xl md:text-3xl text-gray-800 text-center font-bold pb-5 mb-10 capitalize"
                >
                    <span class="relative inline-block">
                        <span
                        ></span>
                        <span class="relative"> Keunggulan </span>
                    </span>
                    {{ $page.props.web_settings.institution_short_name }}
                </h2>

                <div class="owl-carousel owl-theme">
                    <div
                        v-for="(x, index) in primacy"
                        :key="index"
                        class="p-5 bg-white rounded-xl shadow-lg h-32 flex flex-col items-center justify-center"
                    >
                        <header class="font-bold text-lg text-center">
                            {{ x.title }}
                        </header>
                        <p class="text-center font-semibold">
                            {{ x.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div
                class="container mx-auto p-6"
                data-aos="fade-up"
                data-aos-duration="2000"
            >
                <h2
                    class="text-2xl md:text-3xl text-black text-center font-bold pb-5 mb-10 capitalize"
                >
                    Sekilas Tentang
                    <span class="relative inline-block">
                        <span
                        ></span>
                        <span class="relative">
                            {{
                                $page.props.web_settings.institution_short_name
                            }}</span
                        >
                    </span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Visi dan Misi
                        </h3>
                        <p
                            class="text-justify text-sm md:text-base font-normal indent-8 text-pretty"
                        >
                            {{
                                $page.props.web_settings
                                    .institution_vision_mission
                            }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Sejarah
                        </h3>
                        <p
                            class="text-justify text-sm md:text-base font-normal indent-8 text-pretty"
                        >
                            {{ $page.props.web_settings.institution_history }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section
            class="p-6 md:p-16 lg:p-12 xl:p-16 bg-[#76bd8256] flex justify-center"
            data-aos="fade-up"
            data-aos-duration="2000"
        >
            <div class="container mx-auto">
                <h2
                    class="text-2xl md:text-3xl text-black-600 text-center font-bold pb-5 mb-10 capitalize"
                >
                    Panduan Singkat Pendaftaran
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div
                        class="flex flex-col items-center bg-white rounded-lg p-5 shadow-md"
                    >
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Langkah 1
                        </h3>
                        <p
                            class="text-sm md:text-base font-normal text-pretty text-center"
                        >
                            Login atau daftar akun terlebih dahulu untuk memulai
                            pendaftaran PMB
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-center bg-white rounded-lg p-5 shadow-md"
                    >
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Langkah 2
                        </h3>
                        <p
                            class="text-sm md:text-base font-normal text-pretty text-center"
                        >
                            Pilih Jurusan yang diinginkan dan lengkapi dan
                            lakukan pembayaran, kemudian isi formulir
                            pendaftaran
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-center bg-white rounded-lg p-5 shadow-md"
                    >
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Langkah 3
                        </h3>
                        <p
                            class="text-sm md:text-base font-normal text-pretty text-center"
                        >
                            Cek status pendaftaran dan lakukan verifikasi
                            dokumen
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-center bg-white rounded-lg p-5 shadow-md"
                    >
                        <h3 class="text-xl font-bold pb-3 text-center">
                            Langkah 4
                        </h3>
                        <p
                            class="text-sm md:text-base font-normal text-pretty text-center"
                        >
                            Lihat hasil seleksi dan lakukan pembayaran
                            pendaftaran
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section
            class="p-6 md:p-16 lg:p-12 xl:p-16"
            data-aos="fade-up"
            data-aos-duration="2000"
        >
            <div
                class="container mx-auto p-6"
                data-aos="fade-up"
                data-aos-duration="2000"
                style="background-color: white; border-radius: 20px;"
            >
                <h2
                    class="text-2xl md:text-3xl text-black text-center font-bold pb-5 mb-10 capitalize"
                >
                    Bekerja sama dengan
                </h2>
                <Carousel
                    :itemsToShow="3.95"
                    :wrapAround="true"
                    :transition="500"
                    :autoplay="setting_carousel.autoplay"
                    v-bind="setting_carousel.settings"
                    :breakpoints="setting_carousel.breakpoints"
                >
                    <Slide v-for="(x, index) in cooperate" :key="index">
                        <div class="flex p-5">
                            <a
                                :href="x[0]"
                                target="_blank"
                                class="flex items-center justify-center"
                            >
                                <img
                                    :src="x[1]"
                                    alt="Cooperate"
                                    class="w-20 h-20"
                                />
                            </a>
                        </div>
                    </Slide>

                    <template #addons>
                        <Navigation />
                        <Pagination />
                    </template>
                </Carousel>
            </div>
        </section>
        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div class="text-white" data-aos="fade-up" data-aos-duration="2000">
                <div
                    class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4"
                >
                    <div
                        class="flex flex-wrap gap-2 justify-between bg-background-primary container mx-auto rounded-lg p-6"
                    >
                        <div>
                            <h5
                                class="text-2xl font-bold text-left pb-3 leading-relaxed"
                            >
                                Punya pertanyaan seputar PMB
                                <span class="animate-pulse">?</span>
                            </h5>
                            <p class="text-left font-normal">
                                Jika anda memiliki sebuah pertanyaan atau
                                kendala silahkan hubungi kami atau dapat membaca
                                panduan pendaftaran
                            </p>
                        </div>
                        <div class="flex">
                            <div
                                class="flex flex-row gap-3 items-center sm:flex-row sm:gap-5 sm:justify-end sm:items-center"
                            >
                                <Link
                                    class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                                    href="https://wa.me/6281360000000"
                                >
                                    <span
                                        class="flex items-center justify-center"
                                    >
                                        <i
                                            class="fa-brands fa-whatsapp pr-2"
                                        ></i>
                                        Whatsapp
                                    </span>
                                </Link>

                                <Link
                                    href=""
                                    class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                                >
                                    <span
                                        class="flex items-center justify-center"
                                    >
                                        <i
                                            class="fa-solid fa-book-bookmark pr-2"
                                        />
                                        Panduan
                                    </span>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-wrap gap-2 justify-between bg-background-primary container mx-auto rounded-lg p-6"
                    >
                        <div>
                            <h5
                                class="text-2xl font-bold text-left pb-3 leading-relaxed"
                            >
                                Browsur dan Rincian Biaya
                            </h5>
                            <p class="text-left font-normal">
                                Kami menyediakan brosur dan rincian biaya
                                pendaftaran, silahkan unduh brosur dan rincian
                                biaya
                            </p>
                        </div>
                        <div class="flex">
                            <div
                                class="flex flex-row gap-3 items-center sm:flex-row sm:gap-5 sm:justify-end sm:items-center"
                            >
                                <button
                                    type="button"
                                    @click="download('brosur.jpg')"
                                    class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                                    href="https://wa.me/6281360000000"
                                >
                                    <span
                                        class="flex items-center justify-center"
                                    >
                                        <i class="fa-solid fa-image pr-2"></i>
                                        Brosur
                                    </span>
                                </button>

                                <button
                                    type="button"
                                    @click="download('rincian-biaya.jpeg')"
                                    class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                                >
                                    <span
                                        class="flex items-center justify-center"
                                    >
                                        <i
                                            class="fa-solid fa-money-bill pr-2"
                                        />
                                        Rincian
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </HomeLayout>
</template>
