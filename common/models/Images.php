<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $server_name
 * @property string|null $type
 * @property int|null $parameter_id
 */
class Images extends \yii\db\ActiveRecord
{

    const TYPEONE = 'icon';
    const TYPETWO = 'icon_grey';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parameter_id'], 'integer'],
            [['name', 'server_name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 9],
            [['type'], 'in', 'range' => [self::TYPEONE, self::TYPETWO]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'server_name' => 'Server Name',
            'type' => 'Type',
            'parameter_id' => 'Parameter ID',
        ];
    }
}
