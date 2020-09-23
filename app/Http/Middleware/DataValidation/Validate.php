<?php

namespace App\Http\Middleware\DataValidation;

use Closure;
use Illuminate\Support\Facades\Validator;

class Validate
{

    /**
     * The data that will be replaced with actual request
     * 
     * @var array
     */
    private $queued;


    /**
     * The original request data which model needs
     * 
     * @var array
     */
    private $originals = [];


    /**
     * Relational data
     * 
     * @var array
     */
    private $relation = [];


    /**
     * The data that is not validated but sent by the user any way
     * 
     * @var array
     */
    private $extras = [];


    /**
     * Set multipleData property
     */
    // public function __construct()
    // {
    //     $this->multipleData(request()->all());
    // }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {
        $data = $request->all();
        
        $this->validationLogic($model, $data);
        $this->save(); // save the changes(change the request)
        return $next($request);
    }



    /**
     * Validates given data with given rules
     * And wraps request data within 'data', 'relation' and 'extras' keys.
     */
    private function validationLogic($model, $requestData) 
    {
        if( ! method_exists($model, 'rules') || ! array_key_exists('data', $model::rules()) || ! array_key_exists('relation', $model::rules())) {
            abort(400, "İlgili model'da static rules() fonksiyonu doğru tanımlanmamış!");
        }
        $rules = $model::rules();

        // return $this->multipleData($requestData) 
        //     ? $this->validateMultiple($rules, $requestData) 
        //     : $this->validateOnly($rules, $requestData);

        return $this->validateOnly($rules, $requestData);

    }


    private function validateOnly($rules, $requestData)
    {
        $this->originals = $this->validate($rules['data'], $requestData);
        $this->relation = $this->validate($rules['relation'], $requestData);
        
        // The difference between request array and the others
        $this->extras = array_diff_key($requestData, array_merge($this->originals, $this->relation));

        return $this->queue();
    }


    // private function validateMultiple($rules, $requestData)
    // {
    //     foreach($requestData as $data) {
    //         $this->originals[] = $ptr1 = $this->validate($rules['data'], $data);
    //         $this->relation[] = $ptr2 = $this->validate($rules['relation'], $data);
    //         $this->extras[] = array_diff_key($data, array_merge($ptr1, (array) $ptr2));
    //     }
    //     return $this->queue();
    // }


    /**
     * Gathering arrays and get them ready to push into actual request.
     */
    private function queue() : void
    {
        $this->queued = [
            'data' => $this->originals,
            'relation' => $this->relation,
            'extras' => $this->extras,
            // 'multiple' => $this->multipleData(request()->all()),
        ];
    }


    /**
     * if validation fails, then abort and return a status code with errors
     */
    private function validate($rules, $data)
    {
        $validator = Validator::make($data, $rules);
        abort_if($validator->fails(), response(['message' => $validator->messages()->toArray()], 422));
        return $validator->validated();
    }

    
    /**
     * Sets the actual request
     * It will change the request() directly
     */
    private function save()
    {
        request()->replace($this->queued);
    }



    /**
     * Check if child arrays have same literal keys
     * 
     * @param array $array
     * @return bool
     */
    // protected function multipleData(array $array): bool
    // {
    //     $keys = array_keys($array);

    //     if(count($array) == 1 && is_array($array[$keys[0]])) return true; // riskli
    //     if(count($array) == 1) return false;

    //     for($i = 0; $i < count($keys)-1; $i++) {
    //         if( ! is_array($array[$keys[$i]]) || array_diff_key($array[$keys[$i]], $array[$keys[$i+1]])) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

}