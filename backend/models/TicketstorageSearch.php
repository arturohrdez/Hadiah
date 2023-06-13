<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ticketstorage;

/**
 * TicketstorageSearch represents the model behind the search form of `backend\models\Ticketstorage`.
 */
class TicketstorageSearch extends Ticketstorage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rifa_id', 'parent_id'], 'integer'],
            [['ticket', 'folio', 'date', 'date_ini', 'date_end', 'expiration', 'phone', 'name', 'lastname', 'state', 'transaction_number', 'type', 'status', 'date_payment', 'type_sale', 'uuid', 'created_at', 'updated_at'], 'safe'],
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
        //$query = Ticketstorage::find();
        //$query = Ticketstorage::find()->where(['IS','parent_id',NULL]);
        $query = Ticketstorage::find()->joinWith(['rifa'])->where(['<>','rifas.status',0])->andWhere(['IS','parent_id',NULL]);
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
            'date' => $this->date,
            'date_ini' => $this->date_ini,
            'date_end' => $this->date_end,
            'parent_id' => $this->parent_id,
            'date_payment' => $this->date_payment,
        ]);

        $query->andFilterWhere(['=', 'ticket', $this->ticket])
            ->andFilterWhere(['=', 'folio', $this->folio])
            ->andFilterWhere(['=', 'expiration', $this->expiration])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['=', 'transaction_number', $this->transaction_number])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'type_sale', $this->type_sale])
            ->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
