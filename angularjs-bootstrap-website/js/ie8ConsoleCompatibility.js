(function() {
    var consoleDisabled = false;
    if (consoleDisabled) {
        window.console = undefined;
    }
    if (window.console == undefined) {
        window.console = {
            debug: function() {
                return true;
            },
            info: function() {
                return false;
            },
            warn: function() {
                return false;
            },
            log: function() {
                return false;
            }
        }
    }
    debug = (function(args) {
        window.console.debug(args);
    });
    info = (function(args) {
        window.console.info(args);
    });
    warn = (function(args) {
        window.console.warn(args);
    });
    log = (function(args) {
        window.console.log(args);
    });
})();