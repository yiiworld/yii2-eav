<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace mirocow\eav;

/**
 * Class OptionValueHandler
 * @package mirocow\eav
 */
class OptionValueHandler extends ValueHandler
{
    /**
     * @inheritdoc
     */
    public function load()
    {
        $valueModel = $this->getValueModel();
        return $valueModel->optionId;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $EavModel = $this->attributeHandler->owner;
        $valueModel = $this->getValueModel();

        $valueModel->optionId =
            $EavModel->attributes[$this->attributeHandler->getAttributeName()];

        if (!$valueModel->save())
            throw new \Exception("Can't save value model");
    }

    public function getTextValue()
    {
        return $this->getValueModel()->option->value;
    }
}