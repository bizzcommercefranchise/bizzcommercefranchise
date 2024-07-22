<?php
namespace App\Domains\Product\Interfaces;

interface ProductCategoryServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveProductCategoryList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);    
}
        