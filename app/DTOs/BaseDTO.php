<?php

namespace App\DTOs;

use LogicException;
use ReflectionClass;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

abstract class BaseDTO
{

    /**
     * Publiczna fabryka – jedyny sposób tworzenia DTO z tablicy.
     */
    final public static function fromArray(array $data): static
    {
        $validated = static::validateData($data);

        return new static(...static::buildConstructorArgs($validated));
    }

    /**
     * Reguły walidacji w stylu Laravela.
     */
    abstract protected static function rules(): array;

    /**
     * Niestandardowe komunikaty (opcjonalne).
     */
    protected static function messages(): array
    {
        return [];
    }

    /**
     * Atrybuty (opcjonalne).
     */
    protected static function attributes(): array
    {
        return [];
    }

    private static function validateData(array $data): array
    {
        /** @var ValidatorFactory $validatorFactory */
        $validatorFactory = App::make(ValidatorFactory::class);

        $validator = $validatorFactory->make(
            $data,
            static::rules(),
            static::messages(),
            static::attributes()
        );

        return $validator->validate();
    }

    /**
     * Zbudowanie argumentów konstruktora na podstawie danych wejściowych
     * + walidacji Laravela + dopasowania do sygnatury konstruktora.
     */
    private static function buildConstructorArgs(array $validated): array
    {
        $ref  = new ReflectionClass(static::class);
        $ctor = $ref->getConstructor();

        if ($ctor === null) {
            throw new LogicException(static::class . ' must define a constructor.');
        }

        $args = [];

        foreach ($ctor->getParameters() as $param) {
            $name = $param->getName();

            if (!array_key_exists($name, $validated)) {
                if ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                    continue;
                }

                throw new InvalidArgumentException(
                    "Missing required constructor argument '{$name}' for " . static::class
                );
            }

            $args[] = $validated[$name];
        }

        return $args;
    }

    /**
     * Chroniony konstruktor bazowy – uniemożliwia new BaseDTO().
     */
    protected function __construct() {}

}
