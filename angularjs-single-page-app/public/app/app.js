/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
var testSPA = angular.module('testSPA', ['ngRoute']);

//Setting up route
testSPA.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/signin', {
                templateUrl: 'public/app/views/signin.html',
                controller: 'SigninController'
            }).
            when('/signup', {
                templateUrl: 'public/app/views/signup.html',
                controller: 'SignupController'
            }).
            when('/signup/:userid', {
                templateUrl: 'public/app/views/signup.html',
                controller: 'SignupController'
            }).
            when('/main/:message', {
                templateUrl: 'public/app/views/main.html'
            }).
            otherwise({
                redirectTo: '/',
                templateUrl: 'public/app/views/main.html'
            });

        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }
]);


testSPA.constant('servicesConfig', (function() {
    var protocol = 'http://';
    return {
        api: protocol + 'api-test.ivanfarms.com'
    }
})());
