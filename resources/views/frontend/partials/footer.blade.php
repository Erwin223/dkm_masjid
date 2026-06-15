<footer class="bg-emerald-950 text-stone-200 pt-16 pb-8 border-t-4 border-amber-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-12 gap-10">
        <div class="md:col-span-4 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-white p-1.5 flex items-center justify-center border border-amber-500">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo DKM Subang" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="font-display text-lg font-black text-white tracking-wider uppercase">Al-Musabaqoh</span>
            </div>
            <p class="text-xs md:text-sm text-stone-300/80 leading-relaxed">
                Masjid Agung Al-Musabaqoh merupakan pusat peradaban Islam di Kota Subang. Sebagai wadah pembinaan umat, kami senantiasa berusaha memberikan kenyamanan beribadah dan pelayanan terbaik bagi para jamaah.
            </p>
        </div>

        <div class="md:col-span-2 space-y-3">
            <h4 class="font-display text-sm font-extrabold text-white uppercase tracking-wider">Tautan Cepat</h4>
            <ul class="space-y-2 text-xs md:text-sm font-semibold">
                <li><a href="{{ route('frontend.home') }}" class="hover:text-amber-400 transition-colors"><i class="bi bi-chevron-right text-[10px] text-amber-500"></i> Beranda</a></li>
                <li><a href="{{ route('frontend.profil') }}" class="hover:text-amber-400 transition-colors"><i class="bi bi-chevron-right text-[10px] text-amber-500"></i> Profil Masjid</a></li>
                <li><a href="{{ route('frontend.berita') }}" class="hover:text-amber-400 transition-colors"><i class="bi bi-chevron-right text-[10px] text-amber-500"></i> Berita Masjid</a></li>
                <li><a href="{{ route('frontend.galeri') }}" class="hover:text-amber-400 transition-colors"><i class="bi bi-chevron-right text-[10px] text-amber-500"></i> Galeri</a></li>
                <li><a href="{{ route('frontend.laporan') }}" class="hover:text-amber-400 transition-colors"><i class="bi bi-chevron-right text-[10px] text-amber-500"></i> Laporan</a></li>
            </ul>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h4 class="font-display text-sm font-extrabold text-white uppercase tracking-wider">Sekretariat & Kontak</h4>
            <ul class="space-y-2.5 text-xs md:text-sm text-stone-300/90 font-medium">
                <li class="flex items-start gap-2.5">
                    <i class="bi bi-geo-alt-fill text-amber-500 text-lg leading-none mt-0.5"></i>
                    <span>Jl. Raden Wiranata Kusumah (Alun-alun Subang), Karanganyar, Kec. Subang, Kabupaten Subang, Jawa Barat 41211</span>
                </li>
                <li class="flex items-center gap-2.5">
                    <i class="bi bi-whatsapp text-amber-500 text-lg"></i>
                    <span>+62 812-3456-7890 (DKM Center)</span>
                </li>
                <li class="flex items-center gap-2.5">
                    <i class="bi bi-envelope-fill text-amber-500 text-lg"></i>
                    <span>almusabaqoh.dkm@gmail.com </span>
                </li>
            </ul>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h4 class="font-display text-sm font-extrabold text-white uppercase tracking-wider">Lokasi Google Maps</h4>
            <div class="w-full h-28 rounded-xl overflow-hidden shadow-md border border-emerald-900/60 bg-emerald-950">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.7844086602324!2d107.76189917578768!3d-6.5488421639912065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693b708d7eeab9%3A0xe7a56112d8fe5a03!2sMasjid%20Agung%20Al-Musabaqoh!5e0!3m2!1sid!2sid!4v1717170000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-emerald-800 text-center text-xs text-stone-400 font-semibold flex flex-col sm:flex-row justify-between items-center gap-3">
        <p>&copy; 2026 DKM Masjid Agung Al-Musabaqoh Subang. Hak Cipta Dilindungi Undang-Undang.</p>
        <div class="flex items-center gap-4">
            <a href="{{ route('frontend.home') }}" class="hover:text-white transition">Kembali ke Atas <i class="bi bi-arrow-up-short text-base align-middle"></i></a>
        </div>
    </div>
</footer>
