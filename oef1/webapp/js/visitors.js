const apiVisitors =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";
const visitorListContainer = document.getElementById("visitorList");

const visitorFormEl = document.getElementById("visitorForm");
let editVisitorId = null;
visitorFormEl?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const body = {
    first_name: document.getElementById("fname").value,
    last_name: document.getElementById("lname").value,
    birth_date: document.getElementById("birth").value,
    email: document.getElementById("mail").value,
  };

  try {
    let res, json;
    if (editVisitorId) {
      body.id = editVisitorId;
      res = await fetch(apiVisitors, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(json.message || "Bezoeker bijgewerkt", "success");
      else alert(json.message || "Bezoeker bijgewerkt");
      editVisitorId = null;
    } else {
      res = await fetch(apiVisitors, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(
          json.message ? "✅ " + json.message : "Bezoeker toegevoegd",
          "success"
        );
      else alert("✅ " + (json.message || "Bezoeker toegevoegd"));
    }
    e.target.reset();
    loadVisitors();
  } catch (err) {
    console.error(err);
    if (typeof showToast === "function") showToast("Kon niet opslaan", "error");
  }
});
// async functie load visitors 
// dit zorgt ervoor dat de bzoekers geladne worden 
// komen te voorschijn in de visitorListContainer
async function loadVisitors() {
  if (!visitorListContainer) return;
  visitorListContainer.innerHTML = "<p>⏳ Laden...</p>";
  const res = await fetch(apiVisitors);
  const json = await res.json();
  visitorListContainer.innerHTML = "";

  json.data.forEach((v) => {
    const card = document.createElement("div");
    card.className = "visitor-card";

    card.dataset.id = v.id;
    card.dataset.fname = v.first_name;
    card.dataset.lname = v.last_name;
    card.dataset.email = v.email;
    card.dataset.birth = v.birth_date;

    card.innerHTML = `
      <div class="visitor-info">
        <h3>${v.first_name} ${v.last_name}</h3>
        <p>${v.email || "-"}</p>
        <span>Geboren op: ${v.birth_date || "-"}</span>
      </div>
      <div class="visitor-actions">
        <button class="primary-outline" data-view="${v.id}">Bekijk</button>
        <button class="primary-outline" data-edit="${v.id}">Edit</button>
        <button class="primary-outline" data-delete="${v.id}">Delete</button>
      </div>
    `;
    visitorListContainer.appendChild(card);
  });
}

visitorListContainer.addEventListener("click", async (e) => {
    const target = e.target;
    const card = target.closest(".visitor-card");
    if (!card) return;

    const id = card.dataset.id;

    if (target.dataset.edit) {
      document.getElementById("fname").value = card.dataset.fname || "";
      document.getElementById("lname").value = card.dataset.lname || "";
      document.getElementById("mail").value = card.dataset.email || "";
      document.getElementById("birth").value = card.dataset.birth || "";
      editVisitorId = id;
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
// indien de delete knop wordt ingedrukt 

    if (target.dataset.delete) {
      if (!confirm("Weet je zeker dat je deze bezoeker wilt verwijderen?")) return;
      try {
        await fetch(apiVisitors, {
          method: "DELETE",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: parseInt(id) }),
        });
        // toon bericht ben je zeker 
        showToast("Verwijderd", "success");
        loadVisitors();
      } catch (err) {
        showToast("Kon niet verwijderen", "error");
      }
    }
// if api voor bezoekers
// toon de gegevens van de bezoekrs  
    if (target.dataset.view) {
      try {
        const res = await fetch(apiVisitors + "?id=" + encodeURIComponent(id));
        const json = await res.json();
        const info = json.data?.visitor || json.data;
        const tickets = json.data?.tickets || [];
        
        document.getElementById("visitorInfo").textContent = info ? `${info.first_name} ${info.last_name} — ${info.email || ""}` : "Geen data";
        document.getElementById("visitorConcerts").innerHTML =
            tickets.map(t => `<div class="card"><div class="body"><h4>${t.artist}</h4><p>${t.venue} — ${t.date}</p><p>Aantal: ${t.qty}</p></div></div>`).join("") || '<p class="muted">Geen tickets</p>';
        document.getElementById("visitorModal").setAttribute("aria-hidden", "false");
      } catch (err) {
        showToast("Kon bezoeker niet laden", "error");
      }
    }
  });

document.getElementById("visitorClose")?.addEventListener("click", () => {
  document.getElementById("visitorModal").setAttribute("aria-hidden", "true");
});

loadVisitors();