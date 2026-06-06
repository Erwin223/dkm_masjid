<?php

namespace App\Http\Controllers;

/**
 * Base controller for all public-facing (frontend) pages.
 *
 * Provides shared helpers that every frontend controller can use so that
 * navigation items, active-state detection, and similar cross-page concerns
 * are defined in exactly one place.
 */
class FrontendController extends Controller
{
    /**
     * Return the full navigation item array for the frontend navbar.
     *
     * Each controller action that renders a frontend view should call
     * $this->frontendNavItems() and pass the result to the view so that
     * the active-state is always computed from the live request context.
     */
    protected function frontendNavItems(): array
    {
        return [
            [
                'label'  => 'Beranda',
                'href'   => route('frontend.home'),
                'active' => request()->routeIs('frontend.home'),
                'icon'   => 'bi-house-door',
            ],
            [
                'label'  => 'Profil Masjid',
                'href'   => route('frontend.profil'),
                'active' => request()->routeIs('frontend.profil', 'frontend.profil.pengurus'),
                'icon'   => 'bi-building',
            ],
            [
                'label'  => 'Berita',
                'href'   => route('frontend.berita'),
                'active' => request()->routeIs('frontend.berita', 'frontend.berita.show'),
                'icon'   => 'bi-newspaper',
            ],
            [
                'label'   => 'Kegiatan & Galeri',
                'href'    => '#',
                'active'  => request()->routeIs('frontend.kegiatan', 'frontend.galeri'),
                'icon'    => 'bi-collection',
                'dropdown' => [
                    [
                        'label'  => 'Jadwal Kegiatan',
                        'href'   => route('frontend.kegiatan'),
                        'active' => request()->routeIs('frontend.kegiatan'),
                        'icon'   => 'bi-calendar-event',
                    ],
                    [
                        'label'  => 'Galeri Foto',
                        'href'   => route('frontend.galeri'),
                        'active' => request()->routeIs('frontend.galeri'),
                        'icon'   => 'bi-images',
                    ],
                ],
            ],
            [
                'label'  => 'Laporan',
                'href'   => route('frontend.laporan'),
                'active' => request()->routeIs('frontend.laporan'),
                'icon'   => 'bi-file-earmark-text',
            ],
            [
                'label'  => 'Donasi',
                'href'   => route('frontend.donasi'),
                'active' => request()->routeIs('frontend.donasi'),
                'icon'   => 'bi-heart-fill',
            ],
        ];
    }

    /**
     * Quick-link map used by the home-page hero search bar.
     * Maps search keywords → section anchors on the home page.
     */
    protected function homeQuickLinks(): array
    {
        return [
            'beranda'  => '#beranda',
            'home'     => '#beranda',
            'kegiatan' => '#kegiatan',
            'agenda'   => '#kegiatan',
            'berita'   => '#berita',
            'laporan'  => '#laporan',
            'donasi'   => '#donasi',
            'zakat'    => '#donasi',
        ];
    }
}
