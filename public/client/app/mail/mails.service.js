(function() {
  'use strict';

  angular
    .module('app')
    .factory('MailsService', MailsService);

  /** @ngInject */
  // eslint-disable-next-line max-params
  function MailsService(serviceFactory) {
    var model = serviceFactory('mails', {});

    return model;
  }

}());
