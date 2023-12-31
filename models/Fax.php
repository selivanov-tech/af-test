<?php

namespace app\models;

use app\src\Activity\HistoryEvents\DomainEventCollection;
use app\src\Activity\HistoryEvents\Fax\Incoming;
use app\src\Activity\HistoryEvents\Fax\Outgoing;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use app\src\Activity\Traits\HistoryRelationTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "fax".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $user_id
 * @property string $from
 * @property string $to
 * @property integer $status
 * @property integer $direction
 * @property integer $type
 * @property string $typeText
 *
 * @property User $user
 */
class Fax extends ActiveRecord implements IHistoryAbleModel
{
    use HistoryRelationTrait;

    const DIRECTION_INCOMING = 0;
    const DIRECTION_OUTGOING = 1;

    const TYPE_POA_ATC = 'poa_atc';
    const TYPE_REVOCATION_NOTICE = 'revocation_notice';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['ins_ts'], 'safe'],
            [['user_id'], 'integer'],
            [['from', 'to'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Created Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public static function getTypeTexts()
    {
        return [
            self::TYPE_POA_ATC => Yii::t('app', 'POA/ATC'),
            self::TYPE_REVOCATION_NOTICE => Yii::t('app', 'Revocation'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getTypeText()
    {
        return self::getTypeTexts()[$this->type] ?? $this->type;
    }

    public function historyEvents(): DomainEventCollection
    {
        return DomainEventCollection::create($this, [
            Incoming::class,
            Outgoing::class
        ]);
    }
}
