<?php

use yii\db\Migration;
use console\components\PecomAPI;
use console\models\Regions;
use console\models\Cities;

class m170621_180059_cities extends Migration
{
    protected $error;
    protected $countRegionRecords = 0;
    protected $countCityRecords = 0;

    /*public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170621_180059_cities cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'remote_id' => $this->integer(),
            'region_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->RecordToTable();

        if(!empty($this->error)) {
            echo $this->error;
        }

        if(!empty($this->countCityRecords) && !empty($this->countRegionRecords)) {
            $sum = $this->countCityRecords + $this->countRegionRecords;
            echo 'Записано регионов:' . $this->countRegionRecords . ' городов: ' . $this->countCityRecords . ' всего записей: '. $sum . PHP_EOL;
        }
    }

    //Записываем данные
    private function RecordToTable() {
        $pecom = new PecomAPI("https://pecom.ru/ru/calc/towns.php");

        $citiesArr = $pecom->execute()->getArray();

        foreach ($citiesArr as $regionname => $cities) {

            $modelregion = new Regions();

            $modelregion->name = $regionname;
            $modelregion->created_at = time();
            $modelregion->updated_at = time();

            if($modelregion->save()){
                $this->countRegionRecords++;
                $region_id = $modelregion->id;
            }
            else {
                $this->error .= 'Невозможно записать регион: ' . $regionname . PHP_EOL;
            }

            foreach ($cities as $city_id=>$city_name) {

                $modelcity = new Cities();

                $modelcity->name =$city_name;
                $modelcity->remote_id = (int)$city_id;
                $modelcity->region_id= $region_id;
                $modelcity->created_at = time();
                $modelcity->updated_at = time();

                if($modelcity->save()) {
                    $this->countCityRecords++;
                }
                else {
                    $this->error .= 'Невозможно записать город: ' . $city_name . PHP_EOL;
                }

            }

        }

    }

    public function down()
    {
        $this->dropTable('cities');
    }

}
