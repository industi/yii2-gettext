<?php

namespace industi\yii2\gettext;

use yii\i18n\GettextMessageSource as GettextMessageSourceBase;

/**
 * Extended GettextMessageSource - added scope to message category
 *
 * @author Krzysztof Kurkowski <krzysztof.kurkowski@industi.com>
 */
class GettextMessageSource extends GettextMessageSourceBase {

  /**
   * @var string
   */
  public $scope = NULL;

  /**
   * @var array
   */
  protected $scopeCache = array();

  /**
   * @inheritdoc
   */
  protected function loadMessages($category, $language)
  {
    if ( !isset($this->scopeCache[$category]) ) {
      if ( !is_null($this->scope) ) {
        if ( strripos( $category, $this->scope ) === FALSE ) {
          throw new \Exception("Invalid translation category $category, not in scope: " . $this->scope );
        }
        $this->scopeCache[$category] = substr($category, strlen($this->scope));
      } else {
        $this->scopeCache[$category] = $category;
      }
    }
    return parent::loadMessages($this->scopeCache[$category], $language);
  }

}