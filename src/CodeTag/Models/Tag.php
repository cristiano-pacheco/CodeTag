<?php


namespace CodePress\CodeTag\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

class Tag extends Model
{
    protected $table = "codepress_tags";

    protected $fillable = ['name'];

    /**
     * @var Validator
     */
    protected $validator;

    public function isValid()
    {
        $validator = $this->validator;

        $validator->setRules([
            'name' => 'required|max:255'
        ]);

        $validator->setData($this->getAttributes());

        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function posts()
    {
        return $this->morphedByMany('\CodePress\CodePost\Models\Post', 'taggable', 'codepress_taggables');
    }
}