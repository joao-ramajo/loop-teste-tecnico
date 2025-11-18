<?php

declare(strict_types=1);

namespace Infra\Mappers;

use Domain\Entities\Vehicle;
use Domain\ValueObjects\Price;
use Domain\ValueObjects\Location;

class VehicleMapper
{
    public static function fromArray(array $data): Vehicle
    {
        return new Vehicle(
            id: (int) $data['id'],
            imageUrl: $data['image_url'],
            brand: $data['brand'],
            model: $data['model'],
            version: $data['version'],
            price: new Price((int) $data['price']),
            location: new Location($data['city'], $data['uf'])
        );
    }
}
