<style>
.report-page { display:flex; flex-direction:column; gap:24px; padding:8px 0 28px; }
.report-hero, .report-filter-card, .report-section, .report-table-card, .report-sign-card { background:#fff; border:1px solid #e5efe9; border-radius:20px; box-shadow:0 14px 28px rgba(15,23,42,.05); }
.report-hero { background:linear-gradient(135deg,#0f8b6d 0%,#0e7a5e 60%,#085041 100%); color:#fff; padding:28px 30px; display:flex; justify-content:space-between; align-items:flex-start; gap:18px; flex-wrap:wrap; }
.report-hero-label { display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:999px; font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; background:rgba(255,255,255,.14); margin-bottom:12px; }
.report-hero-title { font-size:28px; font-weight:800; margin:0 0 8px; }
.report-hero-subtitle { font-size:13px; line-height:1.6; color:rgba(255,255,255,.82); margin:0; max-width:760px; }
.report-hero-meta { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:10px; min-width:320px; }
.report-meta-card { border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.12); border-radius:16px; padding:14px 16px; }
.report-meta-label { font-size:10px; letter-spacing:.08em; text-transform:uppercase; color:rgba(255,255,255,.72); margin-bottom:6px; }
.report-meta-value { font-size:15px; font-weight:700; color:#fff; }
.report-filter-card { padding:20px; }
.report-module-nav { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:12px; margin-bottom:16px; }
.report-module-link { border:1px solid #dbe4de; border-radius:16px; padding:14px 16px; text-decoration:none; background:#fff; color:#111827; transition:.2s ease; }
.report-module-link:hover { border-color:#0f8b6d; background:#f6fcf9; transform:translateY(-1px); }
.report-module-link.active { border-color:#0f8b6d; background:#0f8b6d; color:#fff; box-shadow:0 14px 24px rgba(15,139,109,.18); }
.report-module-label { font-size:10px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; opacity:.72; margin-bottom:6px; }
.report-module-title { font-size:14px; font-weight:800; margin-bottom:4px; }
.report-module-note { font-size:12px; line-height:1.45; color:#6b7280; }
.report-module-link.active .report-module-note { color:rgba(255,255,255,.82); }
.report-filter-form { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:14px; align-items:end; }
.report-field { display:flex; flex-direction:column; gap:8px; }
.report-field label { font-size:12px; font-weight:700; color:#374151; }
.report-field input, .report-field select { height:42px; border:1px solid #d1d5db; border-radius:12px; padding:0 14px; font-size:13px; background:#fff; color:#111827; }
.report-actions { display:flex; gap:10px; flex-wrap:wrap; }
.report-btn { height:42px; border-radius:12px; border:none; padding:0 16px; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px; text-decoration:none; cursor:pointer; }
.report-btn-primary { background:#0f8b6d; color:#fff; }
.report-btn-primary:hover { background:#0c6d55; }
.report-btn-light { background:#f3f4f6; color:#111827; }
.report-btn-light:hover { background:#e5e7eb; }
.report-btn-accent { background:#eef6ff; color:#1d4ed8; }
.report-btn-accent:hover { background:#dbeafe; }
.report-summary-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:14px; }
.report-summary-card { background:#fff; border:1px solid #e5efe9; border-radius:18px; padding:18px 20px; box-shadow:0 14px 28px rgba(15,23,42,.05); }
.report-summary-label { font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af; margin-bottom:8px; }
.report-summary-value { font-size:24px; font-weight:800; color:#111827; margin-bottom:6px; line-height:1.2; }
.report-summary-note { font-size:12px; color:#6b7280; }
.is-positive { color:#198754; }
.is-negative { color:#dc3545; }
.report-section { padding:22px; display:flex; flex-direction:column; gap:18px; }
.report-section-head { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap; }
.report-section-label { font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:5px; }
.report-section-title { font-size:20px; font-weight:800; color:#111827; margin:0; }
.report-section-subtitle { font-size:13px; color:#6b7280; margin:6px 0 0; }
.report-chip-row { display:flex; gap:10px; flex-wrap:wrap; }
.report-chip { border-radius:999px; padding:8px 12px; font-size:12px; font-weight:700; }
.report-chip-green { background:#e8f6ee; color:#198754; }
.report-chip-red { background:#fdecec; color:#b02a37; }
.report-chip-blue { background:#eef0fd; color:#4361ee; }
.report-table-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
.report-table-card { padding:18px; }
.report-table-head { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:14px; flex-wrap:wrap; }
.report-table-title { font-size:16px; font-weight:800; color:#111827; margin:0; }
.report-table-total { font-size:12px; font-weight:700; color:#0f8b6d; background:#e8f6ee; border-radius:999px; padding:7px 12px; }
.report-table-total.is-outgoing { color:#b02a37; background:#fdecec; }
.report-table-wrap { overflow-x:auto; }
.report-table { width:100%; min-width:620px; border-collapse:collapse; }
.report-table th, .report-table td { padding:10px 12px; border-bottom:1px solid #eef2f7; font-size:13px; text-align:left; vertical-align:top; white-space:nowrap; }
.report-table th { font-size:12px; font-weight:700; color:#6b7280; background:#f8fafc; }
.report-empty, .is-muted { color:#9ca3af; }
.report-empty { text-align:center; padding:22px 12px; font-size:13px; }
.report-signature { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
.report-sign-card { padding:22px; min-height:150px; border-style:dashed; }
.report-sign-title { font-size:13px; font-weight:700; color:#374151; margin-bottom:14px; }
.report-sign-space { height:56px; }
.report-sign-line { border-top:1px solid #9ca3af; padding-top:8px; font-size:12px; color:#6b7280; }
.report-print-note { font-size:11px; color:#6b7280; margin-top:10px; }
@media (max-width:1180px) { .report-module-nav, .report-filter-form, .report-summary-grid, .report-table-grid, .report-hero-meta { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width:768px) {
    .report-module-nav, .report-filter-form, .report-summary-grid, .report-table-grid, .report-signature, .report-hero-meta { grid-template-columns:1fr; }
    .report-actions { width:100%; }
    .report-btn { width:100%; justify-content:center; }
}
</style>
