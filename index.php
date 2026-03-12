<?php require_once(__DIR__.'/layouts/header.php'); ?>
<!-- Nav -->
<nav>
  <div class="logo" onclick="go('home')">
    <div class="logo-box">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
        <rect x="1" y="1" width="6" height="6" rx="1.2" fill="white"/>
        <rect x="10" y="1" width="6" height="6" rx="1.2" fill="white"/>
        <rect x="1" y="10" width="6" height="6" rx="1.2" fill="white"/>
        <rect x="11" y="11" width="2.5" height="2.5" rx=".4" fill="white"/>
        <rect x="14.5" y="11" width="1.8" height="1.8" rx=".4" fill="white"/>
        <rect x="11" y="14.5" width="1.8" height="1.8" rx=".4" fill="white"/>
        <rect x="14" y="14" width="2.2" height="2.2" rx=".4" fill="white"/>
      </svg>
    </div>
    <?= htmlspecialchars($appName) ?>
  </div>
  <div class="nav-right" id="nav-right"></div>
</nav>

<!-- HOME -->
<div class="page" id="page-home">
  <section class="hero">
    <div>
      <h1>QR codes that<br>look <em>great</em></h1>
      <p>Custom colours, logo branding, beautiful templates, and a personal library — everything for perfect QR codes.</p>
      <div class="hero-btns">
        <button class="btn btn-ink btn-lg" onclick="go('generate')">Start Creating →</button>
        <button class="btn btn-ink1 btn-lg" onclick="go('about')">About</button>
        <button class="btn btn-ghost btn-lg" onclick="go('register')">Free account</button>
      </div>
    </div>
    <div style="display:flex;justify-content:center">
      <div class="hero-card">
        <div style="width:168px;height:168px;margin:0 auto;background:#1a1814;border-radius:14px;display:flex;align-items:center;justify-content:center">
          <svg viewBox="0 0 100 100" width="130" height="130" fill="none">
            <rect x="5" y="5" width="30" height="30" rx="4" fill="#f5f3ef"/><rect x="10" y="10" width="20" height="20" rx="2.5" fill="#1a1814"/><rect x="14" y="14" width="12" height="12" rx="1.5" fill="#d4500a"/>
            <rect x="65" y="5" width="30" height="30" rx="4" fill="#f5f3ef"/><rect x="70" y="10" width="20" height="20" rx="2.5" fill="#1a1814"/><rect x="74" y="14" width="12" height="12" rx="1.5" fill="#d4500a"/>
            <rect x="5" y="65" width="30" height="30" rx="4" fill="#f5f3ef"/><rect x="10" y="70" width="20" height="20" rx="2.5" fill="#1a1814"/><rect x="14" y="74" width="12" height="12" rx="1.5" fill="#d4500a"/>
            <rect x="42" y="5" width="8" height="8" rx="2" fill="#f5f3ef"/><rect x="52" y="15" width="8" height="8" rx="2" fill="#f5f3ef"/>
            <rect x="42" y="42" width="8" height="8" rx="2" fill="#d4500a"/><rect x="52" y="52" width="8" height="8" rx="2" fill="#f5f3ef"/>
            <rect x="65" y="42" width="8" height="8" rx="2" fill="#f5f3ef"/><rect x="42" y="65" width="8" height="8" rx="2" fill="#f5f3ef"/>
            <rect x="65" y="75" width="8" height="8" rx="2" fill="#d4500a"/><rect x="80" y="80" width="8" height="8" rx="2" fill="#f5f3ef"/>
          </svg>
        </div>
        <div>
          <div class="hero-card-label">My Website</div>
          <div class="hero-card-url">example.com/page</div>
          <div class="hero-card-tags"><span class="tag tag-o">URL</span><span class="tag tag-g">Saved</span></div>
        </div>
      </div>
    </div>
  </section>
  <hr style="border:none;border-top:1px solid var(--border)">
  <section class="features">
    <div class="sec-label">Why QRMaker Pro</div>
    <div class="sec-title">Everything you need</div>
    <div class="features-grid">
      <div class="fc"><div class="fc-icon">⚡</div><h3>Instant preview</h3><p>QR updates live as you type — no waiting.</p></div>
      <div class="fc"><div class="fc-icon">🎨</div><h3>Custom colours</h3><p>Full foreground & background colour control with colour picker.</p></div>
      <div class="fc"><div class="fc-icon">🖼️</div><h3>Logo branding</h3><p>Upload your logo and embed it in the centre of the QR code.</p></div>
      <div class="fc"><div class="fc-icon">📁</div><h3>Saved library</h3><p>Free account to save and re-download your codes any time.</p></div>
      <div class="fc"><div class="fc-icon">📱</div><h3>Always scannable</h3><p>4 error correction levels — scans even when partially covered.</p></div>
      <div class="fc"><div class="fc-icon">⚙️</div><h3>Settings</h3><p>Manage your account, defaults, and preferences in one place.</p></div>
    </div>
  </section>
