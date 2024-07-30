<?php

namespace ClarionApp\ListsBackend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ClarionApp\EloquentMultiChainBridge\EloquentMultiChainBridge;

class ItemList extends Model
{
    use HasFactory, EloquentMultiChainBridge;

    protected $table = 'clarion_app_lists_item_lists';

    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
