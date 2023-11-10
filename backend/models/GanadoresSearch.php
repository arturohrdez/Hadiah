<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ganadores;

/**
 * GanadoresSearch represents the model behind the search form of `app\models\Ganadores`.
 */
class GanadoresSearch extends Ganadores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rifa_id', 'ticket_id'], 'integer'],
            [['description', 'type'], 'safe'],
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
        $query = Ganadores::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => 50,
            ]
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
            'rifa_id' => $this->rifa_id,
            'ticket_id' => $this->ticket_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['=', 'type', $this->type]);

        return $dataProvider;
    }
}
