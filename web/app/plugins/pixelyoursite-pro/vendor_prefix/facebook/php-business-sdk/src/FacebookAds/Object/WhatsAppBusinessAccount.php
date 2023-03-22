<?php

/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */
namespace PYS_PRO_GLOBAL\FacebookAds\Object;

use PYS_PRO_GLOBAL\FacebookAds\ApiRequest;
use PYS_PRO_GLOBAL\FacebookAds\Cursor;
use PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface;
use PYS_PRO_GLOBAL\FacebookAds\TypeChecker;
use PYS_PRO_GLOBAL\FacebookAds\Object\Fields\WhatsAppBusinessAccountFields;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountCategoryValues;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountTasksValues;
/**
 * This class is auto-generated.
 *
 * For any issues or feature requests related to this class, please let us know
 * on github and we'll fix in our codegen framework. We'll not be able to accept
 * pull request for this class.
 *
 */
class WhatsAppBusinessAccount extends \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject
{
    /**
     * @return WhatsAppBusinessAccountFields
     */
    public static function getFieldsEnum()
    {
        return \PYS_PRO_GLOBAL\FacebookAds\Object\Fields\WhatsAppBusinessAccountFields::getInstance();
    }
    protected static function getReferencedEnums()
    {
        $ref_enums = array();
        $ref_enums['Tasks'] = \PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountTasksValues::getInstance()->getValues();
        $ref_enums['Category'] = \PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountCategoryValues::getInstance()->getValues();
        return $ref_enums;
    }
    public function deleteAssignedUsers(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('user' => 'int');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_DELETE, '/assigned_users', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getAssignedUsers(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('business' => 'string');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/assigned_users', new \PYS_PRO_GLOBAL\FacebookAds\Object\AssignedUser(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\AssignedUser::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createAssignedUser(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('tasks' => 'list<tasks_enum>', 'user' => 'int');
        $enums = array('tasks_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountTasksValues::getInstance()->getValues());
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/assigned_users', new \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getConversationAnalytics(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('conversation_directions' => 'list<conversation_directions_enum>', 'conversation_types' => 'list<conversation_types_enum>', 'country_codes' => 'list<string>', 'dimensions' => 'list<dimensions_enum>', 'end' => 'unsigned int', 'granularity' => 'granularity_enum', 'metric_types' => 'list<metric_types_enum>', 'phone_numbers' => 'list<string>', 'start' => 'unsigned int');
        $enums = array('conversation_directions_enum' => array('BUSINESS_INITIATED', 'UNKNOWN', 'USER_INITIATED'), 'conversation_types_enum' => array('FREE_ENTRY_POINT', 'FREE_TIER', 'REGULAR', 'UNKNOWN'), 'dimensions_enum' => array('CONVERSATION_DIRECTION', 'CONVERSATION_TYPE', 'COUNTRY', 'PHONE', 'UNKNOWN'), 'granularity_enum' => array('DAILY', 'HALF_HOUR', 'MONTHLY'), 'metric_types_enum' => array('CONVERSATION', 'COST', 'UNKNOWN'));
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/conversation_analytics', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function deleteMessageTemplates(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('name' => 'string');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_DELETE, '/message_templates', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getMessageTemplates(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('category' => 'list<category_enum>', 'content' => 'string', 'language' => 'list<string>', 'name' => 'string', 'name_or_content' => 'string', 'quality_score' => 'list<quality_score_enum>', 'status' => 'list<status_enum>');
        $enums = array('category_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountCategoryValues::getInstance()->getValues(), 'quality_score_enum' => array('GREEN', 'RED', 'UNKNOWN', 'YELLOW'), 'status_enum' => array('APPROVED', 'DELETED', 'DISABLED', 'IN_APPEAL', 'LOCKED', 'PENDING', 'PENDING_DELETION', 'REJECTED'));
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/message_templates', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createMessageTemplate(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('category' => 'category_enum', 'components' => 'list<map>', 'language' => 'string', 'name' => 'string');
        $enums = array('category_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\WhatsAppBusinessAccountCategoryValues::getInstance()->getValues());
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/message_templates', new \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getPhoneNumbers(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/phone_numbers', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createPhoneNumber(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('cc' => 'string', 'migrate_phone_number' => 'bool', 'phone_number' => 'string');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/phone_numbers', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function deleteProductCatalogs(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('catalog_id' => 'string');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_DELETE, '/product_catalogs', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getProductCatalogs(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/product_catalogs', new \PYS_PRO_GLOBAL\FacebookAds\Object\ProductCatalog(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\ProductCatalog::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createProductCatalog(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('catalog_id' => 'string');
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/product_catalogs', new \PYS_PRO_GLOBAL\FacebookAds\Object\ProductCatalog(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\ProductCatalog::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function deleteSubscribedApps(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_DELETE, '/subscribed_apps', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getSubscribedApps(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/subscribed_apps', new \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject(), 'EDGE', array(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createSubscribedApp(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/subscribed_apps', new \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getSelf(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/', new \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount(), 'NODE', \PYS_PRO_GLOBAL\FacebookAds\Object\WhatsAppBusinessAccount::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}
