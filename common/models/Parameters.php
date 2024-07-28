<?php

namespace common\models;

use yii\web\UploadedFile;
use yii\helpers\Inflector;
use Yii;

/**
 * This is the model class for table "parameters".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 */
class Parameters extends \yii\db\ActiveRecord
{

    const TYPEONE = 1;
    const TYPETWO = 2;

    public $upload_icon;
    public $upload_icon_grey;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parameters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['type'], 'integer', 'min' => self::TYPEONE, 'max' => self::TYPETWO],
            [['title'], 'string', 'max' => 90],
            [['upload_icon', 'upload_icon_grey'], 'image', 'extensions' => 'jpeg, jpg, gif, png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
        ];
    }

    public function fields() {
        return [
            'id',
            'title',
            'type',
        ];
    }

    public function extraFields ()
    {
        return ['images'];
    }

    public function afterSave($insert, $changedAttributes) {
        
        $this->upload_icon = UploadedFile::getInstance($this, 'upload_icon');
        $this->upload_icon_grey = UploadedFile::getInstance($this, 'upload_icon_grey');

        if ($this->upload_icon) {
            if (!$insert) {
                if (($imgOne = Images::find()->where(['parameter_id' => $this->id])
                    ->andWhere(['type' => Images::TYPEONE])->one()) !== null) {
                    $imgOne->delete();
                }
            }
            $this->imageSave($this->upload_icon, self::TYPEONE);
        }

        if ($this->upload_icon_grey) {
            if (!$insert) {
                if (($imgTwo = Images::find()->where(['parameter_id' => $this->id])
                    ->andWhere(['type' => Images::TYPETWO])->one()) !== null) {
                    $imgTwo->delete();
                }
            }
            $this->imageSave($this->upload_icon_grey, self::TYPETWO);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function getImages() {
        return $this->hasMany(Images::className(), ['parameter_id' => 'id']);
    }

    public function getTypedImage(string $type) {
        foreach ($this->images as $image) {
            if ($image->type == $type) {
                return $image;
            }
        }
        return null;
    }

    private function imageSave(UploadedFile $image, int $type) {

        $folder = Yii::getAlias('@backend/web/img/');

        if(!file_exists($folder)) {
            mkdir($folder, 0775);
        }

        $baseName = $image->baseName;
        $fileExt = $image->extension;
        $originalName = $baseName . '.' . $fileExt;
        $canonicalBaseName = Inflector::slug($baseName, '_', true);
        $serverName = $canonicalBaseName . time() . '.' . $fileExt;
        $path = $folder . $serverName;
        if ($type == self::TYPETWO) {
            $imageType = Images::TYPETWO;
        } else {
            $imageType = Images::TYPEONE;
        }

        if ($image->saveAs($path)) {
            $imagesModel = new Images();
            $data = [
                'name' => $originalName,
                'server_name' => $serverName,
                'type' => $imageType,
                'parameter_id' => $this->id
            ];
            $imagesModel->load([$data], false);
            $imagesModel->save();
        }
    }
}
