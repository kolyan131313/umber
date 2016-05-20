<?php
namespace common\components\behaviors;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * By default, BlameableBehavior will fill the `created_by` and `updated_by`
 * attributes with the current user ID. This custom BlemeableBehavior will check
 * first if the current user is impersonated by someone else and if it's,
 * the attribute will be populated with the id of the impersonator
 *
 * @author Nick Kornyenko <kornyenko.nickolay@gmail.com>
 */
class CBlameableBehavior extends BlameableBehavior
{
    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $user = Yii::$app->get('user', false);

            if ($user && !$user->isGuest) {
                if (isset($user->identity->impersonatedBy) && $user->identity->impersonatedBy !== null) {
                    return $user->identity->impersonatedBy->id;
                } else {
                    return $user->id;
                }
            }

            return;
        } else {
            return call_user_func($this->value, $event);
        }
    }
}
