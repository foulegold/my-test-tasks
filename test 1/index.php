<?php
// Требуется спроектировать модуль расчета стоимости доставки.
//Есть две службы доставки:
//1. «Быстрая доставка»:
//base_url: string
//@var sourceKladr string //кладр откуда везем
//@var targetKladr string //кладр куда везем
//@var weight float //вес отправления в кг
//@return json
//{
//    'price': float //стоимость
//    'period': int //количество дней начиная с сегодняшнего, но после 18.00
//заявки не принимаются.
//    'error': string
//}
//2. «Медленная доставка»:
//имеет базовую стоимость 150р
//base_url: string
//@var sourceKladr string //кладр откуда везем
//@var targetKladr string //кладр куда везем
//@var weight float //вес отправления в кг
//@return json
//{
//    'coefficient': float //коэффициент (конечная цена есть произведение
//базовой стоимости и коэффициента)
//    'date': string //дата доставки в формате 2017-10-20
//    'error': string
//}
//
//Задача в том, чтобы получить для набора отправлений стоимость и сроки
//доставки в контексте списка транспортных компаний и одной выбранной. Формат
//полученных от транспортных компаний данных должен быть приведен к единому
//виду (
//    {
//        'price': float //стоимость
//        'date': string //дата доставки в формате 2017-10-20
//       'error': string
//    }
//).
//Набор данных с отправлениями можно создать произвольно, взаимодействие с
//сервисами транспортных компаний эмулировать.
// https://docs.google.com/forms/d/e/1FAIpQLSfG56O-7vRWnDTrMDYN6pSH3nv5QH3GAf7lYXdkNY1zqYEuBQ/viewform

function EmulateGetData(string $url, array $params)
{
    if ($url === 'https://fast.ru/calculate') {
        $result = [];
    }
    else $result = [];
    return json_decode($result);
}

class DeliveryService {
    public string $baseUrl;
    public function getData(array $params)
    {
        $params = [
            'sourceKladr' => $package->sourceKladr,
            'targetKladr' => $package->targetKladr,
            'weight' => $package->weight,
        ];
        return json_decode(EmulateGetData($this->baseUrl, $params));
    }
}

class FastDelivery extends DeliveryService {
    public string $baseUrl = 'https://fast.ru/calculate';
}

class SlowDelivery extends DeliveryService {
    public string $baseUrl = 'https://slow.ru/calculate';
    public float $basePrice = 100;
}

class Package {
    public string $name;
    public string $sourceKladr;
    public string $targetKladr;
    public float $weight;

    function __construct(string $name, string $sourceKladr, string $targetKladr, float $weight)
    {
        $this->name = $name;
        $this->sourceKladr = $sourceKladr;
        $this->targetKladr = $targetKladr;
        $this->weight = $weight;
    }
}

$packagesData = [
    'pack 1' => [
        'sourceKladr' => 'source 1',
        'targetKladr' => 'target 1',
        'weight' => 1000,
    ],
    'pack 2' => [
        'sourceKladr' => 'source 2',
        'targetKladr' => 'target 2',
        'weight' => 123.14,
    ],
    'pack 3' => [
        'sourceKladr' => 'source 3',
        'targetKladr' => 'target 3',
        'weight' => 333.11,
    ],
];

foreach ($packagesData as $name => $packageData) {
    $package = New Package($name, $packageData['sourceKladr'], $packageData['targetKladr'], $packageData['weight']);
}