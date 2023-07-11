@extends('layouts.app')

@section('content')
    <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
        <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
            <div class="carousel-item active">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown"><span>Diagnosa</span></h2>
                </div>
            </div>
        </div>
    </section><!-- End Hero -->
    {{-- Formulir Diagnosa Multistep yes or no button --}}
    <section id="diagnosa">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <header class="section-header">
                <h2>Diagnosa</h2>
            </header>
            <div class="row">
                @include('partials.diagnosa-' . $step)
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
