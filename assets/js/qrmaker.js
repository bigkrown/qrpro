const TMPLS = [
  { id: "classic", label: "Classic", fr: "fr-classic", tp: "tp-classic" },
  { id: "rounded", label: "Rounded", fr: "fr-rounded", tp: "tp-rounded" },
  { id: "sharp", label: "Sharp", fr: "fr-sharp", tp: "tp-sharp" },
  { id: "shadow", label: "Shadow", fr: "fr-shadow", tp: "tp-shadow" },
  { id: "bordered", label: "Bordered", fr: "fr-bordered", tp: "tp-bordered" },
  { id: "elegant", label: "Elegant", fr: "fr-elegant", tp: "tp-elegant" },
];
const PAIRS = [
  { n: "Classic", fg: "000000", bg: "ffffff" },
  { n: "Charcoal", fg: "1a1814", bg: "f5f3ef" },
  { n: "Rust", fg: "d4500a", bg: "fff5f0" },
  { n: "Navy", fg: "1e3a5f", bg: "f0f4ff" },
  { n: "Forest", fg: "14532d", bg: "f0fdf4" },
  { n: "Plum", fg: "4a1942", bg: "fdf2f8" },
  { n: "Night", fg: "e2e8f0", bg: "0f172a" },
  { n: "Amber", fg: "92400e", bg: "fffbeb" },
];
const ECC_LBL = {
  L: "7% data recovery",
  M: "15% data recovery",
  Q: "25% data recovery",
  H: "30% data recovery",
};

/* ── Boot ── */
document.addEventListener("DOMContentLoaded", () => {
  loadPrefs();
  buildTmpls();
  buildPairs();
  renderNav();
  wireInputs();
  document.getElementById("modal-bg").addEventListener("click", (e) => {
    if (e.target === document.getElementById("modal-bg")) closeModal();
  });
  go(location.hash.replace("#", "") || "home", true);
  setTimeout(() => {
    const l = document.getElementById("loader");
    l.classList.add("gone");
    setTimeout(() => l.remove(), 300);
  }, 200);
});

/* ── Routing ── */
function go(page, noHash) {
  if (page === "saved" && !APP.user) {
    go("login");
    return;
  }
  if (page === "settings") renderSettings();
  document
    .querySelectorAll(".page")
    .forEach((p) => p.classList.remove("active"));
  const el = document.getElementById("page-" + page);
  if (!el) return;
  el.classList.add("active");
  window.scrollTo(0, 0);
  if (!noHash) location.hash = page;
  if (page === "saved") loadSaved();
  if (page === "generate") updateHint();
}

function renderNav(){
  const r=document.getElementById('nav-right');
  if(APP.user){
    r.innerHTML=`
      <button class="btn btn-ghost btn-sm" onclick="go('generate')">Create</button>
      <button class="btn btn-ghost btn-sm" onclick="go('saved')">My QR Codes</button>
      <button class="btn btn-ghost btn-sm btn-icon" title="Settings" onclick="go('settings')" style="font-size:10px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8" width="18" height="18" fill="#000000" style="opacity:1;"><path  d="M3.5 0L3 1.19c-.1.03-.19.08-.28.13L1.53.82l-.72.72l.5 1.19c-.05.1-.09.18-.13.28l-1.19.5v1l1.19.5c.04.1.08.18.13.28l-.5 1.19l.72.72l1.19-.5c.09.04.18.09.28.13l.5 1.19h1L5 6.83c.09-.04.19-.08.28-.13l1.19.5l.72-.72l-.5-1.19c.04-.09.09-.19.13-.28l1.19-.5v-1l-1.19-.5c-.03-.09-.08-.19-.13-.28l.5-1.19l-.72-.72l-1.19.5c-.09-.04-.19-.09-.28-.13L4.5 0zM4 2.5c.83 0 1.5.67 1.5 1.5S4.83 5.5 4 5.5S2.5 4.83 2.5 4S3.17 2.5 4 2.5"/></svg></button>
      <div class="avatar">${h(APP.user.name[0].toUpperCase())}</div>`;
  } else {
    r.innerHTML=`
      <button class="btn btn-ghost btn-sm" onclick="go('login')">Sign in</button>
      <button class="btn btn-ink btn-sm" onclick="go('register')">Get started</button>`;
  }
}

