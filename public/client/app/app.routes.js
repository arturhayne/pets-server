(function() {
  'use strict';

  angular
    .module('app')
    .config(routes);

  /** @ngInject */
  function routes($stateProvider, $urlRouterProvider, Global) {
    $stateProvider
      .state('app', {
        url: '/app',
        templateUrl: Global.clientPath + '/layout/app.html',
        abstract: true,
        resolve: { //ensure langs is ready before render view
          translateReady: ['$translate', '$q', 'PrToast', function($translate, $q, PrToast) {
            var deferred = $q.defer();

            PrToast.info('Preparando o sistema', { hideDelay: false });

            $translate.use('pt-BR').then(function() {
              PrToast.hide();
              deferred.resolve();
            });

            return deferred.promise;
          }]
        }
      })
      .state(Global.notAuthorizedState, {
        url: '/acesso-negado',
        templateUrl: Global.clientPath + '/layout/not-authorized.html',
        data: { needAuthentication: false }
      });

    $urlRouterProvider.otherwise(Global.loginUrl);
  }
}());
