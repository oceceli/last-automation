<?php

namespace App\Http\Controllers\Traits;

use App\Common\Factories\Instantiator;
use App\Common\Factories\ModelFactory;
use Illuminate\Http\Request;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Illuminate\Support\Str;

trait DefaultController
{
    use ControllerHelpers, Resources;

    /**
     * Repository instance
     */
    protected $repository;


    /**
     * Determines whether authorization should use or not.
     * It should be set true within constructor of the class if there is a policy
     * @var boolean
     */
    protected $authorization = false;


    /**
     * Validation on/off
     * Model class have to have a static rules() function for validator to validate the request data.
     * Should be set in controller's construct
     */
    private $validation = false;



    public $view = 'web.layouts.welcome';


    public function index()
    {
        return view($this->view);
    }

    // public function index() {
    //     $this->grantAccess('viewAny');

    //     $all = $this->repository->all();
    //     return $this->decideResource($all);
    // }


    public function getRelated($main, $id, $related) // categories/1/products
    {
        // RequestHandler::getRelated($mainInstance->$related);

        $mainPath = ModelFactory::make($main);
        $mainInstance = Instantiator::make($main, $id);

        if( ! method_exists($mainPath, $related)) {
            throw new MethodNotFoundException(Str::singular($main) . ' modelinde ' .$related . ' methodu bulunamadı!', Str::singular($main), $related);
        }
        // RequestHandler::getRelated($mainInstance->$related->first());

        $resource = $this->decideResource($mainInstance->$related, $related);
        return $resource->related($main, $id, $related);
    }


    public function getRelationships($main, $id, $related) // categories/1/relationships/products
    {
        $mainPath = ModelFactory::make($main);
        $mainInstance = Instantiator::make($main, $id);

        if( ! method_exists($mainPath, $related)) {
            throw new MethodNotFoundException(Str::singular($main) . ' modelinde ' .$related . ' methodu bulunamadı!', Str::singular($main), $related);
        }

        $resource = $this->decideResource($mainInstance->$related, $related);
        return $resource->relationships($main, $id, $related);
    }




    public function show($id)
    {
        $this->grantAccess('view');

        $fetched = $this->repository->fetch($id);
        return $this->decideResource($fetched);
    }

    public function paginate()
    {
        $this->grantAccess('viewAny');

        $paginate = $this->repository->paginate();
        if (request()->is('api/*'))
            return $this->CollectionOrNot($paginate);
        return $this->webPaginate();
    }

    public function store(Request $request)
    {
        $this->grantAccess('create');
        return $this->ResourceOrNot($this->repository->store($this->processedData()), 201);
    }



    public function update($id)
    {
        $this->grantAccess('update');

        $updated = $this->repository->update($this->processedData(), $id);
        if (request()->is('api/*')) {
            return $this->ResourceOrNot($updated);
        }
        return $this->webUpdate($id);
    }


    public function destroy($id)
    {
        $this->grantAccess('delete');
        return $this->repository->delete($id);

    }


    /**
     * If $authorization property set true, then authorize() method will work
     * In case of true, there must be a policy with model's name and the 'Policy' suffix
     * eg. 'UserPolicy'
     * @param String $ability
     * @return void
     */
    private function grantAccess(String $ability)
    {
        if ($this->authorization)
            $this->authorize($ability, $this->getModelPath());
    }


    /**
     * Data validation logic.
     * Given getModelPath() represents the model's name string eg. "\App\Models\User"
     * And the validateData is a middleware that responsible for validating the array data
     * which is given by eg. "\App\Models\User" for this case.
     */
    protected function validateData(array $only) // should be called in controller's _construct method
    {
        $this->middleware('validateData:\\' . $this->getModelPath())->only($only); // validateData alias is in the http/kernel
        $this->validation = true; // inform that validation is enabled for the script.

        // $this->middleware('validateData:\\' . $this->getModelPath(), ['only' => $only]);
    }

    /**
     * @return mixed|array
     */
    protected function processedData()
    {
        if ($this->validation) {
            return request()->all()['data'];
        }
        return request()->all();
    }

    protected function processedRelations()
    {
        return request()['relation'];
    }



    /**********************************************************
     * Helper methods for repository
     **********************************************************/

    protected function getModelPath()
    {
        return $this->repository->getModelPath();
    }


}
