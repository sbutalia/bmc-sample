var nswebModule = angular.module('nsweb', ['nsweb.directives', 'FB', 'webStorageModule']);


/*
 Loads a simple static page based on the route parameter
 Parameter: ':page' Static page to load.
 */
function RouteControllerStatic ($scope, $routeParams) {
    if($routeParams.page !== undefined){
        var pageToLoad = $routeParams.page;
        $scope.page  = '/pages/'+ pageToLoad + '.html';
    }

    //After page is loaded initialize any DOM Plugins
    $scope.page_loaded = function(){
        //For the homepage initialize the flex slider
        if($routeParams.page == 'main')
            angular.element('.flexslider').flexslider();
    } ;
}


/*
 Loads dynamic html pages along with their navigation.
 The pages are hosted under a directory whose name is defined in the "base" parameter.

 Parameter: ':page' Dynamic page to load example: mobile/(publish-everywhere, complete-control, ...)
 */
function RouteControllerDynamicStaticPage ($scope, $routeParams, $route, $http) {
    if($routeParams.page !== undefined){
        var pageDir = $route.current.$$route.base;
        $scope.nav = '/pages/'+pageDir+'/nav.html';
        $scope.page  = '/pages/'+pageDir+'/'+$routeParams.page+'.html';
    }

}

/*
    Loads apps, examples, custom data dynamically. The custom data are hosted under a directory which is defined in the "base" parameter.
    Loads the display data for pages dynamically via json objects.

    Parameter: ':page' Dynamic page to load (instagram, fan-coupon, exclusive..)
    base
 */
function RouteControllerDataDynamic ($scope, $rootScope, $routeParams, $route, $http, ENV) {
    //Dynamically determine the page to load
    var pageAndDataDir = $route.current.$$route.base;
    var pageDataToLoad = $routeParams.page;
    $scope.pageParam = $routeParams.page;
    $scope.appLink = "";


    //VMS related variables
    var isvms = $route.current.$$route.sub;
    $rootScope.isvms = isvms;
    var vmsType = $routeParams.vmstype;
    $scope.vmstype = vmsType;

    if(pageAndDataDir !== undefined){
        //Load Nav based on VMS Properties
        if(isvms === undefined)
            $scope.nav = '/pages/'+pageAndDataDir+'/nav.html';
        else
            $scope.nav = '/pages/'+pageAndDataDir+'/nav-'+vmsType+'.html';

        //Load Page
        if($routeParams.page == "overview")
            $scope.page  = '/pages/'+pageAndDataDir+'/overview.html';
        else{
            $scope.page  = '/pages/'+pageAndDataDir+'/dynamic-content.html';

            //Render page data dynamically
            var httpUrl = '/data/'+pageAndDataDir+'/'+pageDataToLoad+'.json';
            $http.get(httpUrl).success(function (data) {
                if(data !== undefined ){
                    $scope.pageData = data;

                    $scope.appLink = "/#/p/install/"+ $scope.pageParam + "/" + $scope.pageData['api_key'][ENV]  + "/";
                }
            }).error(function (resp) {
                    //handle error
            });
        }

    } else{
        //Try loading a static page
        $scope.page  = '/pages/'+ pageAndDataDir + '.html';
    }


    // External button that triggers this directive
    $scope.appInstallButtonClick = function(){
        $scope.$broadcast("event:appInstallButtonClicked");
    }
}

function RouteController ($scope, $routeParams) {
  // Getting the slug from $routeParams
  var slug = $routeParams.slug;

  // We need to get the page data from the JSON
  // $scope.page = ?;
}
