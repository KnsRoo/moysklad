<?php

namespace MoySklad\Entities\Context;

use MoySklad\Components\Specs\QuerySpecs\QuerySpecs;
use MoySklad\Entities\AbstractEntity;
use MoySklad\Entities\Employee;
use MoySklad\MoySklad;
use MoySklad\Registers\ApiUrlRegistry;
use MoySklad\Lists\EntityList;

class AbstractContext extends AbstractEntity {
    public static $entityName = "a_context";
    /**
     * @param \stdClass $attributes
     * @param $skladInstance
     * @return \stdClass
     */
    public static function listQueryResponseAttributeMapper($attributes, $skladInstance){
        if ( isset($attributes->context->employee) ){
            $attributes->context->employee = new Employee($skladInstance, $attributes->context->employee);
        }
        return $attributes;
    }

    public static function getMetaData(MoySklad $sklad){
        $res = $sklad->getClient()->get(
            ApiUrlRegistry::instance()->getContextMetadataUrl(static::$entityName)
        );
        $attributes = (isset($res->attributes)?$res->attributes:[]);
        $attributes = new EntityList($sklad, $attributes);
        $res->attributes = $attributes->map(function($e) use($sklad){
            return new Attribute($sklad, $e);
        });
        $states = new EntityList($sklad, isset($res->states) ? $res->states : []);
        $res->states = $states->map(function($e) use($sklad){
            return new State($sklad, $e);
        });
        return $res;
    }
}
