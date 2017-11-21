(function() {

  'use strict';

  angular
    .module('app')
    .controller('ProjectsController', ProjectsController);

  /** @ngInject */
  // eslint-disable-next-line max-params
  function ProjectsController(Global, $controller, ProjectsService, PrDialog) {
    var vm = this;

    //Attributes Block

    //Functions Block
    vm.viewTasks = viewTasks;

    // instantiate base controller
    $controller('CRUDController', { vm: vm, modelService: ProjectsService, options: {} });

    function viewTasks(projectId) {
      var config = {
        locals: {
          projectId: projectId
        },
        controller: 'TasksDialogController',
        controllerAs: 'tasksCtrl',
        templateUrl: Global.clientPath + '/samples/tasks/tasks-dialog.html',
        hasBackdrop: true
      };

      PrDialog.custom(config).then(function() {
        vm.search(vm.paginator.currentPage);
      });

    }

  }

})();
