/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
testSPA.service('UserModel', ['$rootScope', function ($rootScope) {

        var User = {
            basic : {
                id : null,
                name: null,
                email : 'email1',
                code : 'code2'
            }
        };

        return User;
    }
]);
