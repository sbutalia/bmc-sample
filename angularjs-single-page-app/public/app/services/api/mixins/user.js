/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
testSPA.factory('UserAPI', [
    '$http',
    '$q',
    'helperService',
    'servicesConfig',

    function ($http, $q, helperService,servicesConfig) {
        var http_helper = helperService.validateHttp;

        var methods = {
            /**
             * Retrieve a user by his email
             * 
             * @param  {String}   username  Email of the requested user
             */
            getUser: function (username, options) {
                options = _.extend(options || {}, {
                    method: 'GET',
                    url: servicesConfig.api + '/user/' + username
                });

                return http_helper($http(options));
            },

            /**
             * Create a User
             * 
             * @param  {object}   data  Username of the requested user
             */
            createUser: function (data) {
                var url = servicesConfig.api + '/createUser';

                return http_helper($http.post(url, data));
            },

            /**
             * Create a User
             *
             * @param  {String}   username  Username of the requested user
             */
            updateUser: function (data) {
                var url = servicesConfig.api + '/user/' + data.email;

                return http_helper($http.put(url, data));
            },


            /**
             * Verify user exists and consistency
             *
             * @param  {String}   data  Username/Code of the requested user
             */
            verifyUser: function (data) {
                var url = servicesConfig.api + '/verifyUser';

                return http_helper($http.post(url, data));
            }

        };

        return methods;
    }
]);
