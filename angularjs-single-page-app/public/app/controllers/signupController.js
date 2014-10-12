/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
angular.module('testSPA').controller('SignupController', function($scope, $routeParams, $log, API, $location) {

    console.log('$routeParams->userid', $routeParams.userid);

    //Local vars
    $scope.errorMessage;

    //Initiate user model
    $scope.user = angular.copy(API.UserModel.basic);

    $scope.state = 'CREATE';

    //Check if userid is set. Sent via signin.html
    if($routeParams.userid !== undefined){
        API.User.getUser($routeParams.userid).then(
            function successCallback(data){
                $log.info('getUser', data);

                $scope.user = data;
                $scope.state = 'EDIT';
            },
            function errorCallback(err){

            }
        )
    }

    /**
     * User clicks Signup
     */
    $scope.clickSignUp = function(){
        $log.debug('at clickSignUp');
        $scope.errorMessage = null;

        if($scope.state == 'CREATE')
            createUser();
        else if($scope.state == 'EDIT')
            updateUser();
        else
            $log.error('Err 1001: Major error at clickSignUp!');
    };

    /**
     * Send API request to create a new user
     */
    function createUser(){
        delete $scope.user.id;
        API.User.createUser($scope.user).then(
            function successCallback(data) {
                $log.info('clickSignUp->createUser response: ', data);
                $scope.errorMessage = null;

                if(data.status === 'success')
                    $location.path("/main/" + encodeURIComponent("User Created"));
                else
                    $scope.errorMessage = 'Incorrect email or code.';
            },
            function errorCallback(data) {
                if(data && data.message)
                    $scope.errorMessage = data.message;
                else
                    $scope.errorMessage = "Error while creating user.";
            }
        );
    }


    /**
     * Send API request to update a new user
     */
    function updateUser(){
        API.User.updateUser($scope.user).then(
            function successCallback(data) {
                $log.info('clickSignUp->createUser response: ', data);

                if(data === 'true')
                    $location.path("/main/" + encodeURIComponent("User Updated"));
                else
                    $scope.errorMessage = 'Incorrect email or code.';
            },
            function errorCallback(data) {
                if(data && data.message)
                    $scope.errorMessage = data.message;
                else
                    $scope.errorMessage = "Error while updating user.";
            }
        );
    }
});