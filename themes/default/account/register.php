<style>
    .auth-page { display: flex; align-items: center; justify-content: center; min-height: 70vh; position: relative; }
    
    .auth-card {
        background: var(--m-card);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--m-border);
        border-radius: 30px;
        padding: 3rem;
        width: 100%;
        max-width: 440px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.5);
    }
    .auth-card::after {
        content: ''; position: absolute; inset: 4px;
        border: var(--stitch-border);
        border-radius: 26px; pointer-events: none; opacity: 0.3;
    }
    
    .auth-header { text-align: center; margin-bottom: 2.5rem; position: relative; z-index: 2; }
    .auth-header svg { width: 48px; height: 48px; stroke: url(#magicGrad); fill: none; stroke-width: 1.5; stroke-linecap: round; margin-bottom: 1rem; animation: magical-float 4s ease-in-out infinite; }
    .auth-title { font-size: 2rem; font-weight: 900; color: #fff; letter-spacing: -1px; }
    
    .form-group { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.25rem; position: relative; z-index: 2; }
    .form-group label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1.5px; }
    
    .form-control {
        padding: 1rem 1.25rem; border: 1px solid var(--m-border); border-radius: 14px;
        font-family: var(--font-main); font-size: 1rem; color: #fff;
        background: rgba(0,0,0,0.4); transition: all 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--m-cyan); box-shadow: 0 0 20px rgba(6,182,212,0.2); }
    .form-control::placeholder { color: #475569; }

    .btn-auth {
        width: 100%; padding: 1.1rem; background: var(--gradient-magic); color: #fff;
        border: none; border-radius: 16px; font-family: var(--font-main); font-size: 1.1rem; font-weight: 900;
        cursor: pointer; transition: all 0.3s; margin-top: 1.5rem; position: relative;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 2; box-shadow: var(--shadow-magic);
    }
    .btn-auth::before {
        content: ''; position: absolute; inset: 2px;
        border: 1px dashed rgba(255,255,255,0.5); border-radius: 14px; pointer-events: none;
    }
    .btn-auth:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(139,92,246,0.5); animation: stitch-glow 1.5s infinite alternate; }

    .auth-footer { text-align: center; margin-top: 2rem; font-size: 0.95rem; color: var(--m-muted); position: relative; z-index: 2; }
    .auth-footer a { color: var(--m-cyan); text-decoration: none; font-weight: 800; transition: color 0.2s; }
    .auth-footer a:hover { color: var(--m-pink); }
    
    .auth-divider { display: flex; align-items: center; text-align: center; color: #475569; font-size: 0.85rem; font-weight: 600; margin: 1.5rem 0; text-transform: uppercase; position: relative; z-index: 2; }
    .auth-divider::before, .auth-divider::after { content: ''; flex: 1; border-bottom: 1px dashed var(--m-border); }
    .auth-divider:not(:empty)::before { margin-right: .5em; }
    .auth-divider:not(:empty)::after { margin-left: .5em; }
    
    .error-msg { background: rgba(244,63,94,0.1); border: 1px dashed #f43f5e; color: #fda4af; padding: 1rem; border-radius: 12px; font-size: 0.9rem; font-weight: 600; margin-bottom: 1.5rem; text-align: center; position: relative; z-index: 2; }
</style>

<!-- SVG Gradient definition for icons -->
<svg style="width:0;height:0;position:absolute;" aria-hidden="true" focusable="false">
    <linearGradient id="magicGrad" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#3b82f6" />
        <stop offset="50%" stop-color="#8b5cf6" />
        <stop offset="100%" stop-color="#d946ef" />
    </linearGradient>
</svg>

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
            <div class="auth-title">Synthesize Profile</div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">⚠ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/account/register">
            <div class="form-group">
                <label for="name">Known Alias</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Jane Doe" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="email">Hyperlink Address</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="you@cosmos.net" required>
            </div>
            
            <div class="form-group">
                <label for="password">Secret Phrase</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-auth">Awaken Account</button>
        </form>

        <div class="auth-divider">or</div>

        <div class="auth-footer">
            Already possess an identity? <a href="/account/login">Enter Portal</a>
        </div>
    </div>
</div>
