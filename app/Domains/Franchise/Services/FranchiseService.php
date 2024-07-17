<?php
namespace App\Domains\Franchise\Services;

use App\Domains\Franchise\Models\Franchise;
use App\Domains\Product\Models\Product;
use App\Repositories\Repository;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use Illuminate\Support\Facades\DB;

class FranchiseService implements FranchiseServiceInterface
{
    protected $model;
    public function __construct(Franchise $franchise)
    {
        // set the model
        $this->model = new Repository($franchise);
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

    public function saveFranchiseList($data)
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