</div>

<!-- GENERATE -->
<div class="page" id="page-generate">
<div class="dash">
  <div class="dash-head">
    <div><h2>Create QR Code</h2><p>Design · Preview · Download or Save</p></div>
  </div>
  <div class="dash-grid">

    <!-- Left: config panel -->
    <div>
      <div class="panel">
        <div class="panel-tabs">
          <button class="ptab active" onclick="switchTab(this,'tc')">Content</button>
          <button class="ptab" onclick="switchTab(this,'td')">Design</button>
          <button class="ptab" onclick="switchTab(this,'tl')">Logo</button>
          <button class="ptab" onclick="switchTab(this,'ta')">Advanced</button>
        </div>

        <!-- Content -->
        <div class="panel-body" id="tc">
          <div class="type-grid">
            <button class="tbtn active" data-ph="https://example.com" onclick="setType(this)"><span class="ticon">🔗</span>URL</button>
            <button class="tbtn" data-ph="mailto:hello@you.com" onclick="setType(this)"><span class="ticon">✉️</span>Email</button>
            <button class="tbtn" data-ph="tel:+44 7700 000000" onclick="setType(this)"><span class="ticon">📞</span>Phone</button>
            <button class="tbtn" data-ph="sms:+44 7700 000000" onclick="setType(this)"><span class="ticon">💬</span>SMS</button>
            <button class="tbtn" data-ph="WIFI:T:WPA;S:MyNet;P:pass;;" onclick="setType(this)"><span class="ticon">📶</span>WiFi</button>
            <button class="tbtn" data-ph="Your text here…" onclick="setType(this)"><span class="ticon">📝</span>Text</button>
          </div>
          <div class="fg">
            <label class="fl">Content</label>
            <textarea class="fta" id="qr-content" rows="3" placeholder="https://example.com"></textarea>
            <span class="fh" id="char-ct"></span>
            <span class="fh sample_output">Sample: https://example.com</span>
          </div>
        </div>

        <!-- Design -->
        <div class="panel-body hidden" id="td" style="overflow-y: auto; max-height: 400px;">
          <div class="fg">
            <label class="fl">Template</label>
            <div class="tmpl-grid" id="tmpl-grid"></div>
          </div>

          <div class="fg">
            <label class="fl">Colour Presets</label>
            <div class="cdots" id="cdots"></div>
            <div style="font-size:11px;color:var(--ink3);margin-top:3px" id="pair-name">Classic</div>
          </div>

          <hr class="divider">

          <!-- FG picker -->
          <div class="fg">
            <label class="fl">Foreground Colour</label>
            <div class="color-pick-row">
              <div class="swatch-btn" id="fg-swatch">
                <div class="swatch-face" id="fg-face" style="background:#000000"></div>
                <input type="color" id="fg-picker" value="#000000">
              </div>
              <div class="fg" style="flex:1">
                <div class="hex-row">
                  <span class="hex-hash">#</span>
                  <input class="fi" type="text" id="fg-hex" value="000000" maxlength="6" spellcheck="false">
                </div>
              </div>
            </div>
          </div>

          <!-- BG picker -->
          <div class="fg">
            <label class="fl">Background Colour</label>
            <div class="color-pick-row">
              <div class="swatch-btn" id="bg-swatch">
                <div class="swatch-face" id="bg-face" style="background:#ffffff"></div>
                <input type="color" id="bg-picker" value="#ffffff">
              </div>
              <div class="fg" style="flex:1">
                <div class="hex-row">
                  <span class="hex-hash">#</span>
                  <input class="fi" type="text" id="bg-hex" value="ffffff" maxlength="6" spellcheck="false">
                </div>
              </div>
            </div>
          </div>

          <hr class="divider">

          <!-- Size -->
          <div class="fg sl-wrap">
            <div class="sl-row">
              <label class="fl">Output Resolution</label>
              <div class="size-input-row">
                <input class="size-num-input" type="number" id="qr-size-num" value="300" min="100" max="2000" step="10" >
                <span class="size-unit">px</span>
              </div>
            </div>
            <input type="range" id="qr-size" min="100" max="2000" step="10" value="300" onchange="schedule()">
            <span class="fh">Size of the downloaded/exported file. Preview scales proportionally.</span>
          </div>

          <!-- Padding -->
          <!-- <div class="fg sl-wrap">
            <div class="sl-row">
              <label class="fl">Padding (Quiet Zone)</label>
              <span class="sl-val" id="padding-lbl">16 px</span>
            </div>
            <input type="range" id="qr-padding" min="0" max="80" step="4" value="16">
            <span class="fh">White space around the QR code. Recommended ≥ 16 px.</span>
          </div> -->
        </div>

        <!-- Logo -->
        <div class="panel-body hidden" id="tl">
          <div class="fg">
            <label class="fl">Logo Image</label>
            <div class="logo-drop" id="logo-drop" onclick="document.getElementById('logo-file').click()">
              <input type="file" id="logo-file" accept="image/*" style="display:none">
              <div id="logo-ph" class="logo-drop-ph">
                <div class="logo-drop-icon">🖼️</div>
                <div class="logo-drop-lbl">Click to upload logo</div>
                <div class="logo-drop-hint">PNG · SVG · JPG — transparent PNG recommended</div>
              </div>
              <div id="logo-prev" class="hidden">
                <img id="logo-prev-img" class="logo-prev-img" alt="logo">
                <div class="logo-prev-name" id="logo-prev-name"></div>
              </div>
            </div>
            <button class="btn btn-ghost btn-sm" id="logo-rm-btn" onclick="removeLogo(event)" style="display:none;align-self:flex-start;margin-top:4px">✕ Remove logo</button>
          </div>
          <div class="fg sl-wrap">
            <div class="sl-row">
              <label class="fl">Logo Size</label>
              <span class="sl-val" id="logo-size-lbl">20%</span>
            </div>
            <input type="range" id="logo-size-slider" min="8" max="35" value="20">
            <span class="fh">Use ECC H on the Advanced tab when logo is large.</span>
          </div>
          <div class="fg">
            <label class="fl">Logo background</label>
            <select class="fsel" id="logo-bg-style" onchange="schedule()">
              <option value="white" selected>White circle</option>
              <option value="match">Match QR background</option>
              <option value="none">None (transparent)</option>
            </select>
          </div>
        </div>

        <!-- Advanced -->
        <div class="panel-body hidden" id="ta">
          <div class="fg">
            <label class="fl">Error Correction Level</label>
            <div class="ecc-row">
              <button class="eccbtn" data-e="L" onclick="setEcc(this)">L</button>
              <button class="eccbtn active" data-e="M" onclick="setEcc(this)">M</button>
              <button class="eccbtn" data-e="Q" onclick="setEcc(this)">Q</button>
              <button class="eccbtn" data-e="H" onclick="setEcc(this)">H</button>
            </div>
            <span class="fh" id="ecc-hint">15% — balanced quality & density. Use H when adding a logo.</span>
          </div>
          <div class="fg">
            <label class="fl">Margin (API border)</label>
            <select class="fsel" id="qr-margin" onchange="schedule()">
              <option value="0">0 — no API margin</option>
              <option value="1">1 — minimal</option>
              <option value="2" selected>2 — default</option>
              <option value="4">4 — generous</option>
            </select>
            <span class="fh">Modules of white space built in by the QR API (separate from padding).</span>
          </div>
        </div>

      </div><!-- /panel -->
    </div>

    <!-- Right: preview -->
    <div class="preview">
      <h3>Live Preview</h3>
      <div class="qr-box fr-classic" id="qr-box">
        <div class="qr-ph" id="qr-ph">
          <svg viewBox="0 0 64 64" fill="none"><rect x="4" y="4" width="24" height="24" rx="3" stroke="#1a1814" stroke-width="3"/><rect x="10" y="10" width="12" height="12" rx="1.5" fill="#1a1814" opacity=".3"/><rect x="36" y="4" width="24" height="24" rx="3" stroke="#1a1814" stroke-width="3"/><rect x="42" y="10" width="12" height="12" rx="1.5" fill="#1a1814" opacity=".3"/><rect x="4" y="36" width="24" height="24" rx="3" stroke="#1a1814" stroke-width="3"/><rect x="10" y="42" width="12" height="12" rx="1.5" fill="#1a1814" opacity=".3"/></svg>
          <span>Enter content to begin</span>
        </div>
        <div class="spinner hidden" id="qr-spin"></div>
        <canvas class="qr-canvas hidden" id="qr-canvas" width="230" height="230"></canvas>
         <div class="qr-size-badge hidden" id="qr-size-badge">300 × 300 px</div>
      </div>
      <div id="qr-meta" style="font-size:11px;color:var(--ink3)"></div>
      <div class="preview-acts">
        <button class="btn btn-ghost" id="btn-dl" onclick="downloadQR()" disabled>
          <svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4.5-4.5 1.06-1.06L7 9.88V2h2v7.88l2.44-2.44 1.06 1.06L8 12zM2 14h12v-2H2v2z"/></svg>
          PNG
        </button>
         <button class="btn btn-ghost" id="ec-svg" onclick="doExport('svg')" disabled>
          <svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4.5-4.5 1.06-1.06L7 9.88V2h2v7.88l2.44-2.44 1.06 1.06L8 12zM2 14h12v-2H2v2z"/></svg>
          SVG
        </button>
         
         <button class="btn btn-ghost" id="ec-pdf" onclick="doExport('pdf')" disabled>
          <svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4.5-4.5 1.06-1.06L7 9.88V2h2v7.88l2.44-2.44 1.06 1.06L8 12zM2 14h12v-2H2v2z"/></svg>
          PDF
        </button>
         <input type="hidden" name="qr-pdf" id="qr-pdf" value="a4"  />
         <input type="hidden" name="qr-pdf" id="qr-pdf-pos" value="center" />
         <button class="btn btn-ghost" id="ec-print" onclick="doExport('print')" disabled>
          <svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM6 12H4V7h2v5zm4 0H8V4h2v8zm4 0h-2V9h2v3z"/></svg>
          Print
        </button>
        <button class="btn btn-accent" id="btn-save" onclick="openSave()" disabled>
          <svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M13.5 1h-11A1.5 1.5 0 001 2.5v11A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0013.5 1zM8 12.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5zM10 4H3V2h7v2z"/></svg>
          Save
        </button>
      </div>
      <div id="login-hint" class="hidden" style="font-size:12px;color:var(--ink3);border-top:1px solid var(--border);padding-top:12px;width:100%;text-align:center">
        <a href="#" onclick="go('login')" style="color:var(--accent);font-weight:500;text-decoration:none">Sign in</a> to save QR codes
      </div>
    </div>

  </div>
