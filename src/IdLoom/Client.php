<?php
namespace IdLoom;

use Zend\Http\Request;
use Zend\Json\Json;

class Client
{
    /**
     * @var string $accountName
     */
    private $accountName;

    /**
     * @var string $apiKey
     */
    private $apiKey;

    const ENPOINTS = [
        'events'
    ];

    const EVENT_STATUS_NOT_READY = 'NotReady';
    const EVENT_STATUS_OFF_LINE = 'OffLine';
    const EVENT_STATUS_PUBLISHED = 'Published';
    const EVENT_STATUS_REGISTERING = 'Registering';
    const EVENT_STATUS_SOLD_OUT = 'SoldOut';
    const EVENT_STATUS_IN_PROGRESS = 'InProgress';
    const EVENT_STATUS_CLOSED = 'Closed';
    const EVENT_STATUS_ARCHIVED = 'Archived';

    const EVENTS_STATUSES = [
        self::EVENT_STATUS_NOT_READY,
        self::EVENT_STATUS_OFF_LINE,
        self::EVENT_STATUS_PUBLISHED,
        self::EVENT_STATUS_REGISTERING,
        self::EVENT_STATUS_SOLD_OUT,
        self::EVENT_STATUS_IN_PROGRESS,
        self::EVENT_STATUS_CLOSED,
        self::EVENT_STATUS_ARCHIVED
    ];

    /**
     * Client constructor.
     * @param string $accountName
     * @param string $apiKey
     */
    public function __construct(string $accountName, string $apiKey)
    {
        $this->accountName = $accountName;
        $this->apiKey = $apiKey;
    }

    private function getURL($endpoint)
    {
        return "https://$this->accountName.events.idloom.com/api/v1/" . $endpoint;
    }

    /**
     * @return Request
     */
    private function getRequest($endpoint)
    {
        $request = new Request();
        $request->getHeaders()->addHeaders([
            'Accept' => 'application/json'
        ]);
        $request->setUri($this->getURL($endpoint));
        $request->getQuery()->api_key = $this->apiKey;
        return $request;
    }

    private function getClient()
    {
        $client = new \Zend\Http\Client();
        return $client;
    }

    public function getEvents($statuses = [self::EVENT_STATUS_PUBLISHED, self::EVENT_STATUS_REGISTERING, self::EVENT_STATUS_SOLD_OUT, self::EVENT_STATUS_IN_PROGRESS])
    {
        $unsupportedStatuses = array_diff($statuses, self::EVENTS_STATUSES);
        if (count($unsupportedStatuses) > 0) {
            throw new Exception('Unsupported statuses : ' . implode($unsupportedStatuses, ','));
        }

        $request = $this->getRequest('events');
        $request->setMethod(Request::METHOD_GET);
        $client = $this->getClient();
        $response = $client->send($request);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('IdLoom Response : ' . $response->getStatusCode() . ' ' . $response->getBody());
        }
        $responseAsArray = Json::decode($response->getBody(), Json::TYPE_ARRAY);
        return $responseAsArray;
    }

    public static function printArray($array, $pre = '')
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo "$pre$key:" . PHP_EOL;
                self::printArray($value, $pre . ">");
            } else {
                echo "$pre$key:\t$value" . PHP_EOL;
            }
        }
    }


}
