<?php

interface RepositoryInterface
{
    public function all(): array;
    public function create(string $title, string $author): bool;
    public function findById(int $id): array;
    public function update(string $title, string $author, int $id): bool;
    public function destroy(int $id): bool;
}
