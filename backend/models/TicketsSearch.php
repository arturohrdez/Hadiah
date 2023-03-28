<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tickets;

/**
 * TicketsSearch represents the model behind the search form of `backend\models\Tickets`.
 */
class TicketsSearch extends Tickets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rifa_id', 'parent_id'], 'integer'],
            [['ticket', 'date', 'date_end', 'phone', 'name', 'lastname', 'state', 'type', 'status'], 'safe'],
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
        //$query = Tickets::find();
        $query = Tickets::find()->joinWith(['rifa'])->where(['<>','rifas.status',0])->andWhere(['IS','parent_id',NULL]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => 20,
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
            'date' => $this->date,
            'date_end' => $this->date_end,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'tickets.ticket', $this->ticket])
            ->andFilterWhere(['like', 'tickets.phone', $this->phone])
            ->andFilterWhere(['like', 'tickets.name', $this->name])
            ->andFilterWhere(['like', 'tickets.lastname', $this->lastname])
            ->andFilterWhere(['like', 'tickets.state', $this->state])
            ->andFilterWhere(['like', 'tickets.type', $this->type])
            ->andFilterWhere(['=', 'tickets.status', $this->status]);

        return $dataProvider;
    }
}