/* ── Mini QR thumbnail SVG ── */
function miniQR(fg, bg) {
  fg = fg || "#1a1814";
  bg = bg || "#ffffff";
  return `<svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" shape-rendering="crispEdges">
  <rect width="40" height="40" fill="${bg}"/>
  <rect x="2" y="2" width="11" height="11" rx="1.5" fill="${fg}"/><rect x="3.5" y="3.5" width="8" height="8" rx="1" fill="${bg}"/><rect x="5" y="5" width="5" height="5" rx=".5" fill="${fg}"/>
  <rect x="27" y="2" width="11" height="11" rx="1.5" fill="${fg}"/><rect x="28.5" y="3.5" width="8" height="8" rx="1" fill="${bg}"/><rect x="30" y="5" width="5" height="5" rx=".5" fill="${fg}"/>
  <rect x="2" y="27" width="11" height="11" rx="1.5" fill="${fg}"/><rect x="3.5" y="28.5" width="8" height="8" rx="1" fill="${bg}"/><rect x="5" y="30" width="5" height="5" rx=".5" fill="${fg}"/>
  <rect x="15" y="2" width="3" height="3" fill="${fg}"/><rect x="19" y="2" width="2" height="2" fill="${fg}"/><rect x="22" y="3" width="3" height="2" fill="${fg}"/>
  <rect x="15" y="6" width="2" height="3" fill="${fg}"/><rect x="19" y="7" width="4" height="2" fill="${fg}"/><rect x="15" y="11" width="3" height="2" fill="${fg}"/><rect x="20" y="10" width="2" height="3" fill="${fg}"/>
  <rect x="2" y="15" width="2" height="3" fill="${fg}"/><rect x="6" y="15" width="3" height="2" fill="${fg}"/><rect x="11" y="16" width="2" height="3" fill="${fg}"/>
  <rect x="2" y="20" width="3" height="2" fill="${fg}"/><rect x="7" y="20" width="2" height="3" fill="${fg}"/><rect x="11" y="21" width="3" height="2" fill="${fg}"/>
  <rect x="15" y="15" width="3" height="3" fill="${fg}"/><rect x="20" y="15" width="2" height="2" fill="${fg}"/><rect x="24" y="16" width="3" height="2" fill="${fg}"/>
  <rect x="15" y="20" width="2" height="3" fill="${fg}"/><rect x="19" y="21" width="4" height="2" fill="${fg}"/>
  <rect x="27" y="15" width="3" height="2" fill="${fg}"/><rect x="32" y="15" width="3" height="3" fill="${fg}"/>
  <rect x="27" y="19" width="2" height="3" fill="${fg}"/><rect x="31" y="20" width="3" height="2" fill="${fg}"/><rect x="36" y="19" width="2" height="3" fill="${fg}"/>
  <rect x="15" y="27" width="3" height="2" fill="${fg}"/><rect x="20" y="27" width="2" height="3" fill="${fg}"/><rect x="24" y="28" width="3" height="2" fill="${fg}"/>
  <rect x="15" y="32" width="2" height="3" fill="${fg}"/><rect x="19" y="33" width="4" height="2" fill="${fg}"/>
  <rect x="27" y="27" width="3" height="3" fill="${fg}"/><rect x="32" y="28" width="2" height="2" fill="${fg}"/><rect x="35" y="27" width="3" height="2" fill="${fg}"/>
  <rect x="27" y="32" width="2" height="3" fill="${fg}"/><rect x="31" y="33" width="4" height="2" fill="${fg}"/><rect x="36" y="32" width="2" height="3" fill="${fg}"/>
  </svg>`;
}

function syncTmplThumbs() {
  document.querySelectorAll(".tmpl-prev-inner").forEach((el) => {
    el.innerHTML = miniQR("#" + APP.s.fg, "#" + APP.s.bg);
  });
}

function buildTmpls() {
  document.getElementById("tmpl-grid").innerHTML = TMPLS.map(
    (t, i) => `
    <button class="tmpl ${i === 0 ? "active" : ""} ${t.tp}" onclick="setTmpl(this,'${t.id}','${t.fr}')">
      <div class="tmpl-prev"><div class="tmpl-prev-inner">${miniQR()}</div></div>
      <span class="tmpl-name">${t.label}</span>
    </button>`,
  ).join("");
}

function buildPairs() {
  document.getElementById("cdots").innerHTML = PAIRS.map((p, i) => {
    const s = `background:linear-gradient(135deg,#${p.fg} 50%,#${p.bg} 50%)`;
    return `<div class="cdot ${i === 0 ? "active" : ""}" title="${p.n}" data-fg="${p.fg}" data-bg="${p.bg}" data-n="${p.n}" style="${s}" onclick="setPair(this)"></div>`;
  }).join("");
}

function IsQRGenerated() {
  if(!APP.s.content.trim()) {
    toast("Please enter content to generate QR code.", true);
    return false;
  }
  return true;

}

