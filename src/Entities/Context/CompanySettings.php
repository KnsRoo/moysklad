<?php

namespace MoySklad\Entities\Context;

use MoySklad\Components\Specs\QuerySpecs\QuerySpecs;
use MoySklad\MoySklad;
use MoySklad\Registers\ApiUrlRegistry;

class CompanySettings extends AbstractContext {
    public static $entityName = "companysettings";
    /**
     * @var string $customQueryUrl
     */
    protected static $customQueryUrl;

    /**
     * @param MoySklad $skladInstance
     * @param QuerySpecs|null $querySpecs
     * @return \MoySklad\Components\Query\EntityQuery
     */
    public static function query(MoySklad &$skladInstance, QuerySpecs $querySpecs = null)
    {
        $query = parent::query($skladInstance, $querySpecs)
            ->setCustomQueryUrl(ApiUrlRegistry::instance()->getContextUrl(static::$entityName));
        return $query;
    }
}
