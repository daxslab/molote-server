<?php

namespace common\models;

use sjaakp\spatial\ActiveQuery;
/**
 * This is the ActiveQuery class for [[Report]].
 *
 * @see Report
 */
class ReportQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Report[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Report|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
