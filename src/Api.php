<?php

namespace Gontran\SyliusPayboxBundle;

use Http\Message\MessageFactory;
use Payum\Core\Exception\Http\HttpException;
use Payum\Core\HttpClientInterface;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Reply\HttpRedirect;
use RuntimeException;

class Api
{
    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param array               $options
     * @param HttpClientInterface $client
     * @param MessageFactory      $messageFactory
     *
     * @throws \Payum\Core\Exception\InvalidArgumentException if an option is invalid
     */
    public function __construct(array $options, HttpClientInterface $client, MessageFactory $messageFactory)
    {
        $this->options = $options;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    protected function doRequest($method, array $fields)
    {
        $headers = [];

        $request = $this->messageFactory->createRequest($method, $this->getApiEndpoint(), $headers, http_build_query($fields));

        $response = $this->client->send($request);

        if (false == ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300)) {
            throw HttpException::factory($request, $response);
        }

        return $response;
    }

    public function doPayment(array $fields)
    {
        $fields[PayboxParams::PBX_SITE] = $this->options['site'];
        $fields[PayboxParams::PBX_RANG] = $this->options['rang'];
        $fields[PayboxParams::PBX_IDENTIFIANT] = $this->options['identifiant'];
        $fields[PayboxParams::PBX_HASH] = $this->options['hash'];
        $fields[PayboxParams::PBX_RETOUR] = $this->options['retour'];
        $fields[PayboxParams::PBX_TYPECARTE] = $this->options['type_carte'];
        $fields[PayboxParams::PBX_HMAC] = strtoupper($this->computeHmac($this->options['hmac'], $fields));
        $authorizeTokenUrl = $this->getApiEndpoint();
        throw new HttpPostRedirect($authorizeTokenUrl, $fields);
    }

    /**
     * @return string
     */
    protected function getApiEndpoint()
    {
        $servers = $this->options['sandbox'] ? PayboxParams::SERVERS_PREPROD : PayboxParams::SERVERS_PROD;

        //TODO: add choice for paybox payment page (iframe, mobile or classic)
        $endpoint = PayboxParams::URL_CLASSIC;

        foreach ($servers as $server) {
            $doc = new \DOMDocument();
            $doc->loadHTMLFile('https://'.$server.'/load.html');
            $element = $doc->getElementById('server_status');
            if ($element && 'OK' == $element->textContent) {
                return 'https://'.$server.'/'.$endpoint;
            }
        }
        throw new RuntimeException('No server available.');

        return $this->options['sandbox'] ? PayboxParams::SERVERS_CLASSIC_PREPROD : PayboxParams::SERVERS_CLASSIC_PROD;
    }

    /**
     * @param $hmac string hmac key
     * @param $fields array fields
     *
     * @return string
     */
    protected function computeHmac($hmac, $fields)
    {
        // Si la clé est en ASCII, On la transforme en binaire
        $binKey = pack('H*', $hmac);
        $msg = self::stringify($fields);

        return strtoupper(hash_hmac($fields[PayboxParams::PBX_HASH], $msg, $binKey));
    }
    /**
     * Makes an array of parameters become a querystring like string.
     *
     * @param array $array
     *
     * @return string
     */
    public static function stringify(array $array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $result[] = sprintf('%s=%s', $key, $value);
        }

        return implode('&', $result);
    }
    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
