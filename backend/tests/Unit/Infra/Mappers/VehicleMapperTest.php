<?php

use Infra\Mappers\VehicleMapper;
use Domain\Entities\Vehicle;
use Domain\ValueObjects\Price;
use Domain\ValueObjects\Location;
use Infra\Repositories\MySQL\MySQLVehicleRepository;

it('mapeia um array em uma entidade Vehicle', function () {
    $row = [
        'id' => 1,
        'image_url' => 'http://img.png',
        'brand' => 'Volkswagen',
        'model' => 'Gol',
        'version' => '1.0',
        'price' => 123000,
        'location' => 'Mogi',
        'uf' => 'SP',
    ];

    $vehicle = VehicleMapper::fromArray($row);

    expect($vehicle)->toBeInstanceOf(Vehicle::class);
    expect($vehicle->id)->toBe(1);
    expect($vehicle->imageUrl)->toBe('http://img.png');
    expect($vehicle->price)->toBeInstanceOf(Price::class);
    expect($vehicle->price->value())->toBe(123000);
    expect($vehicle->location)->toBeInstanceOf(Location::class);
    expect($vehicle->location->format())->toBe('Mogi - SP');
});

it('lança exceção se preço for inválido', function () {
    $row = [
        'id' => 1,
        'image_url' => 'http://img.png',
        'brand' => 'Volkswagen',
        'model' => 'Gol',
        'version' => '1.0',
        'price' => -1,
        'location' => 'Mogi',
        'uf' => 'SP',
    ];

    VehicleMapper::fromArray($row);
})->throws(InvalidArgumentException::class);