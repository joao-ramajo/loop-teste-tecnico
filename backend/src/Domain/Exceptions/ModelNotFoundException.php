<?php

declare(strict_types=1);

namespace Domain\Exceptions;

use DI\NotFoundException;
use Exception;

class ModelNotFoundException extends NotFoundException
{
}