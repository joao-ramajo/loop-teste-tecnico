<?php

use Domain\ValueObjects\Location;

it('cria um Location válido com sucesso', function () {
    $location = new Location('Mogi das Cruzes', 'SP');

    expect($location)->toBeInstanceOf(Location::class);
    expect($location->city)->toBe('Mogi das Cruzes');
    expect($location->uf)->toBe('SP');
    expect($location->format())->toBe('Mogi das Cruzes - SP');
});

it('aceita UF em minúsculo e converte corretamente', function () {
    $location = new Location('São Paulo', 'sp');

    expect($location->uf)->toBe('sp');  // o valor armazenado é o passado
    expect($location->format())->toBe('São Paulo - sp');
});

it('não permite UF inválida', function ($uf) {
    new Location('Mogi', $uf);
})
    ->throws(InvalidArgumentException::class)
    ->with([
        'S',  // muito curta
        'SPO',  // muito longa
        '1P',  // número
        'P$',  // caractere inválido
        'Sp ',  // espaço
        '',  // vazia
    ]);

it('não permite cidade vazia', function ($cidade) {
    new Location($cidade, 'SP');
})
    ->throws(InvalidArgumentException::class)
    ->with([
        '',
        '   ',
        "\n",
    ]);

it('formata corretamente com o método format()', function () {
    $location = new Location('Rio de Janeiro', 'RJ');

    expect($location->format())->toBe('Rio de Janeiro - RJ');
});
