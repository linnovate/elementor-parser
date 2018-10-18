# elementor-parser

## Install
```sh
docker-compose up -d // "elementor-parser" listening on port 3005!

cd example-nodejs
npm install
node server.js // "node" listening on port 3001!
```

## Default options

```js
defaultOptions = {
    target: null,
    prefix: /^\/elementor\/?(.*)$/,
    prefixRedirect: "/elementor",
    redirects: [],
    addPath:  "/create_elementor_post",
    editPath: "/edit_elementor_post/:postname",
    viewPath: "/elementor_post/:postname",
};

```

## Usage by nodejs

```js
const app = require('express')();
const elementorContent = require('../elementor-nodejs');

app.use(elementorContent({ 
    // Option
    target: [elementor-parser-server],
    redirects: [/\/about\/?/, "/contact"], // ex.
}));

```

## Setup "Elementor-parser"
```sh
$ docker build . -t elementor-parser
$ docker run -p [port]:80 \
             -e PROXY_FROM=[proxy_from_location] \
             --name elementor \
             -d \
             elementor-parser
```