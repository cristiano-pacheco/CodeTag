<?php


namespace CodePress\CodeTag\Repository;


use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeTag\Models\Tag;

class TagRepositoryEloquent extends AbstractRepository implements TagRepositoryInterface
{
    public function model()
    {
        return Tag::class;
    }
}