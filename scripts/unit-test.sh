#!/bin/bash

# Rodando os testes do Laravel
# Limpando a base de test e rodando os seeds
phpunit --verbose --colors=always

echo
cat testresults/log.txt
