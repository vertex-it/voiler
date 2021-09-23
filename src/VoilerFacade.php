<?php

namespace VertexIT\Voiler;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VertexIt\Voiler\Skeleton\SkeletonClass
 */
class VoilerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'voiler';
    }
}
