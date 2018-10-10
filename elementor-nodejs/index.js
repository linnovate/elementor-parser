const request = require('request');
const UrlPattern = require('url-pattern');

function ElementorContent(options) {

    const defaultOption = {
        proxyTarget: null,
        proxyPath: "/wp",
        addPath: "/content/add",
        editPath: "/content/:id/edit",
        viewPath: "/content/:id",
    };

    options = Object.assign({}, defaultOption, options);

    if (!options.proxyTarget) {
        console.log("The options 'proxyTarget' is empty!");
        return;
    }

    return function(req, res, next) {

        let params;

        function filter(url) {
            return new UrlPattern(url).match(req.originalUrl);
        }

        function proxy(url) {
            return request({
                baseUrl: options.proxyTarget,
                url
            }, function(error, response, body) {
                res.send(body)
            });
        }

        if (filter(options.proxyPath + '/*') || filter(options.proxyPath)) {
            const url = req.originalUrl.replace(options.proxyPath, '');
            return proxy(url);
        } else if (filter(options.addPath)) {
            return res.redirect(`${options.proxyPath}/wp-admin/edit.php?action=elementor_outside_new_post`);
        } else if (params = filter(options.editPath)) {
            return res.redirect(`${options.proxyPath}/wp-admin/post.php?post=${params.id}&action=elementor`);
        } else if (params = filter(options.viewPath)) {
            return proxy(`/?p=${params.id}`);
        }

        next()
    }
}

module.exports = ElementorContent;
