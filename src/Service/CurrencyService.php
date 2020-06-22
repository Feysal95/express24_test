<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class CurrencyService
{
    const URI_SOURCE = 'http://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * Пытаемся спарсить курсы валют с URI_SOURCE
     * @return array
     */
    public function getCurrencies(): array
    {
        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', self::URI_SOURCE);
            $content = $response->getContent();

            $crawler = new Crawler($content);
            $nodeValues = $crawler->filter("ValCurs Valute")->each(function (Crawler $node){
                return [
                    'name' => $node->filter('Name')->text(),
                    'rate' => str_replace(",", ".", $node->filter('Value')->text()),
                ];
            });
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }

        return $nodeValues;
    }
}