<?php
namespace App\Domains\Product\Services;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductCategory;
use App\Repositories\Repository;
use App\Domains\Product\Interfaces\ProductCategoryServiceInterface;
use Illuminate\Support\Facades\DB;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    protected $model;
    public function __construct(ProductCategory $productCategory)
    {
        // set the model
        $this->model = new Repository($productCategory);
    }

    public function getActiveList()
    {
        return json_encode($this->model::where('status', 1)->get());
    }

    public function getById(string $id = NULL)
    {
        return $this->model->show($id);
    }

    public function getCompleteList()
    {
        return $this->model->all();
    }

    public function saveProductCategoryList($data)
    {
        $this->model->startTransaction();
        try {
            
            $resultResponse = $this->model->create($data);

        } catch (Exception $e) {

            $this->model->rollbackTransaction();

        }

        $this->model->completeTransaction();
        return $resultResponse;
    }
    
    public function update($data, $id)
    {
        $this->model->update($data, $id);
    }
    
    public function delete($id)
    {
        $this->model->delete($id);
    } 
}
