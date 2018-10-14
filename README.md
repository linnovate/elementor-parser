# elementor-parser

## Install
docker-compose up -d // setup localhost:2222

cd example-nodejs && node server.js // setup localhost:3001

## use

### Add content:
[host]/content/add
### Edit content:
[host]/content/%id%/edit
### View content:
[host]/content/%postname%
### Get delete:
soon - [host]/elementor/%id%/delete

# setup by node

    const app = require('express')();
    const elementorContent = require('../elementor-nodejs');

    app.use(elementorContent({ 
        target: "http://localhost:2222",
        redirects: ["/about", "/contact"],
    }));

    app.listen(3001, function() {
        console.log(`Example app listening on port 3001!`);
    })