/* ── Wire inputs ── */
function wireInputs() {
  // content
  document.getElementById("qr-content").addEventListener("input", function () {
    APP.s.content = this.value;
    document.getElementById("char-ct").textContent = this.value.length
      ? this.value.length + " chars"
      : "";
    if (APP.prefs.autoDesign && this.value.length === 1 && this.value.length>10) {
      const designTab = document.querySelector(".ptab:nth-child(2)");
      if (designTab) switchTab(designTab, "td");
    }
    schedule();
  });
  

  // size slider
  document.getElementById("qr-size").addEventListener("input", function () {
    IsQRGenerated();
    APP.s.size = +this.value;
    document.getElementById("qr-size-num").value = this.value;
    document.getElementById("size-lbl").textContent =this.value + " × " + this.value + " px";
    schedule();
  });

  //padding slider
  // document.getElementById("qr-padding").addEventListener("input", function () {
  //   IsQRGenerated();
  //   APP.s.padding = +this.value;
  //   document.getElementById("qr-padding-num").value = this.value;
  //   document.getElementById("padding-lbl").textContent = this.value + " px";
  //   schedule();
  // });

  // logo size slider
  document
    .getElementById("logo-size-slider")
    .addEventListener("input", function () {
      IsQRGenerated();
      APP.s.logoSize = +this.value;
      document.getElementById("logo-size-lbl").textContent = this.value + "%";
      schedule();
    });

  // FG colour picker
  const fgPicker = document.getElementById("fg-picker");
  const fgHex = document.getElementById("fg-hex");
  fgPicker.addEventListener("input", () => {
    IsQRGenerated();
    const v = fgPicker.value.replace("#", "");
    fgHex.value = v.toUpperCase();
    document.getElementById("fg-face").style.background = "#" + v;
    APP.s.fg = v;
    syncTmplThumbs();
    schedule();
  });
  fgHex.addEventListener("input", () => {
    const v = fgHex.value.replace(/[^0-9a-fA-F]/g, "").slice(0, 6);
    fgHex.value = v;
    if (v.length === 6) {
      IsQRGenerated();
      fgPicker.value = "#" + v;
      document.getElementById("fg-face").style.background = "#" + v;
      APP.s.fg = v;
      syncTmplThumbs();
      schedule();
    }
  });

  // BG colour picker
  const bgPicker = document.getElementById("bg-picker");
  const bgHex = document.getElementById("bg-hex");
  bgPicker.addEventListener("input", () => {
    IsQRGenerated();
    const v = bgPicker.value.replace("#", "");
    bgHex.value = v.toUpperCase();
    document.getElementById("bg-face").style.background = "#" + v;
    APP.s.bg = v;
    syncTmplThumbs();
    schedule();
  });
  bgHex.addEventListener("input", () => {
    const v = bgHex.value.replace(/[^0-9a-fA-F]/g, "").slice(0, 6);
    bgHex.value = v;
    if (v.length === 6) {
      IsQRGenerated();
      bgPicker.value = "#" + v;
      document.getElementById("bg-face").style.background = "#" + v;
      APP.s.bg = v;
      syncTmplThumbs();
      schedule();
    }
  });

  // Logo upload
  document.getElementById("logo-file").addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
      IsQRGenerated();
      APP.s.logoDataUrl = e.target.result;
      document.getElementById("logo-ph").classList.add("hidden");
      document.getElementById("logo-prev").classList.remove("hidden");
      document.getElementById("logo-prev-img").src = e.target.result;
      document.getElementById("logo-prev-name").textContent = file.name;
      document.getElementById("logo-drop").classList.add("has-logo");
      document.getElementById("logo-rm-btn").style.display = "";
      schedule();
    };
    reader.readAsDataURL(file);
  });

  // Keyboard submit
  document.addEventListener("keydown", (e) => {
    if (e.key !== "Enter") return;
    if (document.getElementById("page-login").classList.contains("active"))
      doLogin();
    if (document.getElementById("page-register").classList.contains("active"))
      doRegister();
  });
}

/* ── Setters ── */
function switchTab(btn, id) {
  document
    .querySelectorAll(".ptab")
    .forEach((b) => b.classList.remove("active"));
  document
    .querySelectorAll(".panel-body")
    .forEach((p) => p.classList.add("hidden"));
  if (btn) btn.classList.add("active");
  document.getElementById(id).classList.remove("hidden");
}
function setType(btn) {
  document
    .querySelectorAll(".tbtn")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
  document.getElementById("qr-content").placeholder = btn.dataset.ph;
  document.querySelector(".sample_output").textContent ="Sample: "+ btn.dataset.ph || "";
}
function setTmpl(btn, id, fr) {
  document
    .querySelectorAll(".tmpl")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
  APP.s.tmpl = id;
  document.getElementById("qr-box").className = "qr-box " + fr;
  schedule();
}
function setPair(dot) {
  document
    .querySelectorAll(".cdot")
    .forEach((d) => d.classList.remove("active"));
  dot.classList.add("active");
  APP.s.fg = dot.dataset.fg;
  APP.s.bg = dot.dataset.bg;
  document.getElementById("pair-name").textContent = dot.dataset.n;
  // sync pickers
  document.getElementById("fg-picker").value = "#" + APP.s.fg;
  document.getElementById("fg-hex").value = APP.s.fg.toUpperCase();
  document.getElementById("fg-face").style.background = "#" + APP.s.fg;
  document.getElementById("bg-picker").value = "#" + APP.s.bg;
  document.getElementById("bg-hex").value = APP.s.bg.toUpperCase();
  document.getElementById("bg-face").style.background = "#" + APP.s.bg;
  syncTmplThumbs();
  schedule();
}
function setEcc(btn) {
  document
    .querySelectorAll(".eccbtn")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
  APP.s.ecc = btn.dataset.e;
  document.getElementById("ecc-hint").textContent = ECC_LBL[btn.dataset.e];
  schedule();
}
function removeLogo(e) {
  e.stopPropagation();
  APP.s.logoDataUrl = null;
  document.getElementById("logo-ph").classList.remove("hidden");
  document.getElementById("logo-prev").classList.add("hidden");
  document.getElementById("logo-drop").classList.remove("has-logo");
  document.getElementById("logo-rm-btn").style.display = "none";
  document.getElementById("logo-file").value = "";
  schedule();
}

/* ── QR generation ── */
function schedule() {
  clearTimeout(APP.s.t);
  APP.s.t = setTimeout(generate, 300);
}

