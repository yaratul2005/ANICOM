<h2 class="page-title">Overview</h2>

<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { display: flex; flex-direction: column; gap: 0.5rem; }
    .stat-val { font-size: 2.5rem; font-weight: 700; color: #0f172a; line-height: 1; }
    .stat-label { color: #64748b; font-weight: 500; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-trend { font-size: 0.85rem; font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 4px; display: inline-block; align-self: flex-start; }
    .trend-up { background: #dcfce7; color: #166534; }
    .trend-down { background: #fee2e2; color: #991b1b; }
    
    .dashboard-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
</style>

<div class="stats-grid">
    <div class="card stat-card">
        <span class="stat-label">Total Revenue</span>
        <span class="stat-val">$12,450.00</span>
        <span class="stat-trend trend-up">+14.5% vs last week</span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Pending Orders</span>
        <span class="stat-val">34</span>
        <span class="stat-trend trend-down">-2 since yesterday</span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Store Visitors</span>
        <span class="stat-val">1,240</span>
        <span class="stat-trend trend-up">+5.2% vs last week</span>
    </div>
</div>

<div class="dashboard-layout">
    <div class="card">
        <h3 style="margin-top: 0;">Recent Orders</h3>
        <p style="color: #64748b; font-size: 0.9rem;">The order processing logic goes here. Mapped against DB.</p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 1.5rem 0;">
        <div style="padding: 1rem; background: #f8fafc; border-radius: 8px; text-align: center; color: #94a3b8;">
            No recent orders.
        </div>
    </div>
    <div class="card">
        <h3 style="margin-top: 0;">Getting Started Checklist</h3>
        <ul style="list-style: none; padding: 0; margin: 0; color: #475569;">
            <li style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">✔ Store Core Configuration</li>
            <li style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">✔ Run Onboarding Wizard</li>
            <li style="padding: 0.75rem 0; color: #2563eb; font-weight: 500;">○ Add First Product</li>
            <li style="padding: 0.75rem 0;">○ Setup Shipping Zones</li>
        </ul>
    </div>
</div>
