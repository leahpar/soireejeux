<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository as EasyAdminEntityRepository;

class EntityRepository extends EasyAdminEntityRepository
{

    protected function addOrderClause(QueryBuilder $queryBuilder, SearchDto $searchDto, EntityDto $entityDto): void
    {
        foreach ($searchDto->getSort() as $sortProperty => $sortOrder) {
            $aliases = $queryBuilder->getAllAliases();
            $sortFieldIsDoctrineAssociation = $entityDto->isAssociation($sortProperty);

            if ($sortFieldIsDoctrineAssociation) {
                $sortFieldParts = explode('.', $sortProperty, 2);
                // check if join has been added once before.
                if (!\in_array($sortFieldParts[0], $aliases, true)) {
                    $queryBuilder->leftJoin('entity.'.$sortFieldParts[0], $sortFieldParts[0]);
                }

                if (1 === \count($sortFieldParts)) {
                    $queryBuilder->addOrderBy('entity.'.$sortProperty, $sortOrder);
                } else {
                    $queryBuilder->addOrderBy($sortProperty, $sortOrder);
                }
            } elseif (str_starts_with($sortProperty, 'rand')) {
                $queryBuilder->addOrderBy('RAND()');
                dump(2);
            } else {
                $queryBuilder->addOrderBy('entity.'.$sortProperty, $sortOrder);
            }
        }
    }

}
