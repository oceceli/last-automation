<?php

namespace App\Traits;

trait GlobalHelpers
{
    protected function in_array_recursive($needle, $haystack, $strict = false)
    {
        foreach($haystack as $item) {
            if(($strict ? $needle === $item : $needle == $item) || is_array($item) && $this->in_array_recursive($needle, $item, $strict)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Remove path and returns class name
     * @return String
     */
    protected function removePath(String $string) : String
    {
        return preg_replace('/.*\\\/', '', $string);
    }

    /**
     * Takes class string with path or not.
     * And then returns extracted model name.
     * It will only delete last capital letter ends with small letter
     * e.g. given App\Policies\UserPolicy will return 'User'
     */
    protected function extractModelName(String $string) : String
    {
        $string = $this->removePath($string);
        return preg_replace('/[A-Z][a-z]*$/','',$string);
    }


    /**
     * Returns $this->extractModelName() string as lowercase
     */
    protected function extractModelNameLowerCase(String $string) : String
    {
        return strtolower($this->extractModelName($string));
    }


    /**
     * @deprecated Use \Illuminate\Support\Str::plural instead
     */
    protected function makePlural($string)
    {
        $pattern = "/([bcdfghjklmnpqrstvwxyz])y$/";
        if (preg_match($pattern, $string)) {
            return preg_replace($pattern, '$1', $string). 'ies';
        } else if (preg_match('/s$/', $string)) {
            return $string . 'es';
        }
        return $string . 's';
    }



    protected function applyFunctions($data, $functions)
    {
        $functions = explode('|', $functions);
        foreach($functions as $function) {
            $data = $function($data);
        }
        return $data;
    }



    protected function toSnakeCase(String $string) : string
    {
        $string = $this->removePath($string);
        return strtolower(trim(preg_replace('/[A-Z]/', '_\0', $string),'_'));
    }


    protected function removeSnakeID($string) : string 
    {
        return ucfirst(preg_replace('/_id$/', '', $string));
    }


    protected function detectIDs(string $string) : bool
    {
        return preg_match('/_id$/', $string);
    }


    protected function valuesAreSame(array $array) : bool
    {
        for ($i=0; $i < count($array)-1; $i++) { 
            if($array[$i] != $array[$i+1])
                return false;
        } 
        return true;
    }

    /**
     * Bir dosyada belirtilen kısma string ekler.
     */
    function insert($string, $keyword, $body) {
        return substr_replace($string, PHP_EOL . $body, strpos($string, $keyword) + strlen($keyword), 0);
    }

    /**
     * Finds all pattern matches in the source and replaces them with given string
     * @param string $pattern The regexp for search in the source
     * @param string $replace Will be replaced with provided pattern within source
     * @param string $source Subject
     * @return string
     */
    protected function findAllAndReplace(string $pattern, string $replace, string $source)
    {
        preg_match_all($pattern, $source, $result); // result is all entries
        foreach ($result[0] as $string) {
            $source = str_replace($string, $replace, $source);
        }
        return $source;
    }


    /**
     * Ayr?k duran arrayler; 
     * 'name' => ['first', 'second', 'thirth'] olur
     * 
     * @param array $datas Two dimension array
     */
    public function arrayCompact(array $datas)
    {
        foreach ($datas as $masterKey => $data) {
            $keys[$masterKey] = array_keys($data);
            foreach ($data as $childkey => $content) {
                $result[$childkey][$masterKey] = $content;
            }
        }
        if (!$this->valuesAreSame($keys)) {
            return response()->json('?kinci katmandaki t�m diziler ayn? olmal?!', 422);
        }
        return $result;
    }


    /**
     * Sets data as an array whatever it gets
     */
    protected function ensureArray(&$data)
    {
        $data = is_array($data)
            ? $data
            : (array)$data;
    }



    

    


}
