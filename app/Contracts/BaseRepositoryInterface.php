<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    /**
     * Tüm verileri çek
     * @all
     */
    public function all();


    public function paginate(int $perpage = 10);

    /**
     *
     */
    public function allWith($relation);

    /**
     * Verilen diziyi kaydet
     * @param array $array
     */
    public function store(array $array);

    /**
     * Belli bir içeriği göster
     * @show
     * @param int id
     */
    public function fetch(int $id);

    /**
     *
     */
    public function fetchWith(int $id, $relation);

    /**
     * İçeriği güncelle
     * @update
     * @param int id
     * @param array $array
     */
    public function update(array $array, int $id);

    /**
     * İçeriği sil
     * @delete
     * @param int id
     */
    public function delete(int $id);



    /**
     * Returns current model's path
     * @return string
     */
    public function getModelPath() : string;


    /**
     * Returns current model instance
     * @return App\Model
     */
    public function getModel();
}
