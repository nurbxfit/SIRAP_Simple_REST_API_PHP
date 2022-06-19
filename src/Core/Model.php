<?php

namespace Core;

/**
 * Base model, other model in App will extends this Model;
 */
class Model {

    public array $rules = [];

    /**
     * We use this to populate our class object properties with values.
     */
    public function create($data){
        /**
         * We first loop thru data object we receive,
         * then check if given data have the same property as declared in the class
         * if yes, then we populated the declared properties with the value from 
         * the data that we passed.
         */
        foreach ($data as $key=>$value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }

    /**
     * example
     * Rules = [
     *  'fullname'=> ['required'=> true ],
     *  'email' => ['required' => true,'unique'=> true, 'max'=>'10'],
     * ]
     */
    public function validate(){
        /**
         * We loop thru the rules as $key => $rules.
         * we get the key value populated in our class
         * $value = $this->{$key},
         * then we loop thru rules,
         * if rules == 'require'; we check if have value
         * if rules == 'unique'; we check with SQL if value exists in db
         * if rules == 'max'; we check if $value <= $rules['max'];
         */
         $errors = [];
         foreach($this->rules as $key => $rule){
             $value = $this->{$key};

            //  echo "<br>value: $value len: ". strlen($value) . "<br>";
            //  echo json_encode($rule);
            foreach($rule as $rkey => $rvalue){
                // echo ' key:' . $rkey . ' value:' . $rvalue . '<br>';

                if($rkey === 'required' && !$value){
                    /**
                     * if rule == required but have no value,
                     * do something.
                     */
                    // echo "Invalid, $key have no value <br>";
                    $errors[$key]['required'] = "Invalid, value for $key is required";
                }
                if($rkey === 'max' && (strlen($value) > $rvalue)){
                    // echo "Invalid, $key value is more than $rvalue character <br>";
                    $errors[$key]['max'] = "Invalid, value for $key mus bet less than $rvalue";

                }
                if($rkey === 'min' && strlen($value) < $rvalue){
                    // echo "Invalid, $key value is less than minimum $rvalue character <br>";
                    $errors[$key]['min'] = "Invalid, value for $key must be more than $rvalue";

                }
                if($rkey === 'match' && !preg_match("/$rvalue/",$value)){
                    // echo "Invalid, $key value doesn't match the pattern $rvalue <br>";
                    $errors[$key]['required'] = "Invalid, value for $key doesn't match pattern string '$rvalue'";

                }
                if($rkey === 'isEmail' && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    // echo "Invalid, $key value doesn't match the email value <br>";
                    $errors[$key]['required'] = "Invalid, value for $key is not a valid email format!";
                }
            }
         }

         if(!empty($errors)){
             throw new exceptions\ModelValidationException($errors);
         }
    }
}