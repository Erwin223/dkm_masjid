<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Donasi & Zakat - DKM Al-Musabaqoh</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('frontend._styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body class="frontend-shell">
    <div class="frontend-page min-h-screen flex flex-col">
        @include('frontend.partials.navbar')

        <main class="flex-1">
            <x-hero-banner
                badge="Layanan Umat"
                title="Layanan Donasi & Zakat"
                accent="Masjid Agung"
                subtitle="Salurkan infak, sedekah, dan zakat Anda dengan mudah dan aman untuk kemakmuran masjid dan kesejahteraan umat."
                :bg-image="asset('storage/icon/FOTO.jpeg')"
                icon="bi-heart-fill"
                badge-icon="bi-heart-fill"
                cta-label="Mulai Berdonasi"
                cta-href="#qris-donasi"
            />

            <!-- ZAKAT CALCULATOR SECTION -->
            <section id="kalkulator-zakat" class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-white" data-aos="fade-up">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Kalkulator Cerdas</p>
                        <h2 class="mt-4 text-3xl sm:text-4xl font-black text-emerald-900">
                            Hitung Zakat Anda
                        </h2>
                        <p class="mt-4 text-lg text-stone-600 max-w-2xl mx-auto leading-relaxed">
                            Gunakan alat bantu di bawah ini untuk menghitung kewajiban zakat penghasilan atau zakat harta (maal) Anda secara cepat dan akurat.
                        </p>
                    </div>

                    <div x-data="zakatCalculator()" class="bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden">
                        <!-- Tabs -->
                        <div class="flex flex-col md:flex-row border-b border-emerald-100">
                            <button @click="tab = 'penghasilan'; reset()" :class="{'bg-emerald-50 text-emerald-700 border-l-4 md:border-l-0 md:border-b-4 border-emerald-600 font-black': tab === 'penghasilan', 'text-stone-500 font-semibold hover:bg-stone-50': tab !== 'penghasilan'}" class="flex-1 py-5 px-4 text-center text-lg transition-all duration-300">
                                <i class="bi bi-wallet2 mr-2"></i> Zakat Penghasilan
                            </button>
                            <button @click="tab = 'maal'; reset()" :class="{'bg-emerald-50 text-emerald-700 border-l-4 md:border-l-0 md:border-b-4 border-emerald-600 font-black': tab === 'maal', 'text-stone-500 font-semibold hover:bg-stone-50': tab !== 'maal'}" class="flex-1 py-5 px-4 text-center text-lg transition-all duration-300 border-t md:border-t-0 md:border-l border-emerald-100">
                                <i class="bi bi-safe mr-2"></i> Zakat Maal (Harta)
                            </button>
                        </div>

                        <!-- Content Zakat Penghasilan -->
                        <div x-show="tab === 'penghasilan'" class="p-6 md:p-10" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 mb-6 flex items-start gap-3">
                                    <i class="bi bi-info-circle-fill text-amber-500 mt-0.5"></i>
                                    <p class="text-sm text-amber-800 leading-relaxed">
                                        Zakat penghasilan ditunaikan setiap bulan saat menerima gaji atau pendapatan jika jumlahnya sudah mencapai nishab (setara nilai 85 gram emas pertahun). Tarif zakat adalah <strong>2,5%</strong>.
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-lg font-bold text-emerald-900 mb-2">Penghasilan / Gaji per Bulan</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-stone-500 font-bold text-xl">Rp</span>
                                        </div>
                                        <input type="text" x-model="formattedPenghasilan" @input="formatInput('penghasilan', $event)" class="w-full pl-12 pr-4 py-4 text-xl md:text-2xl font-bold border-2 border-stone-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition" placeholder="0">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-lg font-bold text-emerald-900 mb-2">Pendapatan Lain per Bulan (Opsional)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-stone-500 font-bold text-xl">Rp</span>
                                        </div>
                                        <input type="text" x-model="formattedLainnya" @input="formatInput('lainnya', $event)" class="w-full pl-12 pr-4 py-4 text-xl md:text-2xl font-bold border-2 border-stone-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Zakat Maal -->
                        <div x-show="tab === 'maal'" class="p-6 md:p-10" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 mb-6 flex items-start gap-3">
                                    <i class="bi bi-info-circle-fill text-amber-500 mt-0.5"></i>
                                    <p class="text-sm text-amber-800 leading-relaxed">
                                        Zakat Maal (harta) ditunaikan atas harta simpanan yang telah mencapai nishab (setara nilai 85 gram emas) dan telah dimiliki selama 1 tahun (haul). Tarif zakat adalah <strong>2,5%</strong>.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-lg font-bold text-emerald-900 mb-2">Nilai Harta Simpanan (Tabungan, Emas, dll)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-stone-500 font-bold text-xl">Rp</span>
                                        </div>
                                        <input type="text" x-model="formattedHarta" @input="formatInput('harta', $event)" class="w-full pl-12 pr-4 py-4 text-xl md:text-2xl font-bold border-2 border-stone-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Kalkulasi -->
                        <div class="bg-emerald-900 p-6 md:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6">
                            <div>
                                <p class="text-emerald-200 font-semibold mb-1 text-lg">Jumlah Zakat yang Harus Dibayar</p>
                                <div class="text-3xl md:text-5xl font-black text-amber-400" x-text="calculateZakat()">Rp 0</div>
                            </div>
                            <div class="w-full md:w-auto mt-4 md:mt-0">
                                <a href="#qris-donasi" class="w-full md:w-auto inline-block text-center px-8 py-4 bg-amber-500 hover:bg-amber-400 text-emerald-950 font-black text-lg rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    Tunaikan Zakat <i class="bi bi-arrow-right-circle ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- QRIS & TRANSFER SECTION -->
            <section id="qris-donasi" class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-emerald-50" data-aos="fade-up">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-16">
                        <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Salurkan Kebaikan</p>
                        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900">
                            Transfer Donasi & Zakat
                        </h2>
                        
                    </div>

                    <div class="max-w-2xl mx-auto flex flex-col items-center">
                        <!-- QRIS Area -->
                        <div class="w-full bg-white rounded-3xl p-8 sm:p-10 shadow-xl border-t-8 border-emerald-600 flex flex-col items-center text-center" data-aos="fade-up">
                            <h3 class="text-2xl font-black text-emerald-900 mb-2">Scan QRIS</h3>
                            <p class="text-stone-500 mb-8">Scan menggunakan aplikasi M-Banking atau E-Wallet Anda (Gopay, OVO, Dana, LinkAja, dll).</p>
                            
                            <div class="bg-emerald-50 p-6 rounded-2xl border-2 border-emerald-100 shadow-inner w-full max-w-sm relative">
                                <!-- Corner Decorations -->
                                <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-emerald-600 rounded-tl-lg"></div>
                                <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-emerald-600 rounded-tr-lg"></div>
                                <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-emerald-600 rounded-bl-lg"></div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-emerald-600 rounded-br-lg"></div>
                                
                                <!-- QRIS Image -->
                                <img src="{{ asset('storage/icon/QRIS.jpeg') }}" alt="QRIS Masjid Agung Al-Musabaqoh" class="w-full object-contain mx-auto rounded-lg shadow-md bg-white p-2" onerror="this.src='https://placehold.co/400x400/10b981/ffffff?text=QRIS+Placeholder\n(Ganti+dengan+QR+asli)'">
                            </div>
                            
                            <div class="mt-8 bg-emerald-100/50 text-emerald-800 py-3 px-6 rounded-full font-bold inline-flex items-center gap-2">
                                <i class="bi bi-shield-check text-xl"></i> Terverifikasi atas nama DKM Al-Musabaqoh
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('frontend.partials.footer')
    </div>

    <!-- Alpine.js logic for Zakat Calculator -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('zakatCalculator', () => ({
                tab: 'penghasilan',
                penghasilan: 0,
                lainnya: 0,
                harta: 0,
                formattedPenghasilan: '',
                formattedLainnya: '',
                formattedHarta: '',

                reset() {
                    this.penghasilan = 0;
                    this.lainnya = 0;
                    this.harta = 0;
                    this.formattedPenghasilan = '';
                    this.formattedLainnya = '';
                    this.formattedHarta = '';
                },

                formatInput(field, event) {
                    let value = event.target.value.replace(/[^0-9]/g, '');
                    if (value === '') {
                        this[field] = 0;
                        if(field === 'penghasilan') this.formattedPenghasilan = '';
                        if(field === 'lainnya') this.formattedLainnya = '';
                        if(field === 'harta') this.formattedHarta = '';
                        return;
                    }

                    this[field] = parseInt(value, 10);
                    
                    let formatted = new Intl.NumberFormat('id-ID').format(this[field]);
                    
                    if(field === 'penghasilan') this.formattedPenghasilan = formatted;
                    if(field === 'lainnya') this.formattedLainnya = formatted;
                    if(field === 'harta') this.formattedHarta = formatted;
                },

                calculateZakat() {
                    let total = 0;
                    if (this.tab === 'penghasilan') {
                        total = (this.penghasilan + this.lainnya) * 0.025;
                    } else if (this.tab === 'maal') {
                        total = this.harta * 0.025;
                    }

                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.floor(total));
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', function () {
            if (window.AOS) {
                AOS.init({
                    duration: 800,
                    once: true,
                    easing: 'ease-out-cubic',
                    offset: 100
                });
            }
        });
    </script>
</body>

</html>
