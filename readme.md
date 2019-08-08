# IdLoom php sdk

Simple php sdk for idloom webservice: https://api.idloom.events/


# Supported Endpoints

- GET events - getList

# Usage

## Setup

1. Install composer dependencies : ``` bin/./composer.sh install ```

From that point, u can use the client :
$idLoom = new IdLoom\Client("CLIENT", "API_KEY");
$events = $idLoom->getEvents();

## Run test

1. Create idloom.ini : ``` cp idloom.ini.src idloom.ini ```
2. Replace {CLIENT} and {KEY} in idloom.ini
3. run test ```bin/./composer.sh php test.php```