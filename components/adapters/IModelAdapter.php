<?php

interface IModelAdapter
{
    public function toArray($obj);
    public function fromArray($obj);
}
