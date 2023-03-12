<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Rifas;

/**
 * RifasSearch represents the model behind the search form of `backend\models\Rifas`.
 */
class RifasSearch extends Rifas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ticket_init', 'ticket_end', 'status'], 'integer'],
            [['name', 'description', 'terms', 'date_init', 'main_image'], 'safe'],
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
        $query = Rifas::find();

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
            'ticket_init' => $this->ticket_init,
            'ticket_end' => $this->ticket_end,
            'date_init' => $this->date_init,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'terms', $this->terms])
            ->andFilterWhere(['like', 'main_image', $this->main_image]);

        return $dataProvider;
    }
}
