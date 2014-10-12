/**
 * A general helper service. Contains methods for http validation, displaying general errors, managing loading bars.
 *
 * @author Simran Butalia
 * @date 10/10/2014
 */
testSPA.service('helperService', ['$rootScope', '$q', '$log', function ($rootScope, $q, $log) {
    var service = {};

    // Speed up calls to hasOwnProperty
    var hasOwnProperty = Object.prototype.hasOwnProperty;
    service.isEmpty = function (obj) {
        // null and undefined are "empty"
        if (obj === null || typeof obj === 'undefined') return true;

        // Assume if it has a length property with a non-zero value
        // that that property is correct.
        if (obj.length > 0) return false;
        if (obj.length === 0)  return true;

        // Otherwise, does it have any properties of its own?
        // Note that this doesn't handle
        // toString and valueOf enumeration bugs in IE < 9
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }

        return true;
    };

    /**
     * Validate http request and return another promise.
     * @param  {Object} httpPromise Http promise.
     * @return {Object}             Promise object.
     */
    service.validateHttp = function (httpPromise) {
        var deferred = $q.defer();

        httpPromise.success(function (res) {
            deferred.resolve(res);
        }).error(function (err) {
            deferred.reject(err);
        });

        return deferred.promise;
    };


    return service;
}]);
