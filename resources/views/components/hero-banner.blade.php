@props([
    'title' => '',
    'breadcrumb' => null,
    'bgImage' => null,
])

@php
    $hasImage = filled($bgImage);
@endphp

<section {{ $attributes->merge(['class' => 'relative w-full overflow-hidden text-white bg-[#064e3b]']) }}>
    @if($hasImage)
        <div
            class="absolute inset-0 bg-center bg-cover"
            style="background-image: url('{{ $bgImage }}');"
            aria-hidden="true"
        ></div>
        <div class="absolute inset-0 bg-black/45"></div>
    @endif

    <div class="relative mx-auto flex min-h-[420px] h-[52vh] w-full max-w-7xl items-center px-4 py-12 sm:min-h-[480px] sm:h-[58vh] sm:px-6 lg:min-h-[560px] lg:h-[62vh] lg:px-8">
        <div class="mx-auto w-full max-w-4xl text-center">
            @if($breadcrumb)
                <div class="mb-4 text-sm font-medium text-white/90">
                    {{ $breadcrumb }}
                </div>
            @endif

            <div data-aos="fade-down">
                <h1 class="text-center text-3xl font-bold tracking-tight text-white drop-shadow-sm sm:text-4xl lg:text-6xl">
                    {{ $title }}
                </h1>
            </div>

            {{ $slot }}
        </div>
    </div>
</section>
