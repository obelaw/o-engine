<?php

namespace Obelaw\Models;

use Obelaw\Framework\Base\ModelBase;

class Compile extends ModelBase
{
    protected $table = 'o_compiles';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'json',
    ];
}
