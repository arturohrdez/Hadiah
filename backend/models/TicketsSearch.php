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
            [['ticket', 'date', 'date_end','date_payment', 'phone', 'name', 'lastname', 'state', 'type', 'type_sale', 'status','transaction_number','expiration','folio'], 'safe'],
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
                'defaultPageSize' => 15,
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
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['=', 'tickets.ticket', $this->ticket])
            ->andFilterWhere(['=', 'tickets.folio', $this->folio]);

        $query->andFilterWhere(['=', 'tickets.phone', $this->phone])
            ->andFilterWhere(['like', 'tickets.name', $this->name])
            ->andFilterWhere(['like', 'tickets.lastname', $this->lastname])
            ->andFilterWhere(['like', 'tickets.state', $this->state])
            ->andFilterWhere(['=', 'tickets.transaction_number', $this->transaction_number])
            ->andFilterWhere(['like', 'tickets.type', $this->type])
            ->andFilterWhere(['=', 'tickets.type_sale', $this->type_sale])
            ->andFilterWhere(['like', 'tickets.date', $this->date])
            ->andFilterWhere(['like', 'tickets.date_payment', $this->date_payment])
            ->andFilterWhere(['=', 'tickets.status', $this->status])
            ->andFilterWhere(['=', 'tickets.expiration', $this->expiration]);

        return $dataProvider;
    }
}
