// 
const toastEl = document.getElementById("toast");
const themeToggleBtn = document.getElementById("themeToggle");
const loginBtn = document.getElementById("loginBtn");
const loginModal = document.getElementById("loginModal");
const loginClose = document.getElementById("loginClose");
const loginSubmit = document.getElementById("loginSubmit");
const loginName = document.getElementById("loginName");

function showToast(message, type = "") {
  if (!toastEl) return alert(message);
  toastEl.textContent = message;
  toastEl.className = "toast show " + (type || "");
  setTimeout(() => {
    toastEl.classList.remove("show");
  }, 3600);
}

function setTheme(dark) {
  if (dark) document.documentElement.classList.add("dark");
  else document.documentElement.classList.remove("dark");
  try {
    localStorage.setItem("prefersDark", dark ? "1" : "0");
  } catch (e) {}
}

// init theme
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

if (themeToggleBtn) {
  themeToggleBtn.addEventListener("click", () => {
    const dark = !document.documentElement.classList.contains("dark");
    setTheme(dark);
    showToast(dark ? "Donker thema ingeschakeld" : "Licht thema ingeschakeld");
  });
}

if (loginBtn) {
  loginBtn.addEventListener("click", () => {
    if (loginModal) {
      loginModal.setAttribute("aria-hidden", "false");
      loginName?.focus();
    }
  });
}
if (loginClose) {
  loginClose.addEventListener("click", () => {
    if (loginModal) loginModal.setAttribute("aria-hidden", "true");
  });
}
if (loginSubmit) {
  loginSubmit.addEventListener("click", () => {
    const name = (loginName?.value || "Gast").trim();
    if (loginModal) loginModal.setAttribute("aria-hidden", "true");
    showToast("Welkom, " + name + " 👋");
  });
}

// Humanize pages: set a last-updated timestamp in any .last-updated element
function setLastUpdated(){
  const els = document.querySelectorAll('.last-updated');
  if(!els || els.length===0) return;
  const now = new Date();
  const human = now.toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' });
  els.forEach(e=> e.textContent = 'Bijgewerkt: ' + human + ' — door Mohamed');
}

document.addEventListener('DOMContentLoaded', setLastUpdated);
