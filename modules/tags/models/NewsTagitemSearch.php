<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem;

/**
 * NewsTagitemSearch represents the model behind the search form about `asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem`.
 */
class NewsTagitemSearch extends NewsTagitem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_visible'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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

        //$query = NewsTagitem::find();
        $contentClassname = $this->module->model('NewsTagitem')->className();
        $query = $this->module->model('NewsTagitemQuery', [$contentClassname]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // add sorting-link in header for 'title' column
        $dataProvider->sort->attributes['title'] = [
            'asc'  => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'main.id' => $this->id, // ambiguous: 'id' => $this->id,
            'is_visible' => $this->is_visible,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        // apply filter of 'title' column
        $query->andFilterWhere(['like', 'title', $this->title]);

        if (empty($params['sort'])) {
            $query->orderBy(self::$defaultOrderBy);
        }

        //list($sql, $sqlParams) = Yii::$app->db->getQueryBuilder()->build($query);var_dump($sql);var_dump($sqlParams);exit;
        return $dataProvider;
    }
}
