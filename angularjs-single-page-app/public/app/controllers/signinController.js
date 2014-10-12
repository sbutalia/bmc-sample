/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
angular.module('testSPA').controller('SigninController',

    function($scope, API, $log, $location) {

        //Local vars
        $scope.errorMessage;

        //Initiate user model
        $scope.user = angular.copy(API.UserModel.basic);

        /**
         * User clicks Signin
         */
        $scope.clickSignIn = function(){
            $log.debug('at clickSignIn');

            API.User.verifyUser($scope.user).then(
                function successCallback(data) {
                    $log.info('clickSignIn response: ', data);
                    $scope.errorMessage = null;

                    if(data === 'true')
                        $location.path("/signup/" + encodeURIComponent($scope.user.email) );
                    else
                        $scope.errorMessage = 'Incorrect email or code.';

                },
                function errorCallback(data) {
                    $scope.errorMessage = data;
                }
            );
        };
});