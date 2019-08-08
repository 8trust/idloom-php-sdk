#!/usr/bin/env bash
cd "${BASH_SOURCE%/*}/../" || exit

docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp/.composer \
  --user $(id -u):$(id -g) \
  composer ${@:1}