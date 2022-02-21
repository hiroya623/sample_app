<?php

namespace App\Usecases;

use App\Domain\Book;
use RepositoryInterface;

class GetCollectionAction
{
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        $this->repository->all();

        $array =[];
        foreach ($this->repository->all() as $book) {
            //EloquentModelのbookのmodelをDomainModelのbookに詰め替える。
            $array[] = new Book($book->title,$book->author);
        }
        return $array;
    }
}
