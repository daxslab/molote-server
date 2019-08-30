<?php

namespace common\models;

use sjaakp\spatial\ActiveQuery;
/**
 * This is the ActiveQuery class for [[Pothole]].
 *
 * @see Pothole
 */
class PotholeQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pothole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pothole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function trusties(){

    }
}