function generate() {
  const s = APP.s;
  const ph = document.getElementById("qr-ph"),
    sp = document.getElementById("qr-spin"),
    cv = document.getElementById("qr-canvas");
  
  const dl = document.getElementById("btn-dl");
  const ex=document.getElementById('btn-export');
  const svg =document.getElementById('ec-svg');
  const pdf = document.getElementById('ec-pdf');
  const prnt = document.getElementById('ec-print');
  const sv = document.getElementById("btn-save");
    
  if (!s.content.trim()) {
    ph.classList.remove("hidden");
    sp.classList.add("hidden");
    cv.classList.add("hidden");
    dl.disabled = true;
    sv.disabled = true;
    svg.disabled =true;
    pdf.disabled=true;
    prnt.disabled=true;
    document.getElementById("qr-meta").textContent = "";
    const b=document.getElementById('qr-size-badge');if(b)b.classList.add('hidden');
    return;
  }
  ph.classList.add("hidden");
  cv.classList.add("hidden");
  sp.classList.remove("hidden");
  const margin=document.getElementById('qr-margin')?document.getElementById('qr-margin').value:2;
 // const padding=document.getElementById('qr-padding-num')?document.getElementById('qr-padding-num').value:16;
  const url = `api/qr.php?action=proxy&data=${encodeURIComponent(s.content)}&size=${s.size}&fg=${s.fg}&bg=${s.bg}&ecc=${s.ecc}&margin=${margin}`;
  const qrImg = new Image();
  qrImg.crossOrigin = "anonymous";
  qrImg.onload = () => {
    cv.width = 230;
    cv.height = 230;
    const pad= 1;
    const ctx = cv.getContext("2d");
    ctx.drawImage(qrImg, 0, 0, 230, 230);
    const finish=()=>{
      sp.classList.add('hidden');cv.classList.remove('hidden');
      // Export & download enabled for everyone; save only for logged-in users
      dl.disabled=false; 
      //ex.disabled=false; 
      svg.disabled=false; 
      prnt.disabled=false; 
      pdf.disabled=false;
      if(APP.user) sv.disabled=false;
      const t=TMPLS.find(x=>x.id===s.tmpl)||TMPLS[0];
      const finalPx=document.getElementById('qr-size-num').value+pad*2;
      // Visually scale the qr-box: map 100px→130px display, 2000px→230px display
      const displayPx = Math.round(130 + (Math.min(s.size, 2000) - 100) / (2000 - 100) * 100);
      const box = document.getElementById('qr-box');
      box.style.width = displayPx + 'px';
      box.style.height = displayPx + 'px';
      // Update size badge
      const badge=document.getElementById('qr-size-badge');
      badge.textContent=finalPx+' × '+finalPx+' px';
      badge.classList.remove('hidden');
      document.getElementById('qr-meta').textContent=`${t.label} · ECC ${s.ecc}${pad>0?' · '+pad+'px padding':''}`;
    };
    if(s.logoDataUrl){
      const bgStyle=document.getElementById('logo-bg-style').value;
      const li=new Image();
      li.onload=()=>{
        const lw=qrRender*(s.logoSize/100);
        const lx=(cvSize-lw)/2, ly=(cvSize-lw)/2, circR=lw/2*1.28;
        if(bgStyle!=='none'){
          const fill=bgStyle==='white'?'#ffffff':'#'+s.bg;
          ctx.beginPath();ctx.arc(cvSize/2,cvSize/2,circR,0,Math.PI*2);
          ctx.fillStyle=fill;ctx.fill();
        }
        ctx.drawImage(li,lx,ly,lw,lw);finish();
      };
      li.onerror=finish;li.src=s.logoDataUrl;
    } else finish();
  };
  qrImg.onerror=()=>{sp.classList.add('hidden');ph.classList.remove('hidden');toast('Could not generate QR code. Check your content.',true);};
  qrImg.src=url;
}



/* ── Full-res canvas builder (used by download, export, print, save) ── */
function buildFullCanvas(cb){
  const s=APP.s;
  const margin=document.getElementById('qr-margin')?document.getElementById('qr-margin').value:2;
  const url=`api/qr.php?action=proxy&data=${encodeURIComponent(s.content)}&size=${s.size}&fg=${s.fg}&bg=${s.bg}&ecc=${s.ecc}&margin=${margin}`;
  const qrImg=new Image(); qrImg.crossOrigin='anonymous';
  qrImg.onload=()=>{
    const pad=1;
    const total=s.size+pad*2;
    const oc=document.createElement('canvas');
    oc.width=total; oc.height=total;
    const ctx=oc.getContext('2d');
    ctx.fillStyle='#'+s.bg;
    ctx.fillRect(0,0,total,total);
    ctx.drawImage(qrImg,pad,pad,s.size,s.size);
    const finish=()=>cb(oc);
    if(s.logoDataUrl){
      const bgStyle=document.getElementById('logo-bg-style').value;
      const li=new Image();
      li.onload=()=>{
        const lw=s.size*(s.logoSize/100);
        const lx=(total-lw)/2, ly=(total-lw)/2, circR=lw/2*1.28;
        if(bgStyle!=='none'){
          const fill=bgStyle==='white'?'#ffffff':'#'+s.bg;
          ctx.beginPath();ctx.arc(total/2,total/2,circR,0,Math.PI*2);
          ctx.fillStyle=fill;ctx.fill();
        }
        ctx.drawImage(li,lx,ly,lw,lw);finish();
      };
      li.onerror=finish; li.src=s.logoDataUrl;
    } else finish();
  };
  qrImg.onerror=()=>toast('Could not build QR image.',true);
  qrImg.src=url;
}

