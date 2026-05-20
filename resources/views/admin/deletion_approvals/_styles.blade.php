<style>
.approval-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.approval-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ecfccb, #bbf7d0);
    color: #166534;
}
.approval-title {
    margin: 0;
    font-size: 22px;
    color: #0f172a;
}
.approval-subtitle {
    margin: 4px 0 0;
    color: #64748b;
    font-size: 13px;
}
.summary-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}
.summary-card,
.panel-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}
.summary-card {
    padding: 18px;
}
.summary-label {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.summary-value {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}
.summary-note {
    margin-top: 8px;
    font-size: 12px;
    color: #94a3b8;
}
.panel-box {
    margin-bottom: 18px;
    overflow: hidden;
}
.panel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    border-bottom: 1px solid #e2e8f0;
}
.panel-title {
    margin: 0;
    font-size: 16px;
    color: #0f172a;
}
.count-pill {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.table-wrap {
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px 14px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 13px;
    vertical-align: top;
}
th {
    background: #f8fafc;
    color: #475569;
    text-align: left;
    font-weight: 700;
}
.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.module-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #eff6ff;
    color: #1d4ed8;
}
.action-row {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.btn-approve,
.btn-reject {
    border: none;
    border-radius: 8px;
    padding: 7px 12px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}
.btn-approve { background: #16a34a; }
.btn-reject { background: #dc2626; }
.empty-state {
    text-align: center;
    padding: 28px 16px;
    color: #94a3b8;
}
@media (max-width: 900px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>