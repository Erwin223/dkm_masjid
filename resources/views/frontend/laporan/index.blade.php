<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Masjid - DKM Al-Musabaqoh</title>
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
<body class="frontend-shell bg-[#faf9f6] text-stone-900 antialiased">
    @php
        $navItems = $navItems ?? [
            ['label' => 'Beranda', 'href' => route('frontend.home'), 'active' => request()->routeIs('frontend.home')],
            ['label' => 'Profil Masjid', 'href' => route('frontend.profil'), 'active' => request()->routeIs('frontend.profil')],
            ['label' => 'Kegiatan', 'href' => route('frontend.kegiatan'), 'active' => request()->routeIs('frontend.kegiatan')],
            ['label' => 'Berita', 'href' => route('frontend.berita'), 'active' => request()->routeIs('frontend.berita')],
            ['label' => 'Galeri', 'href' => route('frontend.galeri'), 'active' => request()->routeIs('frontend.galeri')],
        ];

        $daftarLaporan = collect($daftar_laporan ?? []);
        $totalPemasukan = $total_pemasukan ?? 0;
        $totalPengeluaran = $total_pengeluaran ?? 0;
        $saldoAkhir = $saldo_akhir ?? ($totalPemasukan - $totalPengeluaran);
        $periodeLabel = $periode_label ?? 'Periode berjalan';
        $filterPreset = $filter_preset ?? 'this_month';
        $filterDateFrom = $filter_date_from ?? now()->startOfMonth()->format('Y-m-d');
        $filterDateTo = $filter_date_to ?? now()->endOfMonth()->format('Y-m-d');
    @endphp

    <div class="min-h-screen flex flex-col">
        @include('frontend.partials.navbar', ['navItems' => $navItems])

        <main class="flex-1">
            <x-hero-banner
                title="Laporan Keuangan Masjid"
                :bg-image="asset('storage/icon/FOTO.jpeg')"
                class="border-b border-emerald-900/40"
            />

            <section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="mb-8 max-w-3xl" data-aos="fade-up">
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-amber-600">Transparansi Dana Umat</p>
                    <h2 class="mt-3 text-2xl font-black tracking-tight text-emerald-950 sm:text-3xl">
                        Ringkasan kas dan arsip laporan yang mudah dibaca
                    </h2>
                    <p class="mt-4 text-base leading-8 text-stone-600 sm:text-lg">
                        Halaman ini menampilkan ringkasan dana masuk, dana keluar, serta saldo akhir. Dokumen laporan berkala dapat diunduh langsung oleh jamaah.
                    </p>
                </div>

                <section class="mb-10 rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" data-aos="fade-up" data-aos-delay="40">
                    <div class="mb-4">
                        <h3 class="text-lg font-black tracking-tight text-emerald-950">Filter Periode</h3>
                        <p class="mt-1 text-sm leading-7 text-stone-600">Pilih periode laporan untuk menyesuaikan ringkasan dan arsip dokumen.</p>
                    </div>

                    <form method="GET" action="{{ route('frontend.laporan') }}" class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">
                        <div class="lg:col-span-3">
                            <label for="preset" class="mb-2 block text-sm font-bold text-stone-700">Preset Periode</label>
                            <select name="preset" id="preset" class="w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-base text-stone-800 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                <option value="today" {{ $filterPreset === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="this_month" {{ $filterPreset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="this_year" {{ $filterPreset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                                <option value="last_30_days" {{ $filterPreset === 'last_30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                                <option value="custom" {{ $filterPreset === 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>

                        <div class="lg:col-span-3">
                            <label for="date_from" class="mb-2 block text-sm font-bold text-stone-700">Tanggal Awal</label>
                            <input type="date" name="date_from" id="date_from" value="{{ $filterDateFrom }}" class="w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-base text-stone-800 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div class="lg:col-span-3">
                            <label for="date_to" class="mb-2 block text-sm font-bold text-stone-700">Tanggal Akhir</label>
                            <input type="date" name="date_to" id="date_to" value="{{ $filterDateTo }}" class="w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-base text-stone-800 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div class="lg:col-span-3 flex gap-3">
                            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-2xl bg-emerald-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-800">
                                Tampilkan
                            </button>
                            <a href="{{ route('frontend.laporan') }}" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-stone-300 bg-white px-5 py-3 text-sm font-bold text-stone-700 transition hover:bg-stone-50">
                                Reset
                            </a>
                        </div>
                    </form>
                </section>

                <section class="grid grid-cols-1 gap-6 lg:grid-cols-3" aria-label="Ringkasan kas bulanan">
                    <article class="rounded-3xl border border-emerald-100 bg-white p-7 shadow-sm" data-aos="fade-up" data-aos-delay="0">
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-emerald-700">Pemasukan</p>
                        <div class="mt-4 text-3xl font-black tracking-tight text-emerald-700 sm:text-4xl">
                            Rp {{ number_format((float) $totalPemasukan, 0, ',', '.') }}
                        </div>
                        <p class="mt-3 text-base leading-7 text-stone-600">
                            Total pemasukan yang tercatat pada {{ $periodeLabel }}.
                        </p>
                    </article>

                    <article class="rounded-3xl border border-orange-100 bg-white p-7 shadow-sm" data-aos="fade-up" data-aos-delay="80">
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-orange-700">Pengeluaran</p>
                        <div class="mt-4 text-3xl font-black tracking-tight text-orange-700 sm:text-4xl">
                            Rp {{ number_format((float) $totalPengeluaran, 0, ',', '.') }}
                        </div>
                        <p class="mt-3 text-base leading-7 text-stone-600">
                            Total pengeluaran yang tercatat pada {{ $periodeLabel }}.
                        </p>
                    </article>

                    <article class="rounded-3xl bg-emerald-950 p-7 text-white shadow-lg" data-aos="fade-up" data-aos-delay="160">
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-amber-300">Saldo Akhir</p>
                        <div class="mt-4 text-3xl font-black tracking-tight text-amber-300 sm:text-4xl">
                            Rp {{ number_format((float) $saldoAkhir, 0, ',', '.') }}
                        </div>
                        <p class="mt-3 text-base leading-7 text-emerald-50/85">
                            Sisa saldo masjid setelah pemasukan dan pengeluaran pada periode ini.
                        </p>
                    </article>
                </section>

                <section class="mt-14" data-aos="fade-up" data-aos-delay="120">
                    <div class="mb-6">
                        <h3 class="text-xl font-black tracking-tight text-emerald-950 sm:text-2xl">Arsip Laporan</h3>
                        <p class="mt-2 text-base leading-7 text-stone-600">
                            Menampilkan seluruh dokumen laporan yang telah dipublikasikan. Filter periode di atas hanya memengaruhi ringkasan kas.
                        </p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-stone-200">
                                <thead class="bg-stone-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-[0.18em] text-stone-600">Periode Laporan</th>
                                        <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-[0.18em] text-stone-600">Keterangan Singkat</th>
                                        <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-[0.18em] text-stone-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @forelse($daftarLaporan as $laporan)
                                        @php
                                            $fileUrl = $laporan->file_path
                                                ? asset('storage/' . ltrim($laporan->file_path, '/'))
                                                : '#';
                                        @endphp
                                        <tr class="hover:bg-emerald-50/40 transition-colors">
                                            <td class="px-6 py-5">
                                                <div class="text-base font-bold text-stone-900">
                                                    {{ $laporan->periode ?? $laporan->nama_periode ?? 'Periode belum ditentukan' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <p class="text-base leading-7 text-stone-600">
                                                    {{ $laporan->keterangan ?? $laporan->deskripsi ?? 'Dokumen laporan keuangan publik.' }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-5">
                                                @if($laporan->file_path)
                                                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-full bg-emerald-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-800">
                                                        Unduh PDF
                                                    </a>
                                                @else
                                                    <span class="inline-flex rounded-full bg-stone-100 px-5 py-3 text-sm font-semibold text-stone-500">
                                                        File tidak tersedia
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-14 text-center">
                                                <p class="text-lg font-bold text-stone-700">
                                                    Belum ada dokumen laporan keuangan yang dipublikasikan.
                                                </p>
                                                <p class="mt-2 text-base text-stone-500">
                                                    Dokumen akan muncul di halaman ini setelah admin mengunggah file laporan PDF.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </section>
        </main>

        @include('frontend.partials.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.AOS) {
                AOS.init({
                    duration: 800,
                    once: true,
                    easing: 'ease-out-cubic'
                });
            }
        });
    </script>
</body>
</html>
