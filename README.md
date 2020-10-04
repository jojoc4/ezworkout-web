# EZWorkout

Le but de l’application est de planifier, d’organiser, puis de suivre des entraînements sportif orientés musculation.

Elle se décompose en 3 parties :

  * la planification d'entraînements
  * historique des entraînements
  * Analyses des performances

Les données des entraînements seront synchronisées depuis une app mobile à l'aide d'une api.

[![Laravel Actions Status](https://github.com/HE-Arc/EZWorkout/workflows/Laravel/badge.svg)](https://github.com/HE-Arc/EZWorkout/actions)
[![Quality Gate Status](https://sonar.jojoc4.ch/api/project_badges/measure?project=ezworkout&metric=alert_status)](https://sonar.jojoc4.ch/dashboard?id=ezworkout)

## Dev Installation
1. clone repo
2. copy .env.exemple .env
3. run composer installer 
4. run php artisan key:generate
5. run php artisan migrate
6. you're ready
