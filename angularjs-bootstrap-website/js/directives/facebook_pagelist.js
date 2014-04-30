nswebDirectives.directive('facebookPagelist', ['$compile', function($compile) {
  return {
    restrict: 'A',
    scope: {},
    templateUrl: '/tpl/directives/facebook_pagelist/pagelist.html',
    link: function($scope, $element, $attrs) {
      $scope.userPages = [];

      function showLoginModal(){
        $('#fbLoginModal').modal('show');
      }
      function showPagelist(){
        FB.api('/me/accounts', function(response) {
          $scope.userPages = response.data;
          $scope.pagelistShowing = true;
          if(!$scope.$$phase) {
            $scope.$apply();
          }
        });
      }

      // External button that triggers this directive
      $('#'+$attrs.trigger).click(function(){
        FB.getLoginStatus(function(response) {
          if(response.status === 'connected') {
            // User is logged in
            showPagelist();
          }else {
            // the user isn't logged in to Facebook.
            showLoginModal();
          }
        });
      });

    }
  };
}]);