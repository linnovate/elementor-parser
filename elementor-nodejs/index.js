const request = require('request');
const UrlPattern = require('url-pattern');

function ElementorContent(options) {

    const defaultOption = {
        target: null,
        prefix: /^\/elementor\/?(.*)$/,
        prefixRedirect: "/elementor",
        redirects: [],
        addPath: "/content/add",
        editPath: "/content/:id/edit",
        viewPath: "/content/:id",
    };

    options = Object.assign({}, defaultOption, options);

    if (!options.target) {
        return console.log("ElementorContent: Fails. \n  The options 'target' is empty!");
    }

    console.log("ElementorContent: Succeeded");
    // console.log(`ElementorContent: Succeeded ${Object.keys(options).map(key=>`\n  ${key}: '${options[key]}'`).join('')}!`);

    return function(req, res, next) {

        let params;

        function filter(url) {
            return new UrlPattern(url).match(req.originalUrl);
        }

        function proxy(uri) {
            const proxyServer = request({
                baseUrl: options.target,
                uri,
                followRedirect: false
            });
            req.pipe(proxyServer);
            proxyServer.pipe(res)
        }

        // Add content
        if (filter(options.addPath)) {
            return res.redirect(`${options.prefixRedirect}/wp-admin/edit.php?action=elementor_outside_new_post`);
        }// Edit content
        else if (params = filter(options.editPath)) {
            return res.redirect(`${options.prefixRedirect}/wp-admin/post.php?post=${params.id}&action=elementor`);
        }// View content
        else if (params = filter(options.viewPath)) {
            return proxy(`/?p=${params.id}`);
        }// Redirects
        else if (options.redirects.find(filter)) {
            return proxy(`${options.prefixRedirect}${req.originalUrl}/`);
        }// General proxy
        else if (params = filter(options.prefix)) {
            return proxy(params.join(''));
        }

        next();
    }
}

module.exports = ElementorContent;
