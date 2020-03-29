<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Crowd;

/**
 * CrowdSearch represents the model behind the search form of `common\models\Crowd`.
 */
class CrowdSearch extends Crowd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['location', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Crowd::find()->where();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
