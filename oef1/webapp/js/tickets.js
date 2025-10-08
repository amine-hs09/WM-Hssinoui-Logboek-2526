const apiTickets =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php";
const apiConcerts =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php";
const apiVisitors =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";

const ticketList = document.getElementById("ticketList");
// debug removed: rawJson panel deleted
const visitorSelect = document.getElementById("visitorSelect");
const concertSelect = document.getElementById("concertSelect");

async function fillSelects() {
  try {
    const [visitors, concerts] = await Promise.all([
      fetch(apiVisitors).then((r) => r.json()),
      fetch(apiConcerts).then((r) => r.json()),
    ]);

    if (visitorSelect)
      visitorSelect.innerHTML = (visitors.data || [])
        .map(
          (v) =>
            `<option value="${v.id}">${v.first_name} ${v.last_name} (${v.email})</option>`
        )
        .join("");
    if (concertSelect)
      concertSelect.innerHTML = (concerts.data || [])
        .map(
          (c) =>
            `<option value="${c.id}">${c.artist} – ${c.venue} (€${parseFloat(
              c.price
            ).toFixed(2)})</option>`
        )
        .join("");
  } catch (err) {
    if (typeof showToast === "function")
      showToast("⚠️ Kan de lijsten niet laden.");
    else alert("⚠️ Kan de lijsten niet laden.");
  }
}

const ticketFormEl = document.getElementById("ticketForm");
ticketFormEl?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const body = {
    visitor_id: parseInt(visitorSelect.value),
    concert_id: parseInt(concertSelect.value),
    qty: parseInt(document.getElementById("qty").value),
  };

  const res = await fetch(apiTickets, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  });

  const json = await res.json();
  if (typeof showToast === "function")
    showToast(
      json.message ? "🎟️ " + json.message : "Ticket aangemaakt",
      "success"
    );
  else alert("🎟️ " + (json.message || "Ticket aangemaakt"));
  loadTickets();
});

async function loadTickets() {
  ticketList.innerHTML = "<p>⏳ Tickets laden...</p>";
  const [res, concertsRes, visitorsRes] = await Promise.all([
    fetch(apiTickets),
    fetch(apiConcerts),
    fetch(apiVisitors),
  ]);
  const json = await res.json();
  const concerts = await concertsRes.json();
  const visitors = await visitorsRes.json();
  const concertMap = {};
  (concerts.data || []).forEach((c) => {
    const keys = [c.id, c.concert_id, c.concertId];
    keys.forEach((k) => {
      if (k != null) concertMap[k] = c;
    });
  });
  const visitorMap = {};
  (visitors.data || []).forEach((v) => {
    const keys = [v.id, v.visitor_id, v.visitorId];
    keys.forEach((k) => {
      if (k != null) visitorMap[k] = v;
    });
  });

  ticketList.innerHTML = "";
  console.log("tickets response:", json);

  (json.data || []).forEach((t) => {
    const div = document.createElement("div");
    div.className = "card";

    // if ticket already embeds visitor or concert objects, prefer those
    const embeddedVisitor = t.visitor || t.visitor_obj || t.buyer || null;
    const embeddedConcert = t.concert || t.concert_obj || null;

    const visitorId =
      t.visitor_id ?? t.visitorId ?? t.visitor ?? t.visitorid ?? t.fk_visitor;
    const concertId =
      t.concert_id ?? t.concertId ?? t.concert ?? t.concertid ?? t.fk_concert;

    const visitor =
      embeddedVisitor ||
      visitorMap[String(visitorId)] ||
      visitorMap[Number(visitorId)] ||
      (t.first_name || t.last_name
        ? { first_name: t.first_name, last_name: t.last_name, email: t.email }
        : null);
    const concert =
      embeddedConcert ||
      concertMap[String(concertId)] ||
      concertMap[Number(concertId)] ||
      (t.artist ? { artist: t.artist, venue: t.venue, date: t.date } : null);

    // thumb
    const thumb = document.createElement("div");
    thumb.className = "thumb";
    const visInitials =
      visitor && (visitor.first_name || visitor.firstName || visitor.name)
        ? ((visitor.first_name || visitor.firstName || visitor.name)[0] || "") +
          ((visitor.last_name || visitor.lastName || "")[0] || "")
        : "🎟️";
    thumb.textContent = (visInitials || "🎟️").toUpperCase();

    const body = document.createElement("div");
    body.className = "body";
    const visitorLabel = visitor
      ? visitor.first_name ||
        visitor.firstName ||
        visitor.name ||
        visitor.full_name ||
        (visitor.first_name &&
          visitor.last_name &&
          visitor.first_name + " " + visitor.last_name)
      : visitorId
      ? "ID:" + visitorId
      : "-";
    const concertLabel = concert
      ? concert.artist ||
        concert.name ||
        concert.title ||
        (concert.artist &&
          concert.venue &&
          concert.artist + " — " + concert.venue)
      : concertId
      ? "ID:" + concertId
      : "-";
    // prefer explicit purchase timestamp fields only; do NOT fall back to concert date
    const dateLabel =
      t.bought_at ||
      t.created_at ||
      t.boughtAt ||
      t.purchase_date ||
      t.purchased_at ||
      t.createdAt ||
      "-";

    body.innerHTML = `
      <h3>🎟️ Ticket #${t.id ?? "-"}</h3>
      <p>👤 ${visitorLabel}</p>
      <p>🎵 ${concertLabel}</p>
      <p>🎫 Aantal: ${t.qty ?? "-"}</p>
      <p>🕓 Gekocht op: ${dateLabel}</p>
    `;

    div.appendChild(thumb);
    div.appendChild(body);
    ticketList.appendChild(div);
  });
}

fillSelects();
loadTickets();
