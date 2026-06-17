@extends('layouts.frontend')

@section('title', 'Laporan Keuangan Masjid - DKM Al-Musabaqoh')

@section('content')
    @php
        $daftarLaporan = collect($daftar_laporan ?? []);
        $totalPemasukan = $total_pemasukan ?? 0;
        $totalPengeluaran = $total_pengeluaran ?? 0;
        $saldoAkhir = $saldo_akhir ?? ($totalPemasukan - $totalPengeluaran);
        $periodeLabel = $periode_label ?? 'Periode berjalan';
        $filterPreset = $filter_preset ?? 'this_month';
        $filterDateFrom = $filter_date_from ?? now()->startOfMonth()->format('Y-m-d');
        $filterDateTo = $filter_date_to ?? now()->endOfMonth()->format('Y-m-d');
    @endphp

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

        <!-- Section Grafik & Ringkasan -->
        <section class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Card Chart -->
            <div class="lg:col-span-2 rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" data-aos="fade-up" data-aos-delay="0">
                <h3 class="text-lg font-black tracking-tight text-emerald-950 mb-4">Grafik Pemasukan & Pengeluaran</h3>
                <div id="chart-laporan" class="w-full" style="min-height: 350px;"></div>
            </div>

            <!-- Card Ringkasan -->
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" data-aos="fade-up" data-aos-delay="80">
                <h3 class="text-lg font-black tracking-tight text-emerald-950 mb-6">Ringkasan Bulan Ini</h3>
                
                <div class="space-y-6">
                    <!-- Total Pemasukan -->
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                            <i class="bi bi-wallet2 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-stone-500 uppercase tracking-wider">Total Pemasukan</p>
                            <p class="text-lg font-black text-emerald-700">
                                Rp {{ number_format((float) $totalPemasukan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Pengeluaran -->
                    <div class="flex items-center gap-4 border-t border-stone-100 pt-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-700">
                            <i class="bi bi-cash-stack text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-stone-500 uppercase tracking-wider">Total Pengeluaran</p>
                            <p class="text-lg font-black text-orange-700">
                                Rp {{ number_format((float) $totalPengeluaran, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Saldo Akhir -->
                    <div class="flex items-center gap-4 border-t border-stone-100 pt-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                            <i class="bi bi-piggy-bank text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-stone-500 uppercase tracking-wider">Saldo Akhir</p>
                            <p class="text-lg font-black text-blue-700">
                                Rp {{ number_format((float) $saldoAkhir, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
                                            {{ $laporan->tanggal_arsip ? \Carbon\Carbon::parse($laporan->tanggal_arsip)->translatedFormat('d F Y') : 'Tanggal tidak tersedia' }}
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartData = @json($chart_data ?? []);
            
            const labels = chartData.map(item => item.label);
            const labelsFull = chartData.map(item => item.label_full);
            const pemasukan = chartData.map(item => item.pemasukan);
            const pengeluaran = chartData.map(item => item.pengeluaran);

            const options = {
                series: [
                    {
                        name: 'Pemasukan',
                        data: pemasukan
                    },
                    {
                        name: 'Pengeluaran',
                        data: pengeluaran
                    }
                ],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                },
                colors: ['#8b5cf6', '#ef4444'], // purple and red from mockup
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.02,
                        stops: [0, 90, 100]
                    }
                },
                markers: {
                    size: 4,
                    colors: ['#8b5cf6', '#ef4444'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 6
                    }
                },
                xaxis: {
                    categories: labels,
                    labels: {
                        style: {
                            colors: '#78716c',
                            fontSize: '12px',
                            fontWeight: 600
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            if (val >= 1000000000) {
                                return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
                            }
                            if (val >= 1000000) {
                                return 'Rp ' + (val / 1000000).toFixed(0) + ' Jt';
                            }
                            if (val >= 1000) {
                                return 'Rp ' + (val / 1000).toFixed(0) + ' Rb';
                            }
                            return 'Rp ' + val;
                        },
                        style: {
                            colors: '#78716c',
                            fontSize: '12px',
                            fontWeight: 600
                        }
                    }
                },
                tooltip: {
                    x: {
                        formatter: function (val, { dataPointIndex }) {
                            return labelsFull[dataPointIndex] || '';
                        }
                    },
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                },
                grid: {
                    borderColor: '#f1f0ee',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    labels: {
                        colors: '#44403c'
                    },
                    markers: {
                        radius: 12
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart-laporan"), options);
            chart.render();
        });
    </script>
@endpush
