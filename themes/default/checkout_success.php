<style>
    .success-container { max-width: 650px; margin: 4rem auto; text-align: center; background: var(--m-card); border: 1px solid var(--m-border); border-radius: 28px; padding: 4rem 3rem; position: relative; box-shadow: 0 15px 40px rgba(0,0,0,0.5); }
    .success-container::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 24px; pointer-events: none; opacity: 0.2; }
    
    .icon-wrapper { width: 90px; height: 90px; background: rgba(6,182,212,0.1); border: 2px dashed var(--m-cyan); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; position: relative; animation: magical-float 3s ease-in-out infinite; }
    .icon-wrapper svg { width: 44px; height: 44px; stroke: var(--m-cyan); fill: none; stroke-width: 2.5; stroke-linecap: round; }
    .sparkle { position: absolute; color: var(--m-pink); font-size: 1.2rem; }
    .s1 { top: -10px; right: 0; }
    .s2 { bottom: 10px; left: -10px; font-size: 0.9rem; }
    
    .success-title { font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 1rem; letter-spacing: -1px; }
    .success-message { color: var(--m-text); font-size: 1.15rem; line-height: 1.6; margin-bottom: 2.5rem; font-weight: 500; }
    
    .order-reference { display: inline-flex; flex-direction: column; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem 2.5rem; margin-bottom: 3rem; }
    .ref-label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.5rem; }
    .ref-code { font-size: 1.5rem; font-weight: 900; color: var(--m-cyan); font-family: monospace; letter-spacing: 2px; }

    .btn-home { display: inline-flex; align-items: center; gap: 0.75rem; padding: 1.1rem 2.5rem; background: var(--gradient-magic); color: #fff; text-decoration: none; border-radius: 20px; font-weight: 800; font-size: 1.05rem; transition: all 0.3s; position: relative; z-index: 2; box-shadow: var(--shadow-magic); }
    .btn-home::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.5); border-radius: 18px; }
    .btn-home:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(139,92,246,0.4); }
</style>

<div class="success-container">
    <div class="icon-wrapper">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <div class="sparkle s1">✨</div>
        <div class="sparkle s2">✨</div>
    </div>
    
    <div class="success-title">Order Received!</div>
    <div class="success-message">
        Thank you! Your coordinates have been locked in. <br>
        <strong>You will be contacted soon via Comlink (Phone) to confirm delivery details.</strong>
    </div>

    <div class="order-reference">
        <div class="ref-label">Transaction ID</div>
        <div class="ref-code"><?= htmlspecialchars($order['id'] ?? 'SYS_ERROR') ?></div>
    </div>

    <a href="/" class="btn-home">
        <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        Return to Cosmos
    </a>
</div>
