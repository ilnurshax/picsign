<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PictureSign
 * @package App\Models
 * @property int    id
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

    public function calculatePositionOfFullName()
    {
        return 730 - intdiv(mb_strlen($this->fullname), 2) * $this->multiplier();
    }

    public function calculatePositionOfCountry()
    {
        return 540 - intdiv(mb_strlen($this->country), 2) * $this->multiplier();
    }

    /**
     * @return int
     */
    protected function multiplier(): int
    {
        return 2;
    }
}
