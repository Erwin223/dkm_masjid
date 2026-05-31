@php
    $heroImage = $heroImage ?? asset('storage/icon/FOTO.jpeg');
@endphp

<style>


    :root {
        --primary: #047857;
        --primary-light: #10b981;
        --primary-dark: #064e3b;
        --primary-glow: rgba(4, 120, 87, 0.08);
        --accent: #f59e0b;
        --accent-light: #fff7ed;
        --accent-dark: #d97706;
        --accent-glow: rgba(245, 158, 11, 0.12);
        --bg-main: #f9f8f6;
        --bg-card: #ffffff;
        --text-main: #1c1917;
        --text-muted: #57534e;
        --text-light: #87827e;
        --border-color: rgba(28, 25, 23, 0.07);
        --line: rgba(255, 255, 255, 0.15);
        --soft-line: rgba(4, 120, 87, 0.06);

        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 20px;
        --radius-xl: 28px;
        --radius-full: 9999px;

        --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        --shadow-md: 0 10px 20px -3px rgba(0, 0, 0, 0.03), 0 4px 8px -2px rgba(0, 0, 0, 0.02);
        --shadow-lg: 0 20px 30px -5px rgba(28, 25, 23, 0.05), 0 10px 15px -5px rgba(28, 25, 23, 0.03);
        --shadow-xl: 0 25px 60px -15px rgba(6, 78, 59, 0.12);
        --shadow-glow: 0 0 20px rgba(4, 120, 87, 0.2);

        --transition-smooth: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Reset & Typography */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
        background-color: var(--bg-main);
    }

    body {
        font-family: "Plus Jakarta Sans", "Segoe UI", sans-serif;
        background: var(--bg-main);
        color: var(--text-main);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }

    [x-cloak] {
        display: none !important;
    }

    a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition-smooth);
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: "Outfit", "Segoe UI", sans-serif;
        font-weight: 700;
        letter-spacing: -0.01em;
        color: var(--text-main);
    }

    img {
        max-width: 100%;
        display: block;
        height: auto;
    }

    /* Page Layout */
    .page-shell {
        width: 100%;
        overflow: hidden;
    }

    /* Hero Section */
    .hero {
        position: relative;
        overflow: hidden;
        min-height: 96vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background:
            linear-gradient(180deg, rgba(6, 78, 59, 0.88) 0%, rgba(17, 24, 39, 0.95) 100%),
            url('{{ $heroImage }}') center center / cover no-repeat;
        box-shadow: var(--shadow-xl);
    }

    /* Floating Lanterns Decorative Effects */
    .hero::after {
        content: "";
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(217, 119, 6, 0.15) 0%, rgba(217, 119, 6, 0) 70%);
        pointer-events: none;
        z-index: 1;
    }

    .hero::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 150px;
        background: linear-gradient(180deg, rgba(249, 248, 230, 0) 0%, var(--bg-main) 100%);
        pointer-events: none;
        z-index: 2;
    }

    /* Topbar Navigation */
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        width: min(1200px, calc(100% - 48px));
        margin: 0 auto;
        padding: 24px 0;
        border-bottom: 1px solid var(--line);
        position: relative;
        z-index: 10;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .brand-mark {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 3px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: 2px solid var(--accent);
    }

    .brand-mark img {
        width: 100%;
        height: 100%;
        border-radius: var(--radius-full);
        object-fit: cover;
    }

    .brand-copy {
        display: flex;
        flex-direction: column;
        color: #ffffff;
    }

    .brand-title {
        font-family: "Outfit", sans-serif;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: 0.02em;
        line-height: 1.1;
        color: #ffffff;
    }

    .brand-subtitle {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--accent-light);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 2px;
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.88rem;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: var(--transition-smooth);
    }

    .nav a i {
        font-size: 1.05rem;
        transition: var(--transition-smooth);
    }

    .nav a:hover,
    .nav a.is-active {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .nav a.is-active i {
        color: var(--accent);
    }

    .text-gold {
        color: var(--accent) !important;
    }

    /* Hero Content Area */
    .hero-content {
        position: relative;
        z-index: 5;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 48px;
        align-items: center;
        width: min(1200px, calc(100% - 48px));
        margin: auto auto 40px;
        padding: 40px 0;
    }

    .hero-left {
        display: flex;
        justify-content: center;
    }

    /* Beautiful Islamic Geometric Shape inside Hero */
    .hero-mosaic {
        position: relative;
        width: 220px;
        height: 220px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
        border-radius: 35% 65% 60% 40% / 50% 40% 60% 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 40px rgba(217, 119, 6, 0.3), inset 0 4px 15px rgba(255, 255, 255, 0.4);
        color: #ffffff;
        animation: blobMorph 8s ease-in-out infinite alternate;
    }

    @keyframes blobMorph {
        0% { border-radius: 35% 65% 60% 40% / 50% 40% 60% 50%; }
        100% { border-radius: 60% 40% 45% 55% / 40% 60% 40% 60%; }
    }

    .hero-mosaic i {
        font-size: 5rem;
        filter: drop-shadow(0 8px 12px rgba(0,0,0,0.15));
    }

    .hero-mosaic .mosaic-text {
        font-family: "Outfit", sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-top: 8px;
    }

    .hero-right {
        color: #ffffff;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(4, 120, 87, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 20px;
        color: var(--accent-light);
        backdrop-filter: blur(10px);
    }

    .hero-right h1 {
        font-size: clamp(2.2rem, 4.5vw, 4rem);
        line-height: 1.1;
        font-weight: 900;
        margin-bottom: 18px;
        letter-spacing: -0.02em;
    }

    .hero-right h1 span {
        display: block;
        color: var(--accent);
        font-style: normal;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-right p {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.75;
        max-width: 640px;
        margin-bottom: 32px;
        font-weight: 400;
    }

    /* Highly Polish Search Bar */
    .search-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 10px 10px 20px;
        border-radius: var(--radius-lg);
        backdrop-filter: blur(15px);
        width: 100%;
        max-width: 580px;
        margin-bottom: 28px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        transition: var(--transition-smooth);
    }

    .search-bar:focus-within {
        border-color: var(--primary-light);
        background: rgba(255, 255, 255, 0.13);
        box-shadow: 0 20px 45px rgba(16, 185, 129, 0.15);
    }

    .search-bar .search-icon {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .search-bar input {
        flex: 1;
        border: 0;
        outline: 0;
        background: transparent;
        color: #ffffff;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 500;
        padding: 8px 0;
    }

    .search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.55);
    }

    .search-bar button {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
        color: #ffffff;
        border: 0;
        outline: 0;
        padding: 10px 24px;
        border-radius: var(--radius-md);
        font-family: "Outfit", sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2);
    }

    .search-bar button:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(217, 119, 6, 0.35);
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .hero-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-family: "Outfit", sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        box-shadow: var(--shadow-sm);
    }

    .hero-link-primary {
        background: #ffffff;
        color: var(--primary-dark);
        border: 2px solid #ffffff;
    }

    .hero-link-primary:hover {
        background: var(--accent-light);
        border-color: var(--accent-light);
        color: var(--accent-dark);
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .hero-link-secondary {
        border: 2px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(5px);
    }

    .hero-link-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: #ffffff;
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Prayer Panel */
    .prayer-panel-wrap {
        position: relative;
        z-index: 10;
        width: min(1200px, calc(100% - 48px));
        margin: -80px auto 0;
    }

    .prayer-panel {
        background: #ffffff;
        border-radius: var(--radius-xl);
        padding: 24px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-color);
        position: relative;
    }

    .panel-frame {
        display: grid;
        grid-template-columns: 1.1fr 1.9fr;
        gap: 20px;
        align-items: stretch;
    }

    /* Countdown Box */
    .countdown-box {
        position: relative;
        background: linear-gradient(135deg, var(--primary-dark) 0%, #033226 100%);
        border-radius: var(--radius-lg);
        color: #ffffff;
        padding: 30px;
        overflow: hidden;
        display: flex;
        align-items: center;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1), var(--shadow-lg);
    }

    .countdown-box::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 10% 10%, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0) 50%);
        pointer-events: none;
    }

    .moon-shape {
        position: absolute;
        top: -40px;
        right: -40px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(253, 230, 138, 0.08) 0%, rgba(253, 230, 138, 0) 70%);
        border-radius: var(--radius-full);
        pointer-events: none;
    }

    .countdown-main {
        width: 100%;
        position: relative;
        z-index: 2;
    }

    .timer-grid {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
        margin-bottom: 20px;
    }

    .timer-segment {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 8px 12px;
        border-radius: var(--radius-md);
        min-width: 65px;
        text-align: center;
        backdrop-filter: blur(5px);
    }

    .timer-segment strong {
        font-family: "Outfit", sans-serif;
        font-size: 1.8rem;
        line-height: 1;
        font-weight: 800;
        color: var(--accent);
        display: block;
    }

    .timer-segment span {
        font-size: 0.68rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-top: 4px;
    }

    .countdown-meta {
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
    }

    .countdown-meta div {
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .countdown-meta div strong {
        color: #ffffff;
        font-weight: 600;
    }

    /* Quote Box */
    .quote-box {
        background: linear-gradient(180deg, var(--bg-main) 0%, #f3f1ec 100%);
        border-radius: var(--radius-lg);
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        border: 1px solid var(--border-color);
    }

    .quote-icon {
        position: absolute;
        top: 20px;
        left: 24px;
        font-size: 3rem;
        color: rgba(4, 120, 87, 0.05);
        pointer-events: none;
    }

    .quote-box h3 {
        color: var(--primary);
        font-size: 1.15rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quote-box p {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 1rem;
        line-height: 1.7;
        color: var(--text-main);
        font-style: italic;
        margin-bottom: 14px;
        font-weight: 500;
    }

    .quote-box small {
        font-size: 0.84rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-top: auto;
    }

    .quote-box .quote-date {
        font-size: 0.76rem;
        color: var(--text-light);
        margin-top: 4px;
    }

    /* Prayer Times Grid */
    .prayer-times {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 12px;
        margin-top: 20px;
    }

    .prayer-time {
        background: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 10px;
        text-align: center;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .prayer-time.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: #ffffff;
        border-color: var(--primary);
        box-shadow: var(--shadow-lg), var(--shadow-glow);
        transform: translateY(-2px);
    }

    .prayer-time.active::before {
        content: "SEKARANG";
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.58rem;
        font-weight: 800;
        background: var(--accent);
        color: #ffffff;
        padding: 2px 10px;
        border-radius: 0 0 6px 6px;
        letter-spacing: 0.05em;
    }

    .prayer-time .label {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 8px;
        margin-top: 4px;
    }

    .prayer-time.active .label {
        color: rgba(255, 255, 255, 0.75);
    }

    .prayer-time strong {
        font-family: "Outfit", sans-serif;
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--text-main);
        display: block;
    }

    .prayer-time.active strong {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Tools & City Selectors */
    .sholat-tools {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .sholat-tools .left {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .sholat-tools .api-source {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-light);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .city-selector-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .city-selector-wrap .select-icon {
        position: absolute;
        left: 14px;
        color: var(--primary);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .city-selector-wrap select {
        padding: 10px 36px 10px 36px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-main);
        background-color: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        outline: 0;
        cursor: pointer;
        transition: var(--transition-smooth);
        appearance: none;
        min-width: 220px;
    }

    .city-selector-wrap select:focus {
        border-color: var(--primary);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .city-selector-wrap::after {
        content: "\F2E7"; /* Bootstrap Icon code for chevron-down */
        font-family: "bootstrap-icons";
        position: absolute;
        right: 14px;
        color: var(--text-light);
        pointer-events: none;
        font-size: 0.78rem;
    }

    .sholat-tools button {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        padding: 10px 22px;
        border-radius: var(--radius-md);
        font-family: "Outfit", sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
    }

    .sholat-tools button:hover {
        background: var(--primary);
        color: #ffffff;
        box-shadow: var(--shadow-md);
    }

    /* Overview Strip stats */
    .overview-strip {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        width: min(1200px, calc(100% - 48px));
        margin: 48px auto 0;
    }

    .overview-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }

    .overview-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: var(--transition-smooth);
    }

    .overview-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(4, 120, 87, 0.15);
    }

    .overview-card:hover::after {
        transform: scaleX(1);
    }

    .overview-card-content span {
        display: block;
        font-size: 0.84rem;
        font-weight: 700;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .overview-card-content strong {
        font-family: "Outfit", sans-serif;
        font-size: clamp(1.4rem, 2.5vw, 1.9rem);
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }

    .overview-card-icon {
        width: 54px;
        height: 54px;
        border-radius: var(--radius-md);
        background: var(--bg-main);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.6rem;
        transition: var(--transition-smooth);
    }

    .overview-card:hover .overview-card-icon {
        background: var(--primary-glow);
        color: var(--primary);
        transform: scale(1.08) rotate(5deg);
    }

    /* Latest News Section */
    .latest-news {
        width: min(1200px, calc(100% - 48px));
        margin: 76px auto 0;
    }

    .latest-news-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 36px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 16px;
    }

    .section-kicker {
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--accent-dark);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .latest-news-header h2 {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }

    .latest-news-header p {
        font-size: 0.95rem;
        color: var(--text-muted);
        max-width: 480px;
        line-height: 1.6;
    }

    .latest-news-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .news-feature-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: var(--transition-smooth);
    }

    .news-feature-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(4, 120, 87, 0.12);
    }

    .news-feature-media {
        position: relative;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: var(--bg-main);
    }

    .news-feature-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .news-feature-card:hover .news-feature-media img {
        transform: scale(1.05);
    }

    .news-feature-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .news-feature-body h3 {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 12px;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-feature-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-light);
        margin-bottom: 16px;
    }

    .news-feature-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .news-feature-meta span i {
        color: var(--primary);
    }

    .news-feature-body p {
        font-size: 0.88rem;
        color: var(--text-muted);
        line-height: 1.65;
        margin-bottom: 24px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-feature-link {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--primary);
        font-family: "Outfit", sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        align-self: flex-start;
        padding: 4px 0;
        border-bottom: 2px solid transparent;
        transition: var(--transition-smooth);
    }

    .news-feature-link i {
        font-size: 1.15rem;
        transition: var(--transition-smooth);
    }

    .news-feature-link:hover {
        color: var(--accent-dark);
        border-color: var(--accent);
    }

    .news-feature-link:hover i {
        transform: translateX(4px);
    }

    .news-empty-state {
        grid-column: 1 / -1;
        background: #ffffff;
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-lg);
        padding: 48px;
        text-align: center;
        color: var(--text-light);
        box-shadow: var(--shadow-sm);
    }

    .news-empty-state .empty-icon {
        font-size: 3rem;
        color: var(--border-color);
        margin-bottom: 12px;
        display: block;
    }

    .news-empty-state p {
        font-size: 0.95rem;
        font-weight: 600;
    }

    /* Content Cards Grid */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 30px;
        width: min(1200px, calc(100% - 48px));
        margin: 76px auto 96px;
    }

    .content-card-wide {
        grid-column: 1 / -1;
    }

    .content-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .content-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: var(--primary);
    }

    .card-header-icon {
        font-size: 2.8rem;
        color: var(--primary-glow);
        position: absolute;
        top: 30px;
        right: 40px;
        pointer-events: none;
    }

    .content-card h2 {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 10px;
        margin-top: 4px;
    }

    .content-card p {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 24px;
        max-width: 800px;
    }

    .content-divider {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 0;
    }

    .content-divider span {
        position: relative;
        display: block;
        width: 100%;
        max-width: 500px;
        height: 1px;
        background: linear-gradient(90deg, rgba(4, 120, 87, 0) 0%, rgba(4, 120, 87, 0.2) 30%, var(--accent) 50%, rgba(4, 120, 87, 0.2) 70%, rgba(4, 120, 87, 0) 100%);
    }

    .content-divider span::before {
        content: "\F473"; /* crescent-star icon in BI */
        font-family: "bootstrap-icons";
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.1rem;
        background: var(--bg-main);
        padding: 0 16px;
        color: var(--accent);
    }

    /* Polish Mini Stats list */
    .mini-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-top: 18px;
    }

    .mini-stat {
        background: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 24px;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }

    .mini-stat:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        background: #ffffff;
    }

    .stat-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 1.4rem;
        color: var(--primary);
        opacity: 0.2;
        transition: var(--transition-smooth);
    }

    .mini-stat:hover .stat-badge {
        opacity: 0.8;
        transform: scale(1.1);
    }

    .mini-stat strong {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        display: block;
        max-width: calc(100% - 24px);
    }

    .mini-stat b {
        font-family: "Outfit", sans-serif;
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 10px;
        display: block;
        line-height: 1.1;
    }

    .mini-stat span {
        font-size: 0.84rem;
        color: var(--text-muted);
        line-height: 1.6;
        display: block;
    }

    /* Subclass Cards styles */
    /* Kegiatan */
    .stat-kegiatan {
        border-top: 3px solid var(--primary);
    }

    .stat-kegiatan .stat-badge {
        color: var(--primary);
    }

    /* Laporan */
    .stat-laporan {
        border-top: 3px solid #3b82f6; /* Blue for reports */
    }

    .stat-laporan .stat-badge i {
        opacity: 1 !important; /* Keep actual red/green arrow contrast */
    }

    /* Donasi */
    .stat-donasi {
        border-top: 3px solid var(--accent);
    }

    .stat-donasi .stat-badge {
        color: var(--accent);
    }

    .empty-card {
        text-align: center;
        grid-column: 1 / -1;
    }

    .empty-card .stat-badge {
        position: relative;
        top: 0;
        right: 0;
        margin: 0 auto 12px;
        opacity: 0.5;
        font-size: 2rem;
    }

    .empty-card strong {
        max-width: 100%;
    }

    .empty-card b {
        font-size: 1.5rem;
        margin-bottom: 4px;
    }

    /* Scroll Reveal & Animations */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px) scale(0.99);
        transition:
            opacity 900ms cubic-bezier(0.2, 1, 0.3, 1),
            transform 900ms cubic-bezier(0.2, 1, 0.3, 1);
        will-change: opacity, transform;
    }

    .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .reveal {
        opacity: 0;
        animation-duration: 1000ms;
        animation-timing-function: cubic-bezier(0.25, 1, 0.5, 1);
        animation-fill-mode: forwards;
        will-change: transform, opacity;
    }

    .reveal-up { animation-name: revealUp; }
    .reveal-left { animation-name: revealLeft; }
    .reveal-right { animation-name: revealRight; }

    .delay-1 { animation-delay: 150ms; }
    .delay-2 { animation-delay: 300ms; }
    .delay-3 { animation-delay: 450ms; }
    .delay-4 { animation-delay: 600ms; }

    @keyframes revealUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes revealLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes revealRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* ----------------------------------------------------
       RESPONSIVE BREAKPOINTS (MOBILE & TABLET OPTIMIZATIONS)
       ---------------------------------------------------- */

    @media (max-width: 1120px) {
        .hero {
            min-height: auto;
        }

        .hero-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 30px;
            padding-bottom: 120px;
            margin-bottom: 20px;
        }

        .hero-left {
            order: -1;
        }

        .hero-right {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-right p {
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar {
            margin-left: auto;
            margin-right: auto;
        }

        .panel-frame {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 900px) {
        .topbar {
            flex-direction: column;
            gap: 16px;
            padding: 20px 0;
        }

        .nav {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .nav a {
            padding: 8px 14px;
            font-size: 0.8rem;
        }

        .overview-strip {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .latest-news-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 24px;
            margin-bottom: 60px;
        }

        .mini-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .prayer-times {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .prayer-time.active::before {
            left: auto;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 4px;
        }

        .prayer-time {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            text-align: left;
        }

        .prayer-time .label {
            margin: 0;
        }

        .sholat-tools {
            flex-direction: column;
            align-items: stretch;
        }

        .sholat-tools .left {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .city-selector-wrap select {
            width: 100%;
        }

        .sholat-tools button {
            width: 100%;
            justify-content: center;
        }

        .latest-news-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }

    @media (max-width: 560px) {
        .brand-mark {
            width: 52px;
            height: 52px;
        }

        .brand-title {
            font-size: 1.25rem;
        }

        .hero-right h1 {
            font-size: 2.1rem;
        }

        .hero-actions {
            flex-direction: column;
            width: 100%;
            gap: 10px;
        }

        .hero-link {
            width: 100%;
            justify-content: center;
        }

        .search-bar {
            flex-direction: column;
            padding: 12px;
            border-radius: var(--radius-md);
            gap: 10px;
        }

        .search-bar .search-icon {
            display: none;
        }

        .search-bar input {
            width: 100%;
            padding: 4px 6px;
            text-align: center;
        }

        .search-bar button {
            width: 100%;
            justify-content: center;
        }

        .countdown-box {
            padding: 24px;
            flex-direction: column;
            text-align: center;
        }

        .timer-grid {
            justify-content: center;
        }

        .timer-segment {
            flex: 1 1 30%;
        }

        .quote-box {
            padding: 24px;
        }

        .content-card {
            padding: 24px;
        }
    }

    /* Accessibility Settings (Reduced Motion support) */
    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }

        .reveal,
        .scroll-reveal,
        .hero-mosaic {
            opacity: 1;
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }
    }

    /* Public Frontend Pages */
    body.frontend-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 185, 129, 0.12), transparent 30%),
            radial-gradient(circle at top right, rgba(217, 119, 6, 0.10), transparent 28%),
            linear-gradient(180deg, #fffefc 0%, #faf9f6 30%, #f5f5f4 100%);
        color: var(--text-main);
    }

    .frontend-page {
        position: relative;
        overflow: hidden;
    }

    .frontend-page::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image: radial-gradient(circle at 1px 1px, rgba(120, 113, 108, 0.08) 1px, transparent 0);
        background-size: 24px 24px;
        opacity: 0.45;
    }

    .page-shell {
        width: min(1200px, calc(100% - 32px));
        margin: 0 auto;
    }

    .page-hero {
        position: relative;
        overflow: hidden;
        min-height: 72vh;
        background-color: #064e3b;
        background-image:
            radial-gradient(circle, rgba(245, 158, 11, 0.14) 1px, transparent 0),
            radial-gradient(circle, rgba(245, 158, 11, 0.14) 1px, transparent 0);
        background-size: 22px 22px;
        background-position: 0 0, 11px 11px;
        color: #ffffff;
        padding-top: 4rem;
        padding-bottom: 5rem;
        font-family: 'Outfit', sans-serif;
    }

    .page-hero::before,
    .page-hero::after {
        content: "";
        position: absolute;
        border-radius: 9999px;
        pointer-events: none;
    }

    .page-hero::before {
        width: 30rem;
        height: 30rem;
        top: -8rem;
        right: -8rem;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.16), rgba(245, 158, 11, 0) 72%);
    }

    .page-hero::after {
        width: 24rem;
        height: 24rem;
        bottom: -10rem;
        left: -8rem;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.16), rgba(16, 185, 129, 0) 72%);
    }

    .page-hero h1 {
        font-size: clamp(2.5rem, 4vw, 4.75rem);
        line-height: 1.03;
        letter-spacing: -0.05em;
        color: #ffffff;
        background: linear-gradient(90deg, #f59e0b, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-hero p {
        color: rgba(229, 231, 235, 0.92);
        font-size: 1.05rem;
        max-width: 42rem;
    }

    .page-section {
        position: relative;
        width: min(1200px, calc(100% - 32px));
        margin: 0 auto;
        padding: 3rem 0;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 9999px;
        border: 1px solid rgba(194, 65, 12, 0.38);
        background: rgba(245, 158, 11, 0.14);
        padding: 0.75rem 1.1rem;
        color: #fde68a;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        backdrop-filter: blur(14px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .page-section .section-heading {
        color: #f59e0b;
        font-size: clamp(1.9rem, 3vw, 3rem);
        line-height: 1.05;
        letter-spacing: -0.03em;
    }

    .page-section .section-copy {
        color: rgba(226, 232, 240, 0.92);
        font-size: 1rem;
    }

    .page-grid-note {
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #d9f99d;
        padding: 1rem 1.2rem;
        border-radius: 1.25rem;
        font-weight: 600;
    }

    .surface-card {
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
    }

    .surface-card:hover {
        transform: translateY(-4px);
        border-color: rgba(245, 158, 11, 0.35);
        box-shadow: 0 24px 60px rgba(4, 120, 87, 0.12);
    }

    .section-kicker {
        font-size: 0.78rem;
        font-weight: 800;
        color: var(--accent-dark);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        margin-bottom: 0.4rem;
    }

    .section-heading {
        font-size: clamp(1.65rem, 2.4vw, 2.2rem);
        font-weight: 900;
        line-height: 1.15;
        color: var(--text-main);
        letter-spacing: -0.02em;
    }

    .section-copy {
        margin-top: 0.75rem;
        font-size: 0.95rem;
        line-height: 1.8;
        color: var(--text-muted);
    }

    .surface-card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        background: #ffffff;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition-smooth);
    }

    .surface-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .surface-card-soft {
        background: linear-gradient(180deg, #ffffff 0%, #fcfbf8 100%);
    }

    .soft-panel {
        border: 1px solid rgba(255, 255, 255, 0.10);
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 25px 60px -15px rgba(6, 78, 59, 0.24);
        backdrop-filter: blur(18px);
    }

    .hero-stat {
        border: 1px solid rgba(255, 255, 255, 0.10);
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.08);
        padding: 1rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .hero-stat-label {
        display: block;
        font-size: 0.66rem;
        font-weight: 800;
        color: rgba(236, 253, 245, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.22em;
    }

    .hero-stat-value {
        display: block;
        margin-top: 0.6rem;
        font-size: 1.1rem;
        font-weight: 900;
        letter-spacing: -0.02em;
        color: #ffffff;
    }

    .hero-stat-copy {
        margin-top: 0.5rem;
        font-size: 0.76rem;
        line-height: 1.6;
        color: rgba(240, 253, 244, 0.82);
    }

    .page-grid-note {
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        background: #ffffff;
        padding: 0.9rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
        box-shadow: var(--shadow-sm);
    }
</style>
