/**
 * Factory for all API calls.
 *
 * @author Simran Butalia
 * @date 10/10/2014
 */
testSPA.factory('API', [
    'UserAPI',
    'UserModel',

    function (
        UserAPI, UserModel) {

        var api = {
            User : {},
            UserModel : {}
        };

        _.extend(api.User, UserAPI);
        _.extend(api.UserModel, UserModel);

        return api;
    }
]);