<?php

namespace App\Libraries;

use ErrorException;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Collection;

class Relationship
{
    public $name;
    public $type;
    public $model;
    // public $foreignKey;
    public $ownerKey;

    public function __construct($relationship = [])
    {
        if ($relationship) {
            $this->name = $relationship['name'];
            $this->type = $relationship['type'];
            $this->model = $relationship['model'];
            // $this->foreignKey = $relationship['foreignKey'];
            $this->ownerKey = $relationship['ownerKey'];
        }
    }
}