function downloadQR(){
  buildFullCanvas(oc=>{
    const a=document.createElement('a');
    a.download='qrcode.png';
    a.href=oc.toDataURL('image/png');
    a.click();
    toast('PNG downloaded ✓');
  });
}

function doExport(type='png'){
  if(type==='png')     exportPNG();
  else if(type==='svg') exportSVG();
  else if(type==='pdf') exportPDF();
  else if(type==='print') openPrint();
}

function exportPNG(){
  const expSize=parseInt(document.getElementById('exp-size').value)||APP.s.size;
  const origSize=APP.s.size;
  APP.s.size=expSize;
  buildFullCanvas(oc=>{
    APP.s.size=origSize;
    const a=document.createElement('a');a.download='qrcode.png';a.href=oc.toDataURL('image/png');a.click();
    toast('PNG exported ✓');
  });
}

function exportSVG(){
  buildFullCanvas(oc=>{
    const dataUrl=oc.toDataURL('image/png');
    const w=oc.width,h=oc.height;
    const svg=`<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="${w}" height="${h}" viewBox="0 0 ${w} ${h}">
  <title>QR Code</title>
  <image width="${w}" height="${h}" xlink:href="${dataUrl}"/>
</svg>`;
    const blob=new Blob([svg],{type:'image/svg+xml'});
    const a=document.createElement('a');a.download='qrcode.svg';a.href=URL.createObjectURL(blob);a.click();
    toast('SVG exported ✓');
  });
}

function exportPDF(){
  const page=document.getElementById('qr-pdf').value;
  const pos=document.getElementById('qr-pdf-pos').value;
  buildFullCanvas(oc=>{
    // page dimensions at 96dpi in px
    const pages={a4:[794,1123],letter:[816,1056],square:[oc.width,oc.height]};
    const [pw,ph]=pages[page];
    const qw=oc.width,qh=oc.height;
    let qx=0,qy=0;
    if(pos==='center'){qx=(pw-qw)/2;qy=(ph-qh)/2;}
    // Scale down if QR > page
    const scaleF=Math.min(1,Math.min((pw-40)/qw,(ph-40)/qh));
    const fw=qw*scaleF,fh=qh*scaleF;
    if(pos==='center'){qx=(pw-fw)/2;qy=(ph-fh)/2;}
    else{qx=20;qy=20;}

    const pdfCanvas=document.createElement('canvas');
    pdfCanvas.width=pw;pdfCanvas.height=ph;
    const ctx=pdfCanvas.getContext('2d');
    ctx.fillStyle='#ffffff';ctx.fillRect(0,0,pw,ph);
    ctx.drawImage(oc,qx,qy,fw,fh);

    const a=document.createElement('a');
    // Use data URI as PDF isn't directly constructable client-side without a lib
    // We create a printable HTML page instead and trigger browser Save as PDF
    const imgData=pdfCanvas.toDataURL('image/png');
    const html=`<!DOCTYPE html><html><head><meta charset="UTF-8">
<style>*{margin:0;padding:0;box-sizing:border-box}body{width:${pw}px;height:${ph}px;overflow:hidden}
img{width:${pw}px;height:${ph}px;display:block}
@page{size:${pw}px ${ph}px;margin:0}@media print{body{width:${pw}px;height:${ph}px}}</style>
</head><body><img  style="padding: 20px;" src="${imgData}"></body></html>`;
    const blob=new Blob([html],{type:'text/html'});
    const url=URL.createObjectURL(blob);
    const win=window.open(url,'_blank');
   // setTimeout(()=>{if(win)win.print();},600);
    toast('PDF has been generated ✓');
  });
}

function openPrint(){
  buildFullCanvas(oc=>{
    const pf=document.getElementById('print-frame');
    const pc=document.getElementById('print-canvas');
    // scale to fit screen nicely
    const maxSide=Math.min(window.innerWidth,window.innerHeight)*0.7;
    const scale=Math.min(1,maxSide/oc.width);
    pc.width=oc.width*scale;pc.height=oc.height*scale;
    pc.getContext('2d').drawImage(oc,0,0,pc.width,pc.height);
    pf.style.display='flex';
    document.body.style.overflow='hidden';
  });
}
function closePrint(){
  document.getElementById('print-frame').style.display='none';
  document.body.style.overflow='';
}


