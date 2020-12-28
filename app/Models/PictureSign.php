<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PictureSign
 * @package App\Models
 * @property int id
 * @property string hash
 * @property string country
 * @property string fullname
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PictureSign extends Model
{
    use HasFactory;

    public function getPath()
    {
        return "signed/{$this->hash}.jpg";
    }
}
