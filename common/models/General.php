<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class General
 *
 * General model, with general behaviors
 *
 * @package common\models
 */
class General extends ActiveRecord
{
    /**
     * General behavior for creating data
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_modified',
                'value'              => function () {
                    return (new \DateTime(null))->format('Y-m-d H:i:s');
                },
            ]
        ];
    }
}