function downloadQR() {
  const s = APP.s;
  const url = `api/qr.php?action=proxy&data=${encodeURIComponent(s.content)}&size=${s.size}&fg=${s.fg}&bg=${s.bg}&ecc=${s.ecc}&margin=${s.margin}`;
  const qrImg = new Image();
  qrImg.crossOrigin = "anonymous";
  qrImg.onload = () => {
    const oc = document.createElement("canvas");
    oc.width = s.size;
    oc.height = s.size;
    const ctx = oc.getContext("2d");
    ctx.drawImage(qrImg, 0, 0, s.size, s.size);
    const finish = () => {
      const a = document.createElement("a");
      a.download = "qrcode.png";
      a.href = oc.toDataURL("image/png");
      a.click();
    };
    if (s.logoDataUrl) {
      const bgStyle = document.getElementById("logo-bg-style").value;
      const li = new Image();
      li.onload = () => {
        const lw = s.size * (s.logoSize / 100),
          lx = (s.size - lw) / 2,
          ly = (s.size - lw) / 2,
          pad = lw * 0.15;
        if (bgStyle !== "none") {
          const fill = bgStyle === "white" ? "#ffffff" : "#" + s.bg;
          ctx.beginPath();
          ctx.arc(s.size / 2, s.size / 2, lw / 2 + pad, 0, Math.PI * 2);
          ctx.fillStyle = fill;
          ctx.fill();
        }
        ctx.drawImage(li, lx, ly, lw, lw);
        finish();
      };
      li.onerror = finish;
      li.src = s.logoDataUrl;
    } else finish();
  };
  qrImg.src = url;
}

/* ── Save modal ── */
function openSave() {
  if (!APP.user) {
    go("login");
    return;
  }
  showModal(`
    <div class="modal-hd"><h3>Save QR Code</h3><button class="modal-close" onclick="closeModal()">×</button></div>
    <div style="display:flex;flex-direction:column;gap:14px">
      <div class="fg"><label class="fl">Label</label><input class="fi" id="save-lbl" placeholder="My Website, WiFi…"></div>
      <div style="background:var(--bg);border-radius:var(--r);padding:12px;font-size:12px;color:var(--ink2)">
        <div style="font-weight:600;color:var(--ink);margin-bottom:3px">Content</div>
        <div style="font-family:monospace;word-break:break-all">${h(APP.s.content)}</div>
      </div>
      <div id="save-err" class="alert alert-e hidden"></div>
      <button class="btn btn-accent btn-lg" onclick="doSave()" style="width:100%">Save to library</button>
    </div>`);
  setTimeout(() => document.getElementById("save-lbl").focus(), 80);
}
async function doSave() {
  const lbl = document.getElementById("save-lbl").value.trim() || "Untitled";
  const s = APP.s;
  const cv = document.getElementById("qr-canvas");
  const qrUrl = cv.toDataURL("image/png");
  const res = await api("api/qr.php?action=save", "POST", {
    label: lbl,
    content: s.content,
    template: s.tmpl,
    fg: "#" + s.fg,
    bg: "#" + s.bg,
    size: s.size,
    ecc: s.ecc,
    qr_url: qrUrl,
  });
  if (res.ok) {
    closeModal();
    toast("Saved ✓");
  } else {
    const e = document.getElementById("save-err");
    e.textContent = res.error || "Failed";
    e.classList.remove("hidden");
  }
}

/* ── Library ── */
async function loadSaved() {
  const g = document.getElementById("saved-grid");
  g.innerHTML =
    '<div style="padding:56px;text-align:center"><div class="spinner" style="margin:0 auto;width:26px;height:26px;border-width:3px"></div></div>';
  const res = await api("api/qr.php?action=list");
  if (!res.ok) return;
  document.getElementById("saved-count").textContent =
    res.data.length + " code" + (res.data.length !== 1 ? "s" : "") + " saved";
  if (!res.data.length) {
    g.innerHTML =
      '<div class="empty"><div class="empty-icon">📭</div><h3>No saved codes yet</h3><p>Create one and save it here</p><button class="btn btn-ink" style="margin-top:18px" onclick="go(\'generate\')">Create QR Code</button></div>';
    return;
  }
  g.innerHTML = res.data
    .map(
      (q) => `
    <div class="qrc">
      <img src="${h(q.qr_url)}" alt="${h(q.label)}" loading="lazy">
      <div class="qrc-body">
        <div class="qrc-label">${h(q.label)}</div>
        <div class="qrc-url">${h(q.content)}</div>
        <div class="qrc-foot">
          <span class="qrc-date">${fmtDate(q.created_at)}</span>
          <div class="qrc-acts">
            <a class="btn btn-ghost btn-sm btn-icon" href="${h(q.qr_url)}" download="qr-${q.id}.png" title="Download"><svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4.5-4.5 1.06-1.06L7 9.88V2h2v7.88l2.44-2.44 1.06 1.06L8 12zM2 14h12v-2H2v2z"/></svg></a>
            <button class="btn btn-ghost btn-sm btn-icon" onclick="confirmDel(${q.id})" style="color:var(--error)"><svg width="13" height="13" viewBox="0 0 16 16" fill="currentColor"><path d="M6 2h4v1H6V2zM2 4h12v1.5H3.5l.8 8.5h7.4l.8-8.5H14V4H2zm4 3h1v5H6V7zm3 0h1v5H9V7z"/></svg></button>
          </div>
        </div>
      </div>
    </div>`,
    )
    .join("");
}
function confirmDel(id) {
  showModal(
    `<div class="modal-hd"><h3>Delete?</h3><button class="modal-close" onclick="closeModal()">×</button></div><p style="font-size:14px;color:var(--ink2);margin-bottom:20px">This cannot be undone.</p><div style="display:flex;gap:9px"><button class="btn btn-ghost" style="flex:1" onclick="closeModal()">Cancel</button><button class="btn btn-ink" style="flex:1;background:var(--error)" onclick="doDel(${id})">Delete</button></div>`,
  );
}
async function doDel(id) {
  await api("api/qr.php?action=delete", "POST", { id });
  closeModal();
  toast("Deleted");
  loadSaved();
}

