<?php

namespace Molovo\Market\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

  /**
   * Table prefix
   *
   * @var string
   */
  protected $prefix = '';

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = array())
  {
    parent::__construct($attributes);

    // Set the prefix
    $this->prefix = \Config::get('market.prefix', 'market_');

    $this->table = $this->prefix.$this->getTable();
  }

}