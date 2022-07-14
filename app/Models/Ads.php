<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Objects
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $text
 * @property int $price
 * @property string $foto_main
 * @property string $foto_2
 * @property string $foto_3
 */
class Ads extends Model
{
    use HasFactory;
    public $table = "ads";
}
