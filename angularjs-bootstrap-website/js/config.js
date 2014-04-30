var env;
if (document.domain == 'local.northsocial.com')
    env = 'dev';
else if(document.domain == 'localrkm.northsocial.com')
    env = 'localrkm';
else if(document.domain == 'dev.northsocial.com')
    env = 'development';
else if(document.domain == 'vms.northsocial.com')
    env = 'development';
else if(document.domain == 'qa.northsocial.com')
    env = 'qa';
else if(document.domain == 'northsocial.com')
	env = 'production';
else if(document.domain == 'new.northsocial.com')
    env = 'production_new';

console.log("Environment: " + env);

nswebModule.constant('ENV', env).config(function($routeProvider, $provide, ENV) {
    $routeProvider.
	  when('/p/purchase/:pageId/:planCode', {controller:'PurchaseController', templateUrl:'/pages/purchase.html'}).
		when('/p/pricing', {controller:'PlanController', templateUrl:'/pages/pricing.html'}).
      when('/p/:page', {controller:'RouteControllerStatic', templateUrl:'/pages/pagelist.html'}).
      when('/p/v/apps/:vmstype/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'apps', sub:'vms'}).
      when('/p/apps/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'apps'}).
      when('/p/install/:app/:api_key', {controller:'InstallController', templateUrl:'/pages/install.html'}).
      when('/p/examples/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'examples'}).
      when('/p/customapps/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'customapps'}).
      when('/p/analytics/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'analytics'}).
      when('/p/services/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'services'}).
      when('/p/get-customapps/:page', {controller:'RouteControllerDataDynamic', templateUrl:'/pages/dynamic.html', base:'get-customapps'}).
      when('/p/mobile/:page', {controller:'RouteControllerDynamicStaticPage', templateUrl:'/pages/dynamic.html', base:'mobile'}).
	  otherwise({redirectTo:'/p/main'});

    //Plan Array - see /pages/pricing.html
    switch(ENV){
        case 'local':
        case 'localrkm':
        case 'dev':
        case 'qa':
        case 'production':
        case 'production_new':
        default:
            $provide.value('PlanArray',
            [
                {id:'1', name:'Mobile Entrepreneur', code:'mobileentrepreneur', charage:'$1.99', type: "credit"},
                {id:'2', name:'Mobile Entrepreneur', code:'', charage:'$2.99', type: "invoice"},
                {id:'3', name:'Mobile Small Business', code:'mobilemediumbusiness', charage:'$3.99', type: "credit"},
                {id:'4', name:'Mobile Small Business', code:'', charage:'$4.99', type: "invoice"},
                {id:'5', name:'Mobile Medium Business', code:'mobilemediumbusiness', charage:'$5.99', type: "credit"},
                {id:'6', name:'Mobile Medium Business', code:'', charage:'$6.99', type: "invoice"},

                {id:'7', name:'1 Unlimited Mobile', code:'1unlimitedmobile', charage:'$1.99', type: "credit"},
                {id:'8', name:'1 Unlimited Mobile', code:'', charage:'$1.99', type: "invoice"},
                {id:'9', name:'10 Unlimited Mobile', code:'10unlimitedmobile', charage:'$1.99', type: "credit"},
                {id:'10', name:'10 Unlimited Mobile', code:'', charage:'$1.99', type: "invoice"},
                {id:'11', name:'50 Unlimited Mobile', code:'50unlimitedmobile', charage:'$1.99', type: "credit"},
                {id:'12', name:'50 Unlimited Mobile', code:'', charage:'$1.99', type: "invoice"},
                {id:'13', name:'100 Unlimited Mobile', code:'100unlimitedmobile', charage:'$1.99', type: "credit"},
                {id:'14', name:'100 Unlimited Mobile', code:'', charage:'$1.99', type: "invoice"},

                {id:'15', name:'Mobile Marketing Maven', code:'mobilemarketingmaven', charage:'$1.99', type: "credit"},
                {id:'16', name:'Mobile Marketing Maven', code:'', charage:'$1.99', type: "invoice"},

                {id:'17', name:'Ngage Solo', code:'ngagesolo', charage:'$1.99', type: "credit"},
                {id:'18', name:'Ngage Solo', code:'', charage:'$1.99', type: "invoice"},
                {id:'19', name:'Ngage Trio', code:'ngagetrio', charage:'$1.99', type: "credit"},
                {id:'20', name:'Ngage Trio', code:'', charage:'$1.99', type: "invoice"},
                {id:'21', name:'Ngage Team', code:'ngageteam', charage:'$1.99', type: "credit"},
                {id:'22', name:'Ngage Team', code:'', charage:'$1.99', type: "invoice"}

            ]

            );
    }

    //Facebook App ID
    switch(ENV){
        case 'localrkm':
            $provide.value('fbookAppID', '397755663661537');
            $provide.value('fbookChannel', '//localrkm.northsocial.com/channel.html');
            break;
        case 'local':
            $provide.value('fbookAppID', '211615669012442');
            $provide.value('fbookChannel', '//local.northsocial.com/channel.html');
            break;
        case 'development':
            $provide.value('fbookAppID', '568909003203297');
            $provide.value('fbookChannel', '//dev.northsocial.com/channel.html');
            break;
        case 'qa':
            $provide.value('fbookAppID', '1424506191023085');
            $provide.value('fbookChannel', '//qa.northsocial.com/channel.html');
            break;
        case 'production':
            $provide.value('fbookAppID', '115920858429790');
            $provide.value('fbookChannel', '//northsocial.com/channel.html');
            break;
        case 'production_new':
            $provide.value('fbookAppID', '546825252071825');
            $provide.value('fbookChannel', '//new.northsocial.com/channel.html');
            break;
        default:
            ;
    }

})