</div>
</div>

<!-- LOGIN -->
<div class="page" id="page-login">
  <div class="auth-wrap">
    <div class="auth-card">
      <h2>Welcome back</h2><p class="auth-sub">Sign in to your account</p>
      <div id="login-err" class="alert alert-e hidden" style="margin-bottom:14px"></div>
      <div class="auth-form">
        <div class="fg"><label class="fl">Email</label><input class="fi" type="email" id="l-email" placeholder="you@example.com" autocomplete="email"></div>
        <div class="fg"><label class="fl">Password</label><input class="fi" type="password" id="l-pass" placeholder="••••••••" autocomplete="current-password"></div>
        <button class="btn btn-ink btn-lg" id="l-btn" onclick="doLogin()" style="width:100%;margin-top:4px">Sign in</button>
      </div>
      <div class="auth-foot">No account? <a href="#" onclick="go('register')">Create one free</a></div>
    </div>
  </div>
</div>

<!-- REGISTER -->
<div class="page" id="page-register">
  <div class="auth-wrap">
    <div class="auth-card">
      <h2>Create account</h2><p class="auth-sub">Free forever. No credit card.</p>
      <div id="reg-err" class="alert alert-e hidden" style="margin-bottom:14px"></div>
      <div class="auth-form">
        <div class="fg"><label class="fl">Name</label><input class="fi" type="text" id="r-name" placeholder="Alex Johnson" autocomplete="name"></div>
        <div class="fg"><label class="fl">Email</label><input class="fi" type="email" id="r-email" placeholder="you@example.com" autocomplete="email"></div>
        <div class="fg"><label class="fl">Password</label><input class="fi" type="password" id="r-pass" placeholder="Min. 6 characters" autocomplete="new-password"></div>
        <button class="btn btn-accent btn-lg" id="r-btn" onclick="doRegister()" style="width:100%;margin-top:4px">Create account</button>
      </div>
      <div class="auth-foot">Have an account? <a href="#" onclick="go('login')">Sign in</a></div>
    </div>
  </div>
