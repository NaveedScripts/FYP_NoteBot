<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use HasFactory;
    protected $table = ('books');

    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    public function content()
    {
        return $this->hasOne(ContentModel::class, 'book_id', 'id');
    }
}


