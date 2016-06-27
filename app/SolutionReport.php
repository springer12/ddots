<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionReport extends Model
{
    const STATUS_CE = 'CE';
    const STATUS_FF = 'FF';
    const STATUS_NC = 'NC';
    const STATUS_CC = 'CC';
    const STATUS_CT = 'CT';
    const STATUS_UE = 'UE';
    const STATUS_OK = 'OK';
    const STATUS_WA = 'WA';
    const STATUS_PE = 'PE';
    const STATUS_RE = 'RE';
    const STATUS_TL = 'TL';
    const STATUS_ML = 'ML';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'execution_time',
        'memory_peak',
    ];


    public static function getStatuses() {
        return [
            self::STATUS_CE,
            self::STATUS_FF,
            self::STATUS_NC,
            self::STATUS_CC,
            self::STATUS_CT,
            self::STATUS_UE,
            self::STATUS_OK,
            self::STATUS_WA,
            self::STATUS_PE,
            self::STATUS_RE,
            self::STATUS_TL,
            self::STATUS_ML,
        ];
    }
}
