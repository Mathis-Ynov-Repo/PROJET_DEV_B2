<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Plats;
use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

final class PlatsExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    private $repository;

    public function __construct(Security $security, RestaurantsRepository $restaurantsRepository)
    {
        $this->security = $security;
        $this->repository = $restaurantsRepository;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        //Permet de ne renvoyer que les plats du restaurant que possede le restaurateur
        if ($resourceClass !== Plats::class || !$this->security->isGranted('ROLE_RESTAURATEUR') || null === $user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.restaurant = :current_restaurant', $rootAlias));
        $queryBuilder->setParameter('current_restaurant', $this->repository->findOneBy(['user' => $user->getId()])->getId());
    }
}
