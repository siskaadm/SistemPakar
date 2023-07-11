@extends('layouts.app')

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
        <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
            <div class="carousel-item active">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown"><span>Sistem Pakar</span></h2>
                    <p class="animate__animated fanimate__adeInUp">Diagnosa Kerusakan Sepeda Motor Honda Vario 125
                        Menggunakan Metode Forward Chaining</p>
                    <a href="{{ route('page.diagnosa') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Diagnosa
                        Sekarang</a>
                </div>
            </div>
        </div>

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
            </g>
        </svg>
    </section><!-- End Hero -->

    <section id="values" class="values">

        <div class="container aos-init aos-animate" data-aos="fade-up">

            <header class="section-header">
                <h2>Panduan</h2>
                <p>Cari Tahu Kerusakan dan Cara Perbaikan Sepeda Motor Anda</p>
            </header>

            <div class="row">

                <div class="col-lg-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="box">
                        <img src="/img/values-1.png" class="img-fluid" alt="">
                        <h3>Isi Data Diri</h3>
                        <p>Kunjungi halaman Diagnosa dan isi data diri anda</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                    <div class="box">
                        <img src="/img/values-3.png" class="img-fluid" alt="">
                        <h3>Jawab Pertanyaan</h3>
                        <p>Akan muncul pertanyaan terkait kerusakan atau gejala dan jawab sesuai kendala yang anda
                            alami</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="600">
                    <div class="box">
                        <img src="/img/values-2.png" class="img-fluid" alt="">
                        <h3>Hasil Diagnosa</h3>
                        <p>Setelah menjawab pertanyaan, akan muncul hasil diagnosa yang berisi kemungkinan kerusakan yang
                            terjadi pada sepeda motor anda beseerta solusi yang dapat anda lakukan</p>
                    </div>
                </div>

            </div>

        </div>

    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.2.0/swiper-bundle.css"
        integrity="sha512-Lc4aT4sbiVWDTSgqn3lf5kwKECm7rU45AReUS9WI2k4yRPSKtS+kJ9aV1jrxDUIyetNFRYZ3U2gR6WWbtWbIfA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"   />
@endsection

@section('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.2.0/swiper-bundle.min.js"
        integrity="sha512-KBCt3sdFOcFtYTgEfE3uJckVpvPr1w8HPugyPgHFE/4iJOwhwj6eSaF27bDJTHRX2jyAFOgV3Ve9vOD97rbjrg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
