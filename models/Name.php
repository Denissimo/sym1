<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedNativeQueries;
use Doctrine\ORM\Mapping\NamedNativeQuery;
use Doctrine\ORM\Mapping\SqlResultSetMappings;
use Doctrine\ORM\Mapping\SqlResultSetMapping;
use Doctrine\ORM\Mapping\EntityResult;
use Doctrine\ORM\Mapping\FieldResult;

/**
 * @ORM\Entity
 * @NamedNativeQueries({
 *      @NamedNativeQuery(
 *          name            = "fetchNames",
 *          resultSetMapping= "mappingNames",
 *          query           = "SELECT fv.id, fv.app_id, fv.field_id, fv.value_item_id, fv.value_text, fv.value FROM field_values fv WHERE fv.field_id = 5"
 *      ),
 * })
 * @SqlResultSetMappings({
 *      @SqlResultSetMapping(
 *          name    = "mappingNames",
 *          entities= {
 *              @EntityResult(
 *                  entityClass = "__CLASS__",
 *                  fields      = {
 *                      @FieldResult(name = "id"),
 *                      @FieldResult(name = "appId"),
 *                      @FieldResult(name = "fieldId"),
 *                      @FieldResult(name = "valueItemId"),
 *                      @FieldResult(name = "valueText"),
 *                      @FieldResult(name = "value"),
 *                  }
 *              )
 *          }
 *      )
 * })
 *
 */
class Name
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;

    /** @Column(type="integer", nullable=false) */
    public $appId;

    /** @Column(type="integer", nullable=false) */
    public $fieldId;

    /** @Column(type="integer", nullable=false) */
    public $valueItemId;

    /** @Column(type="string", length=255, nullable=true) */
    public $valueText;

    /** @Column(type="string", length=255, nullable=true) */
    public $value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return mixed
     */
    public function getFieldId()
    {
        return $this->fieldId;
    }

    /**
     * @return mixed
     */
    public function getValueItemId()
    {
        return $this->valueItemId;
    }

    /**
     * @return mixed
     */
    public function getValueText()
    {
        return $this->valueText;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}