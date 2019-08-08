<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeanch
 * Date: 8/08/19
 * Time: 12:23
 */

require __DIR__ . '/vendor/autoload.php';
$ini_array = parse_ini_file("idloom.ini");
$idLoom = new IdLoom\Client($ini_array['idloom_client'], $ini_array['idloom_key']);

$events = $idLoom->getEvents();

echo "Found " . count($events) . PHP_EOL;

foreach ($events as $event) {
    \IdLoom\Client::printArray($event);
    echo "___" . PHP_EOL;
}