</div>

<!-- SAVED -->
<div class="page" id="page-saved">
  <div class="lib">
    <div class="lib-head">
      <div><h2>My QR Codes</h2><p id="saved-count" style="font-size:13px;color:var(--ink2);margin-top:3px"></p></div>
      <button class="btn btn-ink" onclick="go('generate')">+ New QR Code</button>
    </div>
    <div class="qr-grid" id="saved-grid"></div>
  </div>
</div>

<!-- SETTINGS -->
<div class="page" id="page-settings">
  <div class="settings-wrap">
    <h2>Settings</h2>
    <p class="sub">Manage your account and preferences.</p>

    <!-- Guest fallback -->
    <div id="settings-guest" class="hidden" style="text-align:center;padding:60px 20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-lg)">
      <div style="font-size:44px;margin-bottom:14px">🔒</div>
      <h3 style="font-family:var(--fd);font-size:20px;font-weight:700;margin-bottom:8px">Sign in to access settings</h3>
      <p style="font-size:14px;color:var(--ink2);margin-bottom:22px">Create a free account to manage your preferences.</p>
      <div style="display:flex;gap:10px;justify-content:center">
        <button class="btn btn-ghost" onclick="go('login')">Sign in</button>
        <button class="btn btn-ink" onclick="go('register')">Get started</button>
      </div>
    </div>

    <!-- Logged-in sections -->
    <div id="settings-logged">

      <!-- Profile -->
      <div class="scard">
        <div class="scard-head">
          <div class="scard-head-icon">👤</div>
          <div><h3>Profile</h3><p>Your account details</p></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Name</div><div class="srow-desc" id="s-name-val">—</div></div>
          <div class="srow-right"><button class="btn btn-ghost btn-sm" onclick="openEditName()">Edit</button></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Email</div><div class="srow-desc" id="s-email-val">—</div></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Password</div><div class="srow-desc">Change your login password</div></div>
          <div class="srow-right"><button class="btn btn-ghost btn-sm" onclick="openChangePw()">Change</button></div>
        </div>
      </div>

      <!-- Default style -->
      <div class="scard">
        <div class="scard-head">
          <div class="scard-head-icon">🎨</div>
          <div><h3>Default Style</h3><p>Applied when you open the generator</p></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Template</div></div>
          <div class="srow-right">
            <select class="fsel" id="s-tmpl" style="width:130px" onchange="savePrefs()">
              <option value="classic">Classic</option><option value="rounded">Rounded</option>
              <option value="sharp">Sharp</option><option value="shadow">Shadow</option>
              <option value="bordered">Bordered</option><option value="elegant">Elegant</option>
            </select>
          </div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Size</div></div>
          <div class="srow-right">
            <select class="fsel" id="s-size" style="width:130px" onchange="savePrefs()">
              <option value="200">200 px</option><option value="300" selected>300 px</option>
              <option value="400">400 px</option><option value="500">500 px</option><option value="600">600 px</option>
            </select>
          </div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">PDF</div></div>
          <div class="srow-right">
            <select class="fsel" id="s-pdf" style="width:130px" onchange="savePrefs()">
               <option value="a4" class="selected">A4 (210 × 297 mm)</option>
              <option value="letter">Letter (216 × 279 mm)</option>
              <option value="square">Square (same as QR)</option>
            </select>
          </div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">PDF position on page</div></div>
          <div class="srow-right">
            <select class="fsel" id="s-pdf-pos" style="width:130px" onchange="savePrefs()">
               <option value="center">Centre</option>
              <option value="topleft">Top left</option>
            </select>
          </div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Error correction</div></div>
          <div class="srow-right">
            <select class="fsel" id="s-ecc" style="width:130px" onchange="savePrefs()">
              <option value="L">L — 7%</option><option value="M" selected>M — 15%</option>
              <option value="Q">Q — 25%</option><option value="H">H — 30%</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Appearance -->
      <div class="scard">
        <div class="scard-head">
          <div class="scard-head-icon">🌓</div>
          <div><h3>Appearance</h3><p>Interface preferences</p></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Show colour presets</div><div class="srow-desc">Palette dots in the Design tab</div></div>
          <div class="srow-right">
            <label class="toggle"><input type="checkbox" id="s-presets" checked onchange="savePrefs()"><div class="ttrack"></div><div class="tthumb"></div></label>
          </div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Auto-switch to Design tab</div><div class="srow-desc">Jump to Design after typing content</div></div>
          <div class="srow-right">
            <label class="toggle"><input type="checkbox" id="s-autodesign" onchange="savePrefs()"><div class="ttrack"></div><div class="tthumb"></div></label>
          </div>
        </div>
      </div>

      <!-- Danger -->
      <div class="scard scard-danger">
        <div class="scard-head">
          <div class="scard-head-icon">⚠️</div>
          <div><h3>Danger Zone</h3><p>Irreversible actions</p></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Delete all QR codes</div><div class="srow-desc">Permanently clears your entire library</div></div>
          <div class="srow-right"><button class="btn btn-danger btn-sm" onclick="confirmDeleteAll()">Delete all</button></div>
        </div>
        <div class="srow">
          <div class="srow-left"><div class="srow-label">Sign out</div><div class="srow-desc">Sign out on this device</div></div>
          <div class="srow-right"><button class="btn btn-ghost btn-sm" onclick="doLogout()">Sign out</button></div>
        </div>
      </div>

    </div><!-- /settings-logged -->
  </div>
