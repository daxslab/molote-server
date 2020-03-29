<?php

namespace common\models;

use sjaakp\spatial\ActiveQuery;
/**
 * This is the ActiveQuery class for [[Crowd]].
 *
 * @see Crowd
 */
class CrowdQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Crowd[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Crowd|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function trusties(){

    }
}
