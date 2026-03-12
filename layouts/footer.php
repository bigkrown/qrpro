
<footer style="position:relative;z-index:1;border-top:1px solid var(--border);padding:16px 28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px">
  <span style="font-size:12px;color:var(--ink3)">© <?= date('Y') ?> <?= htmlspecialchars($appName) ?></span>
  <span style="font-size:12px;color:var(--ink3)">Crafted by <strong style="color:var(--ink2);font-weight:600">Shola Adewale</strong> · PHP · SQLite · Vanilla JS</span>
</footer>
<script>
  /* ── State ── */
  const APP = {
  user: <?= $userJson ?>,
  s: { content:'', size:300, fg:'000000', bg:'ffffff', ecc:'M', tmpl:'classic',
       logoDataUrl:null, logoSize:20, t:null },
  prefs: {}
};
</script>
<!-- include JS files -->
<script src="assets/js/qrmaker.js"></script>
</body>
</html>