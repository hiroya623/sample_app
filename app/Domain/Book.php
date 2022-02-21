<?php

namespace App\Domain;

class Book
{
    public string $title;
    public string $author;

    public function __construct(string $title,string $author)
    {
        $this->title=$title;
        $this->author=$author;
    }

    public static function all(): array
    {
        $eloquentBooks=\App\Models\Book::all();
        $array =[];
        foreach ($eloquentBooks as $eloquentBook) {
            //EloquentModelのbookのmodelをDomainModelのbookに詰め替える。
            $array[] = new Book($eloquentBook->title,$eloquentBook->author);
        }
        return $array;
    }

    public static function create(string $title,string $author): Book
    {
        \App\Models\Book::create([
            'title'=> $title,
            'author'=> $author
        ]);

        return new Book($title,$author);
    }

    public static function findById($id): Book
    {
        $eloquentBook = \App\Models\Book::find($id);
        return new Book($eloquentBook->title,$eloquentBook->author);
    }

    public function update(string $title,string $author,int $id): bool
    {
        $eloquentBook = \App\Models\Book::find($id);
        $eloquentBook->title = $title;
        $eloquentBook->author = $author;
        return $eloquentBook->save();
    }


    public static function destroy(): bool
    {

    }
}
