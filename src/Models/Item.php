<?php

namespace ClarionApp\ListsBackend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MetaverseSystems\EloquentMultiChainBridge\EloquentMultiChainBridge;

class Item extends Model
{
    use HasFactory, EloquentMultiChainBridge;

    protected $table = 'clarion_app_lists_items';

    protected $fillable = ['name', 'item_list_id'];

    public function itemList()
    {
        return $this->belongsTo(ItemList::class);
    }
}
