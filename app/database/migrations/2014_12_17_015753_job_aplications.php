<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobAplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create('jobs', function($tab){

            $tab->increments('id');
            $tab->string('title', 128);
            $tab->string('orgname', 128);
            $tab->string('email', 128);
            $tab->text('description');
            $tab->integer('salary');
            $tab->string('slug', 128);
            $tab->boolean('enabled');
            $tab->timestamps();

        });

		Schema::create('appls', function($tab){

            $tab->increments('id');
            $tab->string('firstlastname', 128);
            $tab->string('email', 128);
            $tab->string('notice', 128);
            $tab->text('education');
            $tab->text('experience');
            $tab->string('slug', 128);
            $tab->boolean('enabled');
            $tab->timestamps();

        });

 	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		Schema::drop('vacancies');

		Schema::drop('applications');

	}

}

