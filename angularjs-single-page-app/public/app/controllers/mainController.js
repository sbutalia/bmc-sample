/**
 * @author Simran Butalia
 * @date 10/10/2014
 */
testSPA.controller('MainController', function($scope, $routeParams) {

    $scope.message;

    //Check if message is set. Sent via signup.html
    if($routeParams.message !== undefined){
        $scope.message = decodeURIComponent($routeParams.message);
    }
});