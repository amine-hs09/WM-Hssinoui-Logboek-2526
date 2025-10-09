// concerts.js 
const apiConcerts =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php";
const apiTickets =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php";
const apiVisitors =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";
const concertList = document.getElementById("concertList");
const form = document.getElementById("concertForm");
let editConcertId = null;

// hier zijn de concert functies 
const purchaseModal = document.getElementById("purchaseModal");
const purchaseVisitor = document.getElementById("purchaseVisitor");
const purchaseQty = document.getElementById("purchaseQty");
const purchaseBuy = document.getElementById("purchaseBuy");
const purchaseClose = document.getElementById("purchaseClose");
const purchaseConcertTitle = document.getElementById("purchaseConcertTitle");
let currentPurchaseConcertId = null;



async function loadConcerts() {
  if (!concertList) return;
  concertList.innerHTML = '<p class="loading">⏳het concert is aan het laden .</p>';
  try { // try de concerten laden
  const json = await apiFetch(apiConcerts);
    concertList.innerHTML = "";// met innerHTML leeg maken
    if (!json || !Array.isArray(json.data) || json.data.length === 0) {
      concertList.innerHTML = '<p class="muted"> er zijn geen concerten gevonden </p>';
      return;
    }
// voor elke concert dat gemaakt is maak een card 
    json.data.forEach((c) => {
        // constant voor elke gemaakt concert
      const card = document.createElement("div");
      card.className = "card";
// wat is thumb ?
// een thumbnail voor het concert hier komt elle info van le concert
//op de card 
      const thumb = document.createElement("div");
      thumb.className = "thumb";
      const initials = (c.artist || "🎵")
        .split(" ")
        .map((s) => s[0])
        .slice(0, 2)
        .join("")
        .toUpperCase();
      thumb.textContent = initials;
// dit zijn de detals van le concert in u card 
      const body = document.createElement("div");
      body.className = "body";
      body.innerHTML = `
        <h3>${c.artist}</h3>
        <p>📅 ${c.date} </p>
        <p>⏰ ${c.time}</p>
        <p>📍 ${c.venue}</p>
        <p>💰 <strong>€${parseFloat(c.price || 0).toFixed(2)}</strong> </p>`;

      // hier kan een concert kopen via de concerten die beschikbaar zijn 
      const buyBtn = document.createElement("button");
      buyBtn.type = "button";
      buyBtn.className = "primary";
      buyBtn.textContent = "Koop";
      buyBtn.addEventListener("click", () => openPurchaseModal(c));

      // als ik op edit knop kan ik de concert aanpassen 
      const editBtn = document.createElement("button");
      editBtn.type = "button";
      editBtn.className = "btn-edit";
      editBtn.textContent = "Edit";
      editBtn.addEventListener("click", () => {
        // wat zal er gebeuren als ik op edit knop druk
        // deze data moet je verander 
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

      // hier is de button om een concert te verwijden 
      const delBtn = document.createElement("button");
      delBtn.type = "button";
      delBtn.className = "btn-delete";
      delBtn.textContent = "Verwijder";
      delBtn.addEventListener("click", async () => {
        if (!confirm("ben je zeker?")) // bericjht om te bevestigen
          return;
        try {
          const json = await apiFetch(apiConcerts, {
            method: "DELETE",
            body: JSON.stringify({ id: c.id }), // id van concert wordt verwijdert 
          });
          if (typeof showToast === "function") // toast bericht is verwijdert 
            showToast(json.message || "Verwijderd", "success");
          else alert(json.message || "deleted ");
          loadConcerts();
        } catch (e) {
          console.error(e);
          if (typeof showToast === "function")
            showToast("kan niet verwijdert worden", "error");
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
    concertList.innerHTML = `<p class="error">er is een fout voor laden van concerten bekijk je api </p>`;
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
      json = await apiFetch(apiConcerts, {
        method: "PUT",
        body: JSON.stringify(body),
      });
      if (typeof showToast === "function")
        showToast(json.message || "Concert bijgewerkt", "success");
      else alert(json.message || "Concert bijgewerkt");
      editConcertId = null;
      if (submitBtn) submitBtn.textContent = "Concert Toevoegen";
    } else {
      json = await apiFetch(apiConcerts, {
        method: "POST",
        body: JSON.stringify(body),
      });
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
  const json = await apiFetch(apiVisitors);
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
    const json = await apiFetch(apiTickets, {
      method: "POST",
      body: JSON.stringify({
        visitor_id: visitorId,
        concert_id: currentPurchaseConcertId,
        qty,
      }),
    });
    if (typeof showToast === "function")
      showToast(json.message || "Ticket gekocht", "success");
    purchaseModal.setAttribute("aria-hidden", "true");
  } catch (e) {
    console.error(e);
    if (typeof showToast === "function") showToast("Kon niet kopen", "error");
  }
});
// purchase flow removed from concerts page
