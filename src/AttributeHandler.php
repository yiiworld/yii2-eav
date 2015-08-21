<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace mirocow\eav;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\db\ActiveRecord;

/**
 * Class AttributeHandler
 * @package mirocow\eav
 */
class AttributeHandler extends Widget
{
    const VALUE_HANDLER_CLASS = '\mirocow\eav\RawValueHandler';
    /** @var EavModel */
    public $owner;
    /** @var ValueHandler */
    public $valueHandler;
    /** @var ActiveRecord */
    public $attributeModel;
    
    public $nameField = 'name';

    /**
     * @param EavModel $owner
     * @param ActiveRecord $attributeModel
     * @return AttributeHandler
     * @throws \yii\base\InvalidConfigException
     */
    public static function load($owner, $attributeModel)
    {
        if (!class_exists($class = $attributeModel->type->handlerClass))
            throw new InvalidParamException('Unknown class: ' . $class);

        $handler = Yii::createObject([
            'class' => $class,
            'owner' => $owner,
            'attributeModel' => $attributeModel
        ]);
        $handler->init();

        return $handler;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->valueHandler = Yii::createObject([
            'class' => static::VALUE_HANDLER_CLASS,
            'attributeHandler' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function getAttributeName()
    {
        return $this->owner->fieldPrefix . strval($this->attributeModel->{$this->nameField});
    }

    public function getOptions()
    {
        $result = [];
        foreach ($this->attributeModel->options as $option)
            $result[] = $option->getPrimaryKey();
        return $result;
    }
}