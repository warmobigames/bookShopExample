<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

class BookByGenreFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // Otherwise filter is applied to order and page as well
        if (
            $property !== 'genres'
        ) {
            return;
        }

        foreach (explode(',',$value) as $genreName) {
            $parameterName = $queryNameGenerator->generateParameterName($property);
            $joinName = $queryNameGenerator->generateParameterName('genre');
            $queryBuilder
                ->join('o.genres', $joinName)
                ->orWhere($joinName.'.title = :'.$parameterName)
                ->setParameter($parameterName, $genreName);
        }
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["$property"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_ARRAY,
                'required' => false,
                'description' => 'Filter using array of genres',
                'openapi' => [
                    'example' => 'Детектив,Фантастика',
                    'explode' => false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}