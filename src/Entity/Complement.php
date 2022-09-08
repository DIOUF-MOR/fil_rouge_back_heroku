<?php

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    
    normalizationContext: ["groups" => ['complement:read',"boisson:read","frite:read"]],
    collectionOperations: ["get"],
    itemOperations: []
)]
class Complement{
    private $id;
}