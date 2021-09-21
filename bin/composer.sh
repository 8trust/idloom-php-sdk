#!/usr/bin/env bash
cd "${BASH_SOURCE%/*}/../" || exit

docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp/.composer \
  --user $(id -u):$(id -g) \
  composer:1.5.0 ${@:1}
  #faire un pull request car c'est la bonne version de composer, celle qui reprend la bonne version de php