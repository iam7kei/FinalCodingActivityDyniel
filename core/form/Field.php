<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public Model $model;
    public string $attribute;
    public string $name;
    public string $type;

    public function __construct($model, $attribute, $name, $type)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->name = $name;
        $this->type = $type;
    }

    public function select()
    {
        return sprintf(
            '
            <div class="form-group">
                <label class="form-label">%s</label>
                 <select class="form-control %s" id="inputGender" name="gender">
                    <option id="genderMale" value="male">Male</option>
                    <option id="genderFemale" value="female">Female</option>
                </select>
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->name,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->getFirstError($this->attribute)
        );
    }

    public function __toString()
    {
        return sprintf(
            '
            <div class="form-group">
                <label class="form-label">%s</label>
                <input type="%s" class="form-control%s" name="%s" value="%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->name,
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->getFirstError($this->attribute)
        );
    }
}
