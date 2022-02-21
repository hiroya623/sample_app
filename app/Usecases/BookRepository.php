<?php

namespace App\Usecases;

use App\Models\Book;
use RepositoryInterface;

class BookRepository implements RepositoryInterface
{
    public function all(): array
    {
        return Book::all()->toArray();
    }

    /**
     * @param string $title
     * @param string $author
     * @return bool
     */
    public function create(string $title, string $author): bool
    {
        $book = Book::create([
            'title' => $title,
            'author' => $author
        ]);

        return $book !== null;
    }

    public function findById(int $id): array
    {
        return Book::find($id)->toArray();
    }

    public function update(string $title, string $author, int $id): bool
    {
        $book = Book::find($id);
        $book->title = $title;
        $book->author = $author;
        return $book->save();
    }

    public function destroy(int $id): bool
    {
        return Book::find($id)->delete();
    }
}
