<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $loading_types = ['верхняя', 'боковая', 'задняя'];

            $table->bigIncrements('id');
            $table->json('direction')->comment('JSON массив контрольных точек');
            $table->double('distance')->comment('Планируемый пробег');
            $table->double('kilometrage')->nullable()->comment('Фактический пробег');
            // ПЛАН
            $table->dateTime('loading_from_order')->comment('План начала погрузки');
            $table->dateTime('unloading_from_order')->comment('План начала выгрузки');
            // ФАКТ
            // -- Погрузка
            $table->dateTime('arrived_for_loading')->nullable()->comment('Время прибытия на погрузку');
            $table->dateTime('loading_began')->nullable()->comment('Время начала погрузки');
            $table->dateTime('loading_end')->nullable()->comment('Время начала погрузки');
            // -- Выгрузка
            $table->dateTime('arrived_for_unloading')->nullable()->comment('Время прибытия на выгрузку');
            $table->dateTime('unloading_began')->nullable()->comment('Время начала выгрузки');
            $table->dateTime('unloading_end')->nullable()->comment('Время окончания выгрузки');

            $table->double('weight')->nullable()->comment('Вес груза');
            $table->string('cargo')->nullable()->comment('Тип груза');
            $table->set('loading_type', $loading_types)->nullable()->comment('Тип погрузки');
            $table->set('unloading_type', $loading_types)->nullable()->comment('Тип выгрузки');
            $table->bigInteger('logist')->comment('id логиста, ответственного за перевозку');
            $table->bigInteger('author')->comment('id создателя рейса');

            $table->foreign('logist')->reference('id')->on('logists')->onDelete('restrict');
            $table->foreign('author')->reference('id')->on('users')->onDelete('restrict');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('races');
    }
}
