<style>
    :root {
        --bg: #201d1a;
        --panel: #f3efe7;
        --panel-strong: #ffffff;
        --hero-overlay: rgba(44, 108, 42, 0.72);
        --green: #136f29;
        --green-deep: #0b4f18;
        --gold: #ffb200;
        --ink: #1e1e1e;
        --muted: #6f6f6f;
        --line: rgba(255, 255, 255, 0.2);
        --soft-line: rgba(20, 20, 20, 0.08);
        --shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        --radius-xl: 28px;
        --radius-lg: 18px;
        --radius-md: 12px;
        --radius-sm: 10px;
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: #ffffff;
        color: var(--ink);
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    img {
        max-width: 100%;
        display: block;
    }

    .page-shell {
        width: 100%;
        margin: 0;
        overflow: hidden;
    }

    .hero {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        box-shadow: var(--shadow);
        background:
            linear-gradient(180deg, rgba(17, 17, 17, 0.55) 0%, rgba(17, 17, 17, 0.15) 18%, rgba(17, 17, 17, 0.5) 100%),
            linear-gradient(135deg, var(--hero-overlay), rgba(70, 143, 55, 0.54)),
            url('{{ $heroImage }}') center center / cover no-repeat;
    }

    .hero::after {
        content: "";
        position: absolute;
        inset: auto -10% -140px auto;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(255, 208, 94, 0.18) 0%, rgba(255, 208, 94, 0) 72%);
        pointer-events: none;
    }

    .hero::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 220px;
        background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.12) 26%,
            rgba(255, 255, 255, 0.42) 54%,
            rgba(255, 255, 255, 0.84) 78%,
            #ffffff 100%
        );
        pointer-events: none;
        z-index: 1;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        width: min(1240px, calc(100% - 48px));
        margin: 0 auto;
        padding: 18px 0 14px;
        border-bottom: 1px solid var(--line);
        position: relative;
        z-index: 3;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #fff;
    }

    .brand-mark {
        width: 74px;
        height: 74px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.92);
        border: 3px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
    }

    .brand-mark img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .brand-copy {
        display: none;
    }

    .nav {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 12px 24px;
        width: auto;
        margin-left: auto;
        padding: 0;
    }

    .nav a {
        color: rgba(255, 255, 255, 0.86);
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 6px 0;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .nav a:hover,
    .nav a.is-active {
        color: var(--gold);
        transform: translateY(-1px);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        align-items: start;
        width: min(1240px, calc(100% - 48px));
        margin: 0 auto;
        padding: 72px 0 72px;
    }

    .hero-left {
        align-self: start;
    }

    .hero-badge {
        display: none;
    }

    .hero-right {
        max-width: 720px;
        justify-self: end;
        color: #fff;
        padding-top: 12px;
    }

    .hero-right h1 {
        margin: 0 0 14px;
        font-size: clamp(2rem, 4vw, 3.8rem);
        line-height: 0.98;
        font-weight: 800;
        text-transform: uppercase;
    }

    .hero-right h1 span {
        color: var(--gold);
    }

    .hero-eyebrow {
        display: inline-flex;
        margin-bottom: 14px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #eef9ee;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .hero-right p {
        margin: 0 0 24px;
        max-width: 560px;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
        line-height: 1.7;
    }

    .search-bar {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 10px;
        width: min(540px, 100%);
        padding: 10px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
    }

    .search-bar input,
    .search-bar button,
    .sholat-tools select,
    .sholat-tools button {
        font: inherit;
    }

    .search-bar input {
        border: 0;
        outline: 0;
        background: transparent;
        color: #fff;
        padding: 8px 4px;
        font-size: 16px;
    }

    .search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.82);
    }

    .search-bar button {
        border: 0;
        cursor: pointer;
        border-radius: 10px;
        padding: 0 18px;
        background: rgba(255, 178, 0, 0.94);
        color: #1c1c1c;
        font-weight: 700;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
    }

    .hero-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 700;
        transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease, border-color 0.25s ease;
    }

    .hero-link:hover {
        transform: translateY(-2px);
    }

    .hero-link-primary {
        background: var(--gold);
        color: #1f1f1f;
    }

    .hero-link-secondary {
        border: 1px solid rgba(255, 255, 255, 0.34);
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
    }

    .prayer-panel-wrap {
        position: relative;
        z-index: 3;
        width: min(1240px, calc(100% - 48px));
        margin: 28px auto 0;
    }

    .prayer-panel {
        background: linear-gradient(180deg, #f5f2ec 0%, #f7f4ee 100%);
        border-radius: var(--radius-xl);
        padding: 42px 18px 18px;
        box-shadow: 0 14px 34px rgba(0, 0, 0, 0.16);
    }

    .panel-frame {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 14px;
        align-items: stretch;
        padding: 12px;
        border-radius: 14px;
        background: linear-gradient(90deg, rgba(222, 247, 244, 0.95) 0%, rgba(211, 238, 219, 0.95) 45%, rgba(247, 250, 247, 0.95) 100%);
        border: 3px solid #2ca7ff;
    }

    .countdown-box {
        position: relative;
        display: flex;
        gap: 14px;
        padding: 14px 16px 14px 76px;
        min-height: 134px;
        align-items: center;
        overflow: hidden;
    }

    .moon-shape {
        position: absolute;
        left: 12px;
        top: 8px;
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: linear-gradient(180deg, #ffdb58 0%, #ffbe16 100%);
        box-shadow: inset -10px -8px 0 rgba(243, 166, 23, 0.65);
    }

    .moon-shape::after {
        content: "";
        position: absolute;
        inset: 6px 10px 6px 28px;
        border-radius: 50%;
        background: rgba(230, 244, 229, 0.92);
    }

    .countdown-main {
        position: relative;
        z-index: 1;
        width: 100%;
    }

    .timer-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .timer-segment {
        min-width: 48px;
        padding: 10px 12px;
        border-radius: 10px;
        text-align: center;
        background: rgba(255, 255, 255, 0.58);
        border: 1px solid rgba(11, 79, 24, 0.18);
    }

    .timer-segment strong {
        display: block;
        font-size: 1.95rem;
        line-height: 1;
        color: #1d1d1d;
    }

    .timer-segment span {
        display: block;
        margin-top: 6px;
        font-size: 0.82rem;
        font-weight: 700;
        color: #272727;
    }

    .countdown-meta {
        font-size: 15px;
        color: #252525;
        line-height: 1.55;
    }

    .quote-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 12px;
        padding: 18px 20px;
        border-radius: 10px;
        background: linear-gradient(180deg, #0f7c12 0%, #086707 100%);
        color: #fff3ca;
        text-align: center;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12);
    }

    .quote-box h3 {
        margin: 0;
        color: #fff;
        font-size: 1.3rem;
    }

    .quote-box p {
        margin: 0;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .quote-box small {
        color: #ffcb4d;
        font-weight: 700;
    }

    .quote-box .quote-date {
        font-size: 0.84rem;
        color: #ffd363;
    }

    .prayer-times {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        margin-top: 10px;
        padding: 10px;
        border-radius: 12px;
        background: #2b2928;
        color: #fff;
    }

    .prayer-time {
        border-radius: 8px;
        text-align: center;
        padding: 12px 8px;
        transition: background 0.2s ease;
    }

    .prayer-time.active {
        background: #1c6b26;
    }

    .prayer-time .label {
        display: block;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.82);
        margin-bottom: 6px;
    }

    .prayer-time strong {
        font-size: 16px;
    }

    .sholat-tools {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 14px;
        padding: 0 4px;
        color: #4e4e4e;
        font-size: 13px;
    }

    .sholat-tools .left {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .sholat-tools select {
        min-width: 190px;
        border-radius: 10px;
        border: 1px solid rgba(15, 79, 24, 0.18);
        background: #fff;
        padding: 10px 12px;
        color: #252525;
    }

    .sholat-tools button {
        border: 0;
        border-radius: 10px;
        padding: 10px 14px;
        background: #1b7e2f;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
        width: min(1240px, calc(100% - 48px));
        margin: 28px auto 56px;
    }

    .content-divider {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px 0;
    }

    .content-divider span {
        position: relative;
        display: block;
        width: min(100%, 420px);
        height: 1px;
        background: linear-gradient(90deg, rgba(19, 111, 41, 0) 0%, rgba(19, 111, 41, 0.32) 20%, rgba(255, 178, 0, 0.95) 50%, rgba(19, 111, 41, 0.32) 80%, rgba(19, 111, 41, 0) 100%);
    }

    .content-divider span::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: linear-gradient(180deg, #ffcf59 0%, #ffb200 100%);
        border: 3px solid #fff;
        box-shadow: 0 8px 20px rgba(255, 178, 0, 0.22);
        transform: translate(-50%, -50%);
    }

    .overview-strip {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        width: min(1240px, calc(100% - 48px));
        margin: 26px auto 0;
    }

    .overview-card {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        border-radius: 22px;
        background:
            radial-gradient(circle at top right, rgba(255, 178, 0, 0.16), transparent 34%),
            linear-gradient(180deg, #ffffff 0%, #f7f6f2 100%);
        border: 1px solid rgba(12, 72, 29, 0.08);
        box-shadow: 0 16px 34px rgba(0, 0, 0, 0.08);
    }

    .overview-card::after {
        content: "";
        position: absolute;
        inset: auto 20px 0 auto;
        width: 72px;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(90deg, #0f7c12 0%, #ffb200 100%);
    }

    .overview-card span {
        display: block;
        margin-bottom: 8px;
        color: #627062;
        font-size: 0.86rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .overview-card strong {
        display: block;
        color: #132513;
        font-size: clamp(1.4rem, 3vw, 2.1rem);
        line-height: 1.05;
    }

    .reveal {
        opacity: 0;
        animation-duration: 950ms;
        animation-timing-function: cubic-bezier(0.22, 1, 0.36, 1);
        animation-fill-mode: forwards;
        will-change: transform, opacity;
    }

    .reveal-up {
        animation-name: revealUp;
    }

    .reveal-left {
        animation-name: revealLeft;
    }

    .reveal-right {
        animation-name: revealRight;
    }

    .delay-1 {
        animation-delay: 120ms;
    }

    .delay-2 {
        animation-delay: 240ms;
    }

    .delay-3 {
        animation-delay: 360ms;
    }

    .delay-4 {
        animation-delay: 460ms;
    }

    @keyframes revealUp {
        from {
            opacity: 0;
            transform: translateY(38px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes revealLeft {
        from {
            opacity: 0;
            transform: translateX(-28px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes revealRight {
        from {
            opacity: 0;
            transform: translateX(28px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .content-card {
        background: rgba(255, 248, 238, 0.98);
        border: 1px solid var(--soft-line);
        border-radius: 22px;
        padding: 26px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 26px 48px rgba(0, 0, 0, 0.1);
    }

    .content-card h2 {
        margin: 0 0 10px;
        font-size: 1.7rem;
        line-height: 1.15;
        color: #212121;
    }

    .content-card p {
        margin: 0;
        color: #5b5b5b;
        line-height: 1.75;
    }

    .latest-news {
        width: min(1240px, calc(100% - 48px));
        margin: 34px auto 0;
        padding-top: 8px;
    }

    .latest-news-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .latest-news-header h2 {
        margin: 0;
        font-size: clamp(2rem, 3vw, 2.6rem);
        line-height: 1.05;
        color: #171717;
    }

    .latest-news-header p {
        max-width: 420px;
        margin: 0;
        color: #5c5c5c;
        line-height: 1.7;
    }

    .latest-news-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .news-feature-card {
        overflow: hidden;
        border-radius: 24px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 20px 42px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 50px rgba(0, 0, 0, 0.12);
    }

    .news-feature-media {
        aspect-ratio: 16 / 10;
        background: #eaeaea;
        overflow: hidden;
    }

    .news-feature-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-feature-card:hover .news-feature-media img {
        transform: scale(1.04);
    }

    .news-feature-body {
        padding: 18px 20px 20px;
    }

    .news-feature-body h3 {
        margin: 0 0 10px;
        font-size: 1.35rem;
        line-height: 1.3;
        color: #1a1a1a;
    }

    .news-feature-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        margin-bottom: 12px;
        color: #6a6a6a;
        font-size: 0.86rem;
    }

    .news-feature-meta span {
        position: relative;
    }

    .news-feature-meta span + span::before {
        content: "";
        position: absolute;
        left: -8px;
        top: 50%;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #b6b6b6;
        transform: translateY(-50%);
    }

    .news-feature-body p {
        margin: 0 0 16px;
        color: #555;
        line-height: 1.75;
    }

    .news-feature-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 14px;
        border-radius: 10px;
        background: #0f7c12;
        color: #fff;
        font-size: 0.92rem;
        font-weight: 700;
        transition: background 0.25s ease, transform 0.25s ease;
    }

    .news-feature-link:hover {
        background: #0b6310;
        transform: translateY(-1px);
    }

    .news-empty-state {
        grid-column: 1 / -1;
        padding: 28px;
        border-radius: 20px;
        background: #faf7f1;
        border: 1px dashed rgba(0, 0, 0, 0.12);
        color: #666;
        text-align: center;
    }

    .content-card-wide {
        grid-column: 1 / -1;
    }

    .section-kicker {
        display: inline-flex;
        margin-bottom: 10px;
        color: #0d6f2a;
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(42px) scale(0.985);
        transition:
            opacity 820ms cubic-bezier(0.22, 1, 0.36, 1),
            transform 820ms cubic-bezier(0.22, 1, 0.36, 1),
            box-shadow 0.3s ease;
        will-change: opacity, transform;
    }

    .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .news-item {
        padding: 14px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .news-item:first-of-type {
        padding-top: 4px;
    }

    .news-item:last-of-type {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .news-item strong,
    .news-item small,
    .news-item span {
        display: block;
    }

    .news-item strong {
        margin-bottom: 6px;
        color: #1f1f1f;
    }

    .news-item small {
        margin-bottom: 8px;
        color: #0d6f2a;
        font-weight: 600;
    }

    .news-item span {
        color: #5b5b5b;
        line-height: 1.7;
    }

    .feature-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .feature-item {
        padding: 16px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid rgba(13, 111, 42, 0.08);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
    }

    .feature-item strong,
    .mini-stat strong {
        display: block;
        margin-bottom: 6px;
        color: #0d6f2a;
    }

    .feature-item span,
    .mini-stat span {
        color: #5f5f5f;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .mini-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .mini-stat {
        padding: 18px;
        border-radius: 16px;
        background: linear-gradient(180deg, #fff 0%, #f5f3ef 100%);
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.04);
    }

    .mini-stat b {
        display: block;
        font-size: 1.7rem;
        color: #1e1e1e;
        margin-bottom: 4px;
    }

    .section-anchor {
        position: relative;
        top: -30px;
    }

    .status-loading,
    .status-error {
        padding: 18px;
        border-radius: 14px;
        text-align: center;
        font-weight: 600;
    }

    .status-loading {
        background: rgba(255, 255, 255, 0.7);
        color: #5a5a5a;
    }

    .status-error {
        background: rgba(183, 27, 27, 0.08);
        color: #9a1919;
    }

    @media (max-width: 1080px) {
        .hero {
            min-height: auto;
        }

        .hero-content {
            grid-template-columns: 1fr;
            padding-bottom: 56px;
        }

        .hero-right {
            justify-self: start;
        }

        .panel-frame {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 820px) {
        .hero {
            min-height: auto;
        }

        .topbar,
        .hero-content,
        .prayer-panel-wrap,
        .overview-strip,
        .content-grid {
            width: min(100% - 24px, 1240px);
        }

        .hero-content {
            gap: 18px;
            padding-top: 40px;
            padding-bottom: 110px;
        }

        .topbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .nav {
            width: 100%;
            margin-left: 0;
            justify-content: flex-start;
            gap: 10px 18px;
        }

        .content-grid,
        .overview-strip,
        .latest-news-grid,
        .mini-stats,
        .prayer-times {
            grid-template-columns: 1fr;
        }

        .latest-news {
            width: min(100% - 24px, 1240px);
        }

        .latest-news-header {
            align-items: start;
            flex-direction: column;
        }

        .prayer-panel-wrap {
            margin-top: 24px;
        }

        .countdown-box {
            padding-left: 20px;
            padding-top: 96px;
        }

        .moon-shape {
            left: 50%;
            transform: translateX(-50%);
            top: 10px;
        }

        .sholat-tools {
            align-items: stretch;
        }

        .sholat-tools .left,
        .sholat-tools button,
        .sholat-tools select {
            width: 100%;
        }
    }

    @media (max-width: 560px) {
        .hero {
            min-height: auto;
        }

        .hero::before {
            height: 180px;
        }

        .brand-mark {
            width: 64px;
            height: 64px;
        }

        .nav a {
            font-size: 13px;
        }

        .hero-right h1 {
            font-size: 2.1rem;
        }

        .search-bar {
            grid-template-columns: 1fr;
        }

        .hero-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .search-bar button {
            min-height: 44px;
        }

        .timer-grid {
            justify-content: center;
        }

        .timer-segment {
            flex: 1 1 30%;
        }

        .prayer-panel {
            padding-top: 30px;
        }

        .prayer-panel-wrap {
            margin-top: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }

        .reveal,
        .scroll-reveal {
            opacity: 1;
            animation: none;
            transition: none;
            transform: none;
        }
    }
</style>
