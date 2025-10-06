const API = "https://TON-DOMAINE.be/oef1/api/";

async function api(path, options={}){
  const res = await fetch(API + path, {headers:{'Content-Type':'application/json'},...options});
  return res.json();
}
(async()=>{
  console.log("Ready to test API:", API);
})();