/* ── Auth ── */
async function doLogin() {
  const email = document.getElementById("l-email").value,
    pass = document.getElementById("l-pass").value;
  const err = document.getElementById("login-err"),
    btn = document.getElementById("l-btn");
  err.classList.add("hidden");
  btn.disabled = true;
  btn.textContent = "Signing in…";
  const res = await api("api/auth.php?action=login", "POST", {
    email,
    password: pass,
  });
  btn.disabled = false;
  btn.textContent = "Sign in";
  if (res.ok) {
    APP.user = res.user;
    renderNav();
    updateHint();
    toast("Welcome back, " + res.user.name.split(" ")[0] + "!");
    go("generate");
  } else {
    err.textContent = res.error;
    err.classList.remove("hidden");
  }
}
async function doRegister() {
  const name = document.getElementById("r-name").value,
    email = document.getElementById("r-email").value,
    pass = document.getElementById("r-pass").value;
  const err = document.getElementById("reg-err"),
    btn = document.getElementById("r-btn");
  err.classList.add("hidden");
  btn.disabled = true;
  btn.textContent = "Creating…";
  const res = await api("api/auth.php?action=register", "POST", {
    name,
    email,
    password: pass,
  });
  btn.disabled = false;
  btn.textContent = "Create account";
  if (res.ok) {
    APP.user = res.user;
    renderNav();
    updateHint();
    toast("Welcome, " + res.user.name.split(" ")[0] + " 🎉");
    go("generate");
  } else {
    err.textContent = res.error;
    err.classList.remove("hidden");
  }
}
async function doLogout() {
  await fetch("api/auth.php?action=logout");
  APP.user = null;
  renderNav();
  updateHint();
  go("home");
  toast("Signed out");
}
function updateHint() {
  const hint = document.getElementById("login-hint"),
    sv = document.getElementById("btn-save");
  if (APP.user) {
    hint.classList.add("hidden");
    const cv = document.getElementById("qr-canvas");
    if (!cv.classList.contains("hidden")) sv.disabled = false;
  } else {
    hint.classList.remove("hidden");
    sv.disabled = true;
  }
}

/* ── Settings ── */
function renderSettings() {
  if (APP.user) {
    document.getElementById("settings-guest").classList.add("hidden");
    document.getElementById("settings-logged").classList.remove("hidden");
    document.getElementById("s-name-val").textContent = APP.user.name;
    document.getElementById("s-email-val").textContent = APP.user.email;
  } else {
    document.getElementById("settings-guest").classList.remove("hidden");
    document.getElementById("settings-logged").classList.add("hidden");
  }
  const p = APP.prefs;
  if (p.tmpl) document.getElementById("s-tmpl").value = p.tmpl;
  if (p.size) document.getElementById("s-size").value = p.size;
  if (p.ecc) document.getElementById("s-ecc").value = p.ecc;
  document.getElementById("s-presets").checked = p.showPresets !== false;
  document.getElementById("s-autodesign").checked = !!p.autoDesign;
}
function savePrefs() {
  APP.prefs = {
    tmpl: document.getElementById("s-tmpl").value,
    size: document.getElementById("s-size").value,
    ecc: document.getElementById("s-ecc").value,
    pdf:  document.getElementById("s-pdf").value,
    pdfPos:  document.getElementById("s-pdf-pos").value,
    showPresets: document.getElementById("s-presets").checked,
    autoDesign: document.getElementById("s-autodesign").checked,
  };
  try {
    localStorage.setItem("qrmaker_pro_prefs", JSON.stringify(APP.prefs));
  } catch (e) {}
  toast("Preferences saved ✓");
}
function loadPrefs() {
  try {
    const r = localStorage.getItem("qrmaker_pro_prefs");
    if (r) APP.prefs = JSON.parse(r);
  } catch (e) {}
  if (APP.prefs.size) {
    APP.s.size = +APP.prefs.size;
    const sl = document.getElementById("qr-size");
    if (sl) {
      sl.value = APP.prefs.size;
      // document.getElementById("size-lbl").textContent =
      //   APP.prefs.size + " × " + APP.prefs.size + " px";
    }
  }
  if (APP.prefs.pdf) {
    APP.s.pdf = +APP.prefs.pdf;
    const pdfl = document.getElementById("qr-pdf");
    const pdfPosl = document.getElementById("qr-pdf-pos");
    if (pdfl) {
      pdfl.value = APP.prefs.pdf;
      pdfPosl.value = APP.prefs.pdfPos;
      // document.getElementById("size-lbl").textContent =
      //   APP.prefs.size + " × " + APP.prefs.size + " px";
    }
  }
  if (APP.prefs.ecc) {
    APP.s.ecc = APP.prefs.ecc;
    document
      .querySelectorAll(".eccbtn")
      .forEach((b) =>
        b.classList.toggle("active", b.dataset.e === APP.prefs.ecc),
      );
    const hint = document.getElementById("ecc-hint");
    if (hint) hint.textContent = ECC_LBL[APP.prefs.ecc];
  }
  if (APP.prefs.ecc) {
    APP.s.ecc = APP.prefs.ecc;
    document
      .querySelectorAll(".eccbtn")
      .forEach((b) =>
        b.classList.toggle("active", b.dataset.e === APP.prefs.ecc),
      );
    const hint = document.getElementById("ecc-hint");
    if (hint) hint.textContent = ECC_LBL[APP.prefs.ecc];
  }
}

