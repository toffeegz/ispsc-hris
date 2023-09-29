<?php

namespace App\Repositories\Base;

interface BaseRepositoryInterface
{
    public function lists(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'ASC');
    public function archives(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'ASC');
    public function show(string $id, $with = []);
    public function update(array $params, string $id);
    public function create(array $params);
    // public function updateOrCreate(array $refAttributes, array $attributes): Model;
    // public function firstOrCreate(array $referenceParams, array $additionalParams = []);
    public function delete(string $id);
    public function restore(string $id);

}
