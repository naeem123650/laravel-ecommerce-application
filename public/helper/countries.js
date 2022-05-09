var db = new loki('csc.db');

const countriesJSON = '.././helper/countries.json';

async function filterCurrencySymbol(e) {
    var countriesColl = db.getCollection("countries");
    let currency = await countriesColl.find({ currency: e.target.value });
    if (currency.length) {
      await currency.forEach((c) => {
        $("#currency_symbol").val(c.currency_symbol);
      });
    }
}

async function initializeData() {
  var countries = db.getCollection("countries");
  var db_country_code = document.getElementById('db_country_code').value;

  if (!countries) {
    countries = db.addCollection('countries');
    await fetch(countriesJSON)
      .then(response => response.json())
      .then(async (data) => {
        await data.forEach((c) => {
          countries.insert(c);
          $('#currency_code').append(`</option><option value="${c.currency}" ${c.currency == db_country_code ? 'selected' : ''}>${c.currency} (${c.name})</option>`);
        });
      });
    }
}

initializeData();
