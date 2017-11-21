(function() {
  'use strict';

  angular
    .module('app')
    .factory('ProjectsService', ProjectsService);

  /** @ngInject */
  function ProjectsService(serviceFactory) {
    var model = serviceFactory('projects', {
      actions: { },
      instance: { }
    });

    return model;
  }

}());