function openEditName() {
  showModal(`
    <div class="modal-hd"><h3>Edit Name</h3><button class="modal-close" onclick="closeModal()">×</button></div>
    <div style="display:flex;flex-direction:column;gap:14px">
      <div class="fg"><label class="fl">Display name</label><input class="fi" id="edit-name-in" value="${h(APP.user.name)}"></div>
      <div id="edit-name-err" class="alert alert-e hidden"></div>
      <button class="btn btn-ink btn-lg" onclick="doEditName()" style="width:100%">Save</button>
    </div>`);
  setTimeout(() => document.getElementById("edit-name-in").focus(), 80);
}
async function doEditName() {
  const name = document.getElementById("edit-name-in").value.trim();
  const errEl = document.getElementById("edit-name-err");
  if (name.length < 2) {
    errEl.textContent = "Name too short";
    errEl.classList.remove("hidden");
    return;
  }
  const res = await api("api/auth.php?action=update_name", "POST", { name });
  if (res.ok) {
    APP.user.name = name;
    renderNav();
    renderSettings();
    closeModal();
    toast("Name updated ✓");
  } else {
    errEl.textContent = res.error || "Failed";
    errEl.classList.remove("hidden");
  }
}
function openChangePw() {
  showModal(`
    <div class="modal-hd"><h3>Change Password</h3><button class="modal-close" onclick="closeModal()">×</button></div>
    <div style="display:flex;flex-direction:column;gap:14px">
      <div class="fg"><label class="fl">Current password</label><input class="fi" type="password" id="pw-cur" placeholder="••••••••"></div>
      <div class="fg"><label class="fl">New password</label><input class="fi" type="password" id="pw-new" placeholder="Min. 6 characters"></div>
      <div class="fg"><label class="fl">Confirm new</label><input class="fi" type="password" id="pw-conf" placeholder="Repeat new password"></div>
      <div id="pw-err" class="alert alert-e hidden"></div>
      <button class="btn btn-ink btn-lg" onclick="doChangePw()" style="width:100%">Update password</button>
    </div>`);
}
async function doChangePw() {
  const cur = document.getElementById("pw-cur").value,
    nw = document.getElementById("pw-new").value,
    conf = document.getElementById("pw-conf").value;
  const errEl = document.getElementById("pw-err");
  if (nw.length < 6) {
    errEl.textContent = "Min. 6 characters";
    errEl.classList.remove("hidden");
    return;
  }
  if (nw !== conf) {
    errEl.textContent = "Passwords do not match";
    errEl.classList.remove("hidden");
    return;
  }
  const res = await api("api/auth.php?action=change_password", "POST", {
    current: cur,
    password: nw,
  });
  if (res.ok) {
    closeModal();
    toast("Password updated ✓");
  } else {
    errEl.textContent = res.error || "Failed";
    errEl.classList.remove("hidden");
  }
}
function confirmDeleteAll() {
  showModal(
    `<div class="modal-hd"><h3>Delete all QR codes?</h3><button class="modal-close" onclick="closeModal()">×</button></div><p style="font-size:14px;color:var(--ink2);margin-bottom:20px">Permanently deletes your entire library. Cannot be undone.</p><div style="display:flex;gap:9px"><button class="btn btn-ghost" style="flex:1" onclick="closeModal()">Cancel</button><button class="btn btn-danger" style="flex:1" onclick="doDeleteAll()">Delete all</button></div>`,
  );
}
async function doDeleteAll() {
  const res = await api("api/qr.php?action=delete_all", "POST", {});
  closeModal();
  if (res.ok) toast("All codes deleted");
  else toast("Failed", true);
}

/* ── Modal / Toast ── */
function showModal(html) {
  document.getElementById("modal").innerHTML = html;
  document.getElementById("modal-bg").classList.remove("hidden");
}
function closeModal() {
  document.getElementById("modal-bg").classList.add("hidden");
}
function toast(msg, isErr) {
  const t = document.createElement("div");
  t.className = "toast" + (isErr ? " err" : "");
  t.textContent = msg;
  document.getElementById("toasts").appendChild(t);
  setTimeout(() => {
    t.style.opacity = "0";
    t.style.transform = "translateY(8px)";
    t.style.transition = "all .2s";
    setTimeout(() => t.remove(), 220);
  }, 2600);
}

/* ── Helpers ── */
async function api(url, method, body) {
  try {
    const o = {
      method: method || "GET",
      headers: { "Content-Type": "application/json" },
    };
    if (body) o.body = JSON.stringify(body);
    return await (await fetch(url, o)).json();
  } catch (e) {
    return { ok: false, error: "Network error" };
  }
}
function h(s) {
  return String(s)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}
function fmtDate(s) {
  return new Date(s).toLocaleDateString("en-GB", {
    day: "numeric",
    month: "short",
    year: "numeric",
  });
}
