const app = require('express')();
const elementorContent = require('../elementor-nodejs');

app.use(elementorContent({ proxyTarget: "http://localhost:8005" }));

app.listen(3001, function() {
    console.log(`Example app listening on port 3001!`);
})
