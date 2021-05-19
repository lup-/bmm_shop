const fs = require('fs');
const feed = require('./feed.json');
const RANDOM_COUNT = 10;

let feedHash = {};
for (const product of feed.offers) {
    let section = product.features && product.features.section
        ? product.features.section
        : '_';

    if (!feedHash[product.type_id]) {
        feedHash[product.type_id] = {};
    }

    if (!feedHash[product.type_id][section]) {
        feedHash[product.type_id][section] = [];
    }

    feedHash[product.type_id][section].push(product);
}

let truncatedOffers = [];
for (const type in feedHash) {
    let sections = feedHash[type];
    for (const section in sections) {
        let items = sections[section];
        let randomItems = Array(RANDOM_COUNT).fill(0)
            .map(_ => Math.floor(Math.random()*items.length))
            .map(randomIndex => items[randomIndex]);
        truncatedOffers = truncatedOffers.concat(randomItems);
    }
}

let truncatedFeed = {
    product_types: feed.product_types,
    offers: truncatedOffers
}

let json = JSON.stringify(truncatedFeed);
let escapedJson = unescape( escape(json).replace(/\%u/g, '\\u').toLowerCase() );
fs.writeFileSync('./truncated_feed.json', escapedJson);
console.log(truncatedOffers.length + ' товаров записано в truncated_feed.json');