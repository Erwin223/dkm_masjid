<style>
/* ── base ─────────────────────────────────────── */
.stat-page { padding: 24px 0; display: flex; flex-direction: column; gap: 24px; }

/* ── hero strip ──────────────────────────────── */
.stat-hero {
    background: linear-gradient(135deg, #0f8b6d 0%, #0e7a5e 60%, #085041 100%);
    border-radius: 18px;
    padding: 28px 32px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.stat-hero::before {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.stat-hero::after {
    content: '';
    position: absolute;
    right: 60px; bottom: -80px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.stat-hero-left { z-index: 1; }
.stat-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.18);
    border-radius: 99px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.stat-hero-tag span {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #a7f3d0;
    display: inline-block;
}
.stat-hero-left h1 { font-size: 24px; font-weight: 800; margin: 0 0 6px; }
.stat-hero-left p  { font-size: 13px; color: rgba(255,255,255,0.82); margin: 0; }
.stat-hero-kpis {
    display: flex; gap: 12px; flex-wrap: wrap; z-index: 1;
}
.kpi-pill {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 14px;
    padding: 14px 20px;
    min-width: 140px;
    backdrop-filter: blur(6px);
}
.kpi-pill-label { font-size: 10px; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,0.75); }
.kpi-pill-value { font-size: 20px; font-weight: 800; margin: 6px 0 2px; }
.kpi-pill-sub   { font-size: 11px; color: rgba(255,255,255,0.65); }

/* ── summary row ──────────────────────────────── */
.stat-summary-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
@media(max-width:900px){ .stat-summary-row { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px){ .stat-summary-row { grid-template-columns: 1fr; } }

.stat-sum-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: box-shadow .18s, transform .18s;
}
.stat-sum-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
.stat-sum-icon {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.stat-sum-body {}
.stat-sum-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; font-weight: 600; }
.stat-sum-value { font-size: 19px; font-weight: 800; color: #111827; margin: 4px 0 2px; line-height: 1; }
.stat-sum-sub   { font-size: 11px; color: #6b7280; }

/* ── main grid ──────────────────────────────── */
.stat-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}
@media(max-width:1100px){ .stat-grid { grid-template-columns: 1fr; } }

/* ── chart card ──────────────────────────────── */
.chart-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 18px;
    padding: 22px 24px;
    transition: box-shadow .18s, border-color .18s, transform .18s;
}
.chart-card:hover { box-shadow: 0 12px 30px rgba(0,0,0,.07); transform: translateY(-2px); }
.chart-card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
.chart-card-title-label { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 4px; }
.chart-card-title { font-size: 17px; font-weight: 800; color: #111827; margin: 0; }
.chart-badge {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: 99px; padding: 5px 12px;
    font-size: 11px; font-weight: 700; letter-spacing: .04em;
    white-space: nowrap;
}
.chart-badge-green  { background: #d1fae5; color: #065f46; }
.chart-badge-blue   { background: #dbeafe; color: #1e40af; }
.chart-badge-amber  { background: #fef3c7; color: #92400e; }
.chart-badge-purple { background: #ede9fe; color: #5b21b6; }
.chart-badge-red    { background: #fee2e2; color: #b91c1c; }
.chart-badge-row    { display: flex; flex-wrap: wrap; gap: 6px; }

.chart-canvas-wrap { position: relative; }
.chart-canvas-wrap-line { height: 260px; }
.chart-canvas-wrap-donut { height: 200px; display: flex; align-items: center; justify-content: center; }
.chart-canvas-wrap-bar  { height: 200px; }

/* ── two-col row ─────────────────────────────── */
.chart-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 20px; }
@media(max-width:700px){ .chart-row-2 { grid-template-columns: 1fr; } }
.chart-row-3 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px; }
@media(max-width:700px){ .chart-row-3 { grid-template-columns: 1fr; } }

/* ── aside ───────────────────────────────────── */
.stat-aside { display: flex; flex-direction: column; gap: 16px; }
.aside-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 18px;
    padding: 20px;
}
.aside-title-label { font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 4px; }
.aside-title { font-size: 16px; font-weight: 800; color: #111827; margin: 0 0 16px; }
.aside-item {
    padding: 12px;
    border-radius: 12px;
    background: #f9fafb;
    margin-bottom: 10px;
}
.aside-item:last-child { margin-bottom: 0; }
.aside-item-label { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 6px; }
.aside-item-value { font-size: 16px; font-weight: 800; color: #111827; margin-bottom: 2px; }
.aside-item-sub   { font-size: 11px; color: #6b7280; }

/* rank bar */
.rank-bar-wrap { margin-top: 14px; display: flex; flex-direction: column; gap: 10px; }
.rank-item { display: flex; align-items: center; gap: 10px; }
.rank-num  { font-size: 12px; font-weight: 700; color: #9ca3af; width: 18px; flex-shrink: 0; }
.rank-info { flex: 1; min-width: 0; }
.rank-name { font-size: 13px; font-weight: 600; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rank-bar-track { background: #f3f4f6; border-radius: 99px; height: 6px; margin-top: 4px; }
.rank-bar-fill  { width: 0; height: 6px; border-radius: 99px; transition: width .3s ease; }
.rank-val  { font-size: 12px; font-weight: 700; color: #374151; white-space: nowrap; flex-shrink: 0; }

/* back button */
.btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    color: #6b7280; font-size: 13px; font-weight: 600;
    text-decoration: none; padding: 8px 16px;
    background: #f3f4f6; border-radius: 10px;
    transition: background .15s, color .15s;
}
.btn-back:hover { background: #e5e7eb; color: #111827; }

canvas { display: block; }
</style>
