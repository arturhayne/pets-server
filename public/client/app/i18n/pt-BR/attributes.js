/*eslint angular/file-name: 0, no-undef: 0*/
(function() {
  'use strict';

  angular
    .module('app')
    .constant('pt-BR.i18n.attributes', {
      email: 'Email',
      password: 'Senha',
      name: 'Nome',
      image: 'Imagem',
      roles: 'Perfis',
      //é carregado do servidor caso esteja definido no mesmo
      auditModel: {
      }
    })

}());