</div>


<!-- ABOUT -->
<div class="page" id="page-about">
  <div class="about-wrap">

    <!-- Hero -->
    <div class="about-hero">
      <div>
        <div class="about-section-label">Open Source Project</div>
        <h1>Generate QR codes<br>that look <em>great</em></h1>
        <p><?= $appName?>  is a self-hosted QR code platform built with PHP and vanilla JavaScript. Custom colours, logo branding, beautiful templates, and a personal library — all running on a single PHP file with zero database setup.</p>
        <div class="about-badges">
          <span class="badge"><span class="badge-dot"></span>PHP 7.4+</span>
          <span class="badge"><span class="badge-dot"></span>SQLite · Zero Config</span>
          <span class="badge"><span class="badge-dot"></span>No Framework</span>
          <span class="badge"><span class="badge-dot"></span>Self-Hosted</span>
        </div>
      </div>
      <div class="about-qr-deco">
        <svg viewBox="0 0 18 18" width="72" height="72" fill="none">
          <rect x="1" y="1" width="6" height="6" rx="1.2" fill="white"/>
          <rect x="10" y="1" width="6" height="6" rx="1.2" fill="white"/>
          <rect x="1" y="10" width="6" height="6" rx="1.2" fill="white"/>
          <rect x="11" y="11" width="2.5" height="2.5" rx=".4" fill="#d4500a"/>
          <rect x="14.5" y="11" width="1.8" height="1.8" rx=".4" fill="white"/>
          <rect x="11" y="14.5" width="1.8" height="1.8" rx=".4" fill="white"/>
          <rect x="14" y="14" width="2.2" height="2.2" rx=".4" fill="white"/>
        </svg>
      </div>
    </div>

    <!-- Overview -->
    <div class="about-section">
      <div class="about-section-label">Overview</div>
      <h2>What is <?= $appName?> ?</h2>
      <p><?= $appName?>  is a full-stack web application for generating, customising, and exporting branded QR codes. It was built to prove that a useful, polished tool doesn't require heavy dependencies — the entire backend is plain PHP with an SQLite database that creates itself on first run.</p>
      <p>Drop it onto any shared hosting environment and it works immediately. No Node.js, no Docker, no environment configuration. Registered users get a personal library to save and manage their codes over time, while guests can generate and export freely without signing up.</p>
    </div>

    <hr class="about-divider">

    <!-- Features -->
    <div class="about-section">
      <div class="about-section-label">Features</div>
      <h2>Everything you need for great QR codes</h2>
      <div class="feat-grid">
        <div class="feat-card">
          <div class="feat-icon">🎨</div>
          <h3>Design Controls</h3>
          <p>6 templates, 8 colour presets, custom FG/BG colour pickers, and adjustable quiet zone padding.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">🖼️</div>
          <h3>Logo Overlay</h3>
          <p>Upload PNG, SVG, or JPG. Configurable size and background style (white circle, match QR, or transparent).</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">📐</div>
          <h3>Output Resolution</h3>
          <p>Set output size from 100px to 2000px. Preview scales proportionally. Built for screens and print.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">📤</div>
          <h3>Export Formats</h3>
          <p>Download as PNG, SVG (vector wrapper), or PDF. Open a full-screen print preview with one click.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">🔗</div>
          <h3>Content Types</h3>
          <p>URL, email, phone, SMS, WiFi credentials, and freeform text — each with contextual placeholder hints.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">📚</div>
          <h3>Saved Library</h3>
          <p>Registered users can save, browse, download, and delete their QR codes from a personal library.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">⚡</div>
          <h3>Live Preview</h3>
          <p>Debounced 300ms live preview updates as you type. Canvas-based rendering composites logo and padding seamlessly.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon">🔒</div>
          <h3>Security</h3>
          <p>Apache .htaccess blocks dotfiles, hotlinking, path traversal, and SQL injection. Security headers on every response.</p>
        </div>
      </div>
    </div>

    <hr class="about-divider">

    <!-- Stack -->
    <div class="about-section">
      <div class="about-section-label">Technical Stack</div>
      <h2>Built with simplicity in mind</h2>
      <p style="margin-bottom:22px">The architecture prioritises portability. The entire backend is standard PHP — no Composer dependencies, no autoloaders. The frontend uses vanilla JS with hash-based SPA routing, so there's no build step.</p>
      <table class="stack-table">
        <thead><tr><th>Layer</th><th>Technology</th></tr></thead>
        <tbody>
          <tr><td>Backend</td><td>PHP 7.4+ (plain PHP, no framework)</td></tr>
          <tr><td>Database</td><td>SQLite via PDO — auto-created, zero config</td></tr>
          <tr><td>Frontend</td><td>Vanilla JavaScript — no frameworks or build tools</td></tr>
          <tr><td>Rendering</td><td>HTML5 Canvas for compositing, preview, and all exports</td></tr>
          <tr><td>QR Engine</td><td>api.qrserver.com via PHP cURL proxy</td></tr>
          <tr><td>Auth</td><td>bcrypt passwords + PHP sessions</td></tr>
          <tr><td>Fonts</td><td>Fraunces (display) + Plus Jakarta Sans via Google Fonts</td></tr>
          <tr><td>Server Config</td><td>Apache .htaccess — security, hotlink protection, headers</td></tr>
        </tbody>
      </table>
    </div>

    <hr class="about-divider">

    <!-- Architecture note -->
    <div class="about-section">
      <div class="about-section-label">Architecture</div>
      <h2>How it works</h2>
      <p> <?= $appName?> is a single-page app driven by hash-based routing with no page reloads. The PHP layer handles authentication, database access, and acts as a proxy for the external QR API, keeping API calls server-side and avoiding browser CORS issues entirely.</p>
      <p>Canvas rendering is used throughout for compositing. The live preview, logo overlay, and all export formats — PNG, SVG, PDF, and print — are built from the same <code style="font-size:13px;background:var(--bg);padding:1px 6px;border-radius:4px;font-family:monospace">buildFullCanvas()</code> pipeline, ensuring pixel-perfect consistency between what you see and what you download.</p>
      <p>User preferences (default template, size, ECC level) are persisted to <code style="font-size:13px;background:var(--bg);padding:1px 6px;border-radius:4px;font-family:monospace">localStorage</code> and applied on load, so returning users get their setup restored immediately without a database round-trip.</p>
    </div>

  </div>
</div>

<div id="print-frame" style="display:none;position:fixed;inset:0;z-index:9999;background:#fff;align-items:center;justify-content:center;flex-direction:column;gap:20px">
  <canvas id="print-canvas"></canvas>
  <button onclick="window.print()" style="font-family:var(--fb);font-size:14px;padding:10px 24px;background:var(--ink);color:#fff;border:none;border-radius:var(--r);cursor:pointer" class="no-print">🖨️ Print</button>
  <button onclick="closePrint()" style="font-family:var(--fb);font-size:13px;padding:8px 18px;background:transparent;color:var(--ink2);border:1px solid var(--border);border-radius:var(--r);cursor:pointer;margin-top:-8px" class="no-print">Cancel</button>
</div>

<?php require_once(__DIR__.'/layouts/footer.php'); ?>
