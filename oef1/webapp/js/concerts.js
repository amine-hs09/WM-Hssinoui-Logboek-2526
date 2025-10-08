const apiConcerts =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php";
const apiTickets =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php";
const apiVisitors =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";
const concertList = document.getElementById("concertList");
const form = document.getElementById("concertForm");
let editConcertId = null;


const purchaseModal = document.getElementById("purchaseModal");
const purchaseVisitor = document.getElementById("purchaseVisitor");
const purchaseQty = document.getElementById("purchaseQty");
const purchaseBuy = document.getElementById("purchaseBuy");
const purchaseClose = document.getElementById("purchaseClose");
const purchaseConcertTitle = document.getElementById("purchaseConcertTitle");
let currentPurchaseConcertId = null;



async function loadConcerts() {
  if (!concertList) return;
  concertList.innerHTML = '<p class="loading">⏳ Concerten laden...</p>';
  try {
    const res = await fetch(apiConcerts);
    if (!res.ok) throw new Error("Netwerkfout");
    const json = await res.json();
    concertList.innerHTML = "";
    if (!json || !Array.isArray(json.data) || json.data.length === 0) {
      concertList.innerHTML = '<p class="muted">Geen concerten gevonden.</p>';
      return;
    }

    json.data.forEach((c) => {
      const card = document.createElement("div");
      card.className = "card";

      const thumb = document.createElement("div");
      thumb.className = "thumb";
      const initials = (c.artist || "🎵")
        .split(" ")
        .map((s) => s[0])
        .slice(0, 2)
        .join("")
        .toUpperCase();
      thumb.textContent = initials;

      const body = document.createElement("div");
      body.className = "body";
      body.innerHTML = `
        <h3>${c.artist}</h3>
        <p>📅 ${c.date} – ⏰ ${c.time}</p>
        <p>📍 ${c.venue}</p>
        <p>💰 <strong>€${parseFloat(c.price || 0).toFixed(2)}</strong> </p>
      `;

      // add quick buy button (opens modal)
      const buyBtn = document.createElement("button");
      buyBtn.type = "button";
      buyBtn.className = "primary";
      buyBtn.textContent = "Koop";
      buyBtn.addEventListener("click", () => openPurchaseModal(c));

      // edit button
      const editBtn = document.createElement("button");
      editBtn.type = "button";
      editBtn.className = "btn-edit";
      editBtn.textContent = "Edit";
      editBtn.addEventListener("click", () => {
        // populate form for editing
        editConcertId = c.id;
        document.getElementById("artist").value = c.artist || "";
        document.getElementById("date").value = c.date || "";
        document.getElementById("time").value = c.time || "";
        document.getElementById("venue").value = c.venue || "";
        document.getElementById("price").value = c.price || "";
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.textContent = "Opslaan";
        window.scrollTo({ top: 0, behavior: "smooth" });
      });

      // delete button
      const delBtn = document.createElement("button");
      delBtn.type = "button";
      delBtn.className = "btn-delete";
      delBtn.textContent = "Verwijder";
      delBtn.addEventListener("click", async () => {
        if (!confirm("Weet je zeker dat je dit concert wilt verwijderen?"))
          return;
        try {
          const res = await fetch(apiConcerts, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: c.id }),
          });
          const json = await res.json();
          if (typeof showToast === "function")
            showToast(json.message || "Verwijderd", "success");
          else alert(json.message || "Verwijderd");
          loadConcerts();
        } catch (e) {
          console.error(e);
          if (typeof showToast === "function")
            showToast("Kon niet verwijderen", "error");
        }
      });

      card.appendChild(thumb);
      card.appendChild(body);
      const btnWrap = document.createElement("div");
      btnWrap.className = "card-actions";
      btnWrap.appendChild(buyBtn);
      btnWrap.appendChild(editBtn);
      btnWrap.appendChild(delBtn);
      card.appendChild(btnWrap);
      concertList.appendChild(card);
    });
  } catch (err) {
    concertList.innerHTML = `<p class="error">❌ Fout bij laden van concerten. Controleer de API of je internetverbinding.</p>`;
    console.error(err);
  }
}

form?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const body = {
    artist: document.getElementById("artist").value,
    date: document.getElementById("date").value,
    time: document.getElementById("time").value,
    venue: document.getElementById("venue").value,
    price: parseFloat(document.getElementById("price").value || 0),
  };

  try {
    let res, json;
    const submitBtn = form.querySelector('button[type="submit"]');
    if (editConcertId) {
      // update
      body.id = editConcertId;
      res = await fetch(apiConcerts, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(json.message || "Concert bijgewerkt", "success");
      else alert(json.message || "Concert bijgewerkt");
      editConcertId = null;
      if (submitBtn) submitBtn.textContent = "Concert Toevoegen";
    } else {
      res = await fetch(apiConcerts, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(json.message || "Concert toegevoegd", "success");
      else alert(json.message || "Concert toegevoegd");
    }
    form.reset();
    loadConcerts();
  } catch (err) {
    console.error(err);
    if (typeof showToast === "function")
      showToast("Kon concert niet toevoegen / bijwerken", "error");
    else alert("Kon concert niet toevoegen / bijwerken");
  }
});

loadConcerts();

async function openPurchaseModal(concert) {
  if (!purchaseModal) return;
  currentPurchaseConcertId = concert.id;
  purchaseConcertTitle.textContent = `${concert.artist} — ${concert.venue} (${concert.date})`;
  // fill visitors
  try {
    const res = await fetch(apiVisitors);
    const json = await res.json();
    purchaseVisitor.innerHTML = (json.data || [])
      .map(
        (v) => `<option value="${v.id}">${v.first_name} ${v.last_name}</option>`
      )
      .join("");
  } catch (e) {
    purchaseVisitor.innerHTML = '<option value="0">Geen bezoekers</option>';
  }
  purchaseQty.value = 1;
  purchaseModal.setAttribute("aria-hidden", "false");
}

purchaseClose?.addEventListener("click", () => {
  if (purchaseModal) purchaseModal.setAttribute("aria-hidden", "true");
});
purchaseBuy?.addEventListener("click", async () => {
  const visitorId = parseInt(purchaseVisitor.value || 0);
  const qty = parseInt(purchaseQty.value || 1);
  if (!currentPurchaseConcertId || !visitorId) {
    if (typeof showToast === "function") showToast("Selecteer bezoeker");
    return;
  }
  try {
    const res = await fetch(apiTickets, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        visitor_id: visitorId,
        concert_id: currentPurchaseConcertId,
        qty,
      }),
    });
    const json = await res.json();
    if (typeof showToast === "function")
      showToast(json.message || "Ticket gekocht", "success");
    purchaseModal.setAttribute("aria-hidden", "true");
  } catch (e) {
    console.error(e);
    if (typeof showToast === "function") showToast("Kon niet kopen", "error");
  }
});
// purchase flow removed from concerts page
