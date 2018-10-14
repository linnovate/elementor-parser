const app = require('express')();
const elementorContent = require('../elementor-nodejs');

app.use(elementorContent({ 
    target: "http://localhost:2222",
    redirects: ["/about", "/contact"],
}));

app.listen(3001, function() {
    console.log(`Example app listening on port 3001!`);
})
