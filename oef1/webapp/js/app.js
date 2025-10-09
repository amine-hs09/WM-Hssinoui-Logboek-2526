// hier zijn de funcites van alle paginas 
const toastEl = document.getElementById("toast");
//hier is van stijl en thema donker/licht
const themeToggleBtn = document.getElementById("themeToggle");
// login button
const loginBtn = document.getElementById("loginBtn");
//login modal
const loginModal = document.getElementById("loginModal");
//sluiten van het login 
const loginClose = document.getElementById("loginClose");
const loginSubmit = document.getElementById("loginSubmit");
const loginName = document.getElementById("loginName");
// hier is de toast functie waneer de iets willen melden aan de gebruiker te tonen dat het gemaakt is of niet
function showToast(message, type = "") {
  if (!toastEl) return alert(message);
  toastEl.textContent = message;
  toastEl.className = "toast show " + (type || "");
  setTimeout(() => {
    toastEl.classList.remove("show");
  }, 3600);
}

//hier kan ik van donker naar nlicht thema en omgekeerd
function setTheme(dark) {
  if (dark) document.documentElement.classList.add("dark");
  else document.documentElement.classList.remove("dark");
  try {
    localStorage.setItem("prefersDark", dark ? "1" : "0");
  } catch (e) {}
}

// try dit is de basis van thema voorkeur van de gebruiker
try {
  const pref = localStorage.getItem("prefersDark");
  if (pref === null)
    setTheme(
      window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    );
  else setTheme(pref === "1");
} catch (e) {
  setTheme(false);
}
//als de gebruiker op de knop drukt dans verander le thema
if (themeToggleBtn) {
  themeToggleBtn.addEventListener("click", () => {
    const dark = !document.documentElement.classList.contains("dark");
    setTheme(dark);
    showToast(dark ? "Donker thema ingeschakeld" : "Licht thema ingeschakeld");
  });
}
// als de gebruiker op de login knop drukt
if (loginBtn) {
  loginBtn.addEventListener("click", () => {
    if (loginModal) {
      loginModal.setAttribute("aria-hidden", "false");
      //geef een focus op le login name
      loginName?.focus();
    }
  });
}
//als de gebruiker op sluiten knop drukt
if (loginClose) {
  loginClose.addEventListener("click", () => {
    if (loginModal) loginModal.setAttribute("aria-hidden", "true");
  });
}
//als de gebruiker submit knop drukt dans komt de toast bericht je ben ingelogd
if (loginSubmit) {
  loginSubmit.addEventListener("click", () => {
    const name = (loginName?.value || "Gast").trim();
    if (loginModal) loginModal.setAttribute("aria-hidden", "true");
    showToast("Welkom, " + name + "👋");
  });
}

async function apiFetch(url, options = {}) {
  const opts = Object.assign({
    headers: { 'Content-Type': 'application/json' }
  }, options || {});

  const res = await fetch(url, opts);
  let parsed = null;
  try {
    parsed = await res.json();
  } catch (e) {
    // not JSON
  }

  if (!res.ok) {
    const msg = (parsed && (parsed.message || parsed.data || parsed.status)) || res.statusText || 'Network error';
    const err = new Error(msg);
    err.response = parsed;
    err.status = res.status;
    throw err;
  }

  return parsed;
}

window.apiFetch = apiFetch;
