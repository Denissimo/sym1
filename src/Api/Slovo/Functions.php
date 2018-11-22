<?php

namespace App\Api\Slovo;

use App\Proxy;
use PDO;

class Functions
{
    /**
     * @return \Doctrine\DBAL\Connection
     */
    private static function getDb()
    {
        return Proxy::init()->getEntityManager()->getConnection();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getValues($id)
    {
        $query = 'select f.*, fg.name as gname, fg.type as gtype from fields as f left join field_groups fg on fg.id=f.group_id where f.enabled=1 order by fg.orderNum asc, f.orderid asc';
        $sth = self::getDb()->prepare($query);
        $sth->execute();
        $values = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($values as $k => $row) {
            if (in_array($row['type'], array(2))) {
                $query = 'select id as dvid, value as dval, field_id from value_lists where field_id=' . (int) $row['id'] . ';';
                $sth = self::getDb()->prepare($query);
                $sth->execute();
                $vals = $sth->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($vals)) {
                    $zvid = 0;
                    foreach ($vals as $vk => $vv) {
                        $query = 'select id from field_values where app_id=' . $id . ' and field_id=' . (int) $row['id'] . ' and value_item_id=' . (int) $vv['dvid'];
                        $sth = self::getDb()->prepare($query);
                        $sth->execute();
                        $cnt = $sth->fetch(PDO::FETCH_ASSOC);
                        if ($cnt && $cnt['id'] > 0) {
                            $values[$k]['selected'] = $vv['dvid'];
                            $vals[$vk]['selected'] = true;
                            $zvid = $cnt['id'];
                        }
                    }
                    $values[$k]['val2'] = $vals;
                    $values[$k]['zvid'] = $zvid;
                } else {
                    unset($values[$k]);
                }
            } else {
                $query = 'select value_text as val, id as zvid, value_item_id as vid, value from field_values where app_id=' . $id . ' and field_id=' . (int) $row['id'];
                $sth = self::getDb()->prepare($query);
                $sth->execute();
                $val = $sth->fetch(PDO::FETCH_ASSOC);
                $values[$k]['vval'] = trim($val['val']);
                $values[$k]['zvid'] = intval($val['zvid']);
                $values[$k]['vid'] = intval($val['vid']);
                $values[$k]['vvalue'] = $val['value'];
            }
        }

        return $values;
    }

    public static function getValueText($id, $name)
    {
        $query = 'select fv.value_text as val from field_values fv left join `fields` f on f.id=fv.field_id where fv.app_id=:app_id and f.`name` = :name';
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('app_id' => $id, 'name' => $name));
        $val = $sth->fetch(PDO::FETCH_ASSOC);
        return $val['val'];
    }

    public static function getValueText2($id, $name)
    {
        $query = 'select fv.value as val from field_values fv left join `fields` f on f.id=fv.field_id where fv.app_id=:app_id and f.`name` = :name';
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('app_id' => $id, 'name' => $name));
        $val = $sth->fetch(PDO::FETCH_ASSOC);
        return $val['val'];
    }

    public static function getValueTextId($id, $name)
    {
        $query = 'select fv.value_item_id as val from field_values fv left join `fields` f on f.id=fv.field_id where fv.app_id=:app_id and f.`name` = :name and fv.value_item_id is not null';
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('app_id' => $id, 'name' => $name));
        $val = $sth->fetch(PDO::FETCH_ASSOC);
        return $val['val'];
    }

    public static function getValueItem($id, $name)
    {
        $query = 'select vl.value as val from field_values fv left join `fields` f on f.id=fv.field_id left join value_lists vl on vl.id=fv.value_item_id where fv.app_id=:app_id and f.`name` = :name';
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('app_id' => $id, 'name' => $name));
        $val = $sth->fetch(PDO::FETCH_ASSOC);
        return $val['val'];
    }

    public static function saveAppVersion($id, $uid)
    {
        $version=array('app'=>null, 'field_values'=>null);

        $query = "SELECT * FROM apps where id = :id";
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('id' => $id));
        $_tmp1 = $sth->fetch(PDO::FETCH_ASSOC);

        $query = "SELECT * FROM field_values where app_id = :id order by id asc";
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('id' => $id));
        $_tmp2 = $sth->fetchAll(PDO::FETCH_ASSOC);

        $version['app']=$_tmp1;
        $version['field_values']=$_tmp2;


        $query = "insert ignore into apps_versions set app_id=:app_id, ts=now(), uid=:uid, data = :version";
        $sth = self::getDb()->prepare($query);
        $dat=array('app_id' => $id, 'uid' => (int)$uid, 'version' => json_encode($version));
        $sth->execute($dat);

        return true;
    }

}