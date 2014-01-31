<?php

use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name', 1000);
            $table->string('email')->unique();
            $table->string('password', 1000);
            $table->string('mobile', 1000)->nullable();
            $table->bigInteger('credits')->default(0);
            $table->boolean('isVerified')->default(false);
            $table->string('emailVerificationCode')->nullable();
            $table->string('forgottenPasswordCode')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //create roles table
        Schema::create('roles', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        //create Users Roles pivot table
        Schema::create('role_user', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->integer('role_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('userSettings', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('hostName', 100)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->integer('port')->nullable();
            $table->string('smsApiUrl', 1000)->nullable();
            $table->string('smsSenderId', 100)->nullable();
            $table->string('smsUsername', 100)->nullable();
            $table->string('smsPassword', 100)->nullable();
            $table->boolean('isSmsEnabled')->nullable();
            $table->boolean('isEmailEnabled')->nullable();
            $table->timestamps();
        });

        Schema::create('imports', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name', 1000);

            $table->string('filePath', 1000);

            //1 - uploaded, 2 - in-process, 3 - Imported, 4 - processed
            $table->integer('status');

            //total numbers imported
            $table->integer('importCount')->nullable();

            //total new numbers
            $table->integer('newNumberCount')->nullable();


            $table->integer('sentEmailCount')->nullable();


            $table->integer('sentSmsCount')->nullable();
            $table->integer('invalidCount')->nullable();
            $table->integer('otherCount')->nullable();

            //10 - Low, 20 - Normal, 30 - High
            $table->integer('priority')->nullable();
            $table->timestamps();
        });

        Schema::create('phoneNumbers', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('std', 10)->nullable();
            $table->string('number', 100);
            $table->string('phoneNumber', 100)->unique();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::create('imports_phoneNumbers', function ($table) {
            $table->integer('phone_number_id')->index()->unsigned();
            $table->foreign('phone_number_id')->references('id')->on('phoneNumbers')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('import_id')->index()->unsigned();
            $table->foreign('import_id')->references('id')->on('imports')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('contacts', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name', 200);
            $table->string('email', 200)->nullable();
            $table->string('age', 100)->nullable();
            $table->string('income', 100)->nullable();
            $table->string('city', 200)->nullable();
            $table->string('education', 100)->nullable();
            $table->string('mobile1', 50)->nullable();
            $table->integer('mobile1Id')->index()->unsigned()->nullable();
            $table->integer('mobile1Status')->nullable();
            $table->boolean('mobile1DNCStatus')->nullable();
            $table->integer('importId')->index()->unsigned();
            $table->foreign('importId')->references('id')->on('imports')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('campaigns', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title', 1000);
            $table->string('messageText', 1000)->nullable();
            $table->boolean('isEmailEnabled')->default(false);
            $table->boolean('isSmsEnabled')->nullable(false);
            $table->boolean('campaignStatus')->default(false);
            $table->dateTime('startDate')->nullale();
            $table->dateTime('endDate')->nullable();
            $table->timestamps();
        });
        Schema::create('smsTransactions', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('uuid', 100)->unique();
            $table->integer('campaign_id')->index()->unsigned();
            $table->integer('phoneNumber_id')->index()->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('phoneNumber_id')->references('id')->on('phoneNumbers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phoneNumber', 100);
            $table->smallInteger('status');
            $table->text('result')->nullable();
            $table->timestamps();
        });
        Schema::create('groups', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name', 100);
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('groupContacts', function ($table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name', 100);
            $table->integer('group_id')->index()->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('contact_id')->index()->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_user', function ($table) {
            $table->dropForeign('role_user_user_id_foreign');
            $table->dropForeign('role_user_role_id_foreign');
        });
        Schema::table('userSettings', function ($table) {
            $table->dropForeign('usersettings_user_id_foreign');
        });
        //
        Schema::table('imports_phoneNumbers', function ($table) {
            $table->dropForeign('imports_phonenumbers_phone_number_id_foreign');
            $table->dropForeign('imports_phonenumbers_import_id_foreign');
        });

        Schema::table('contacts', function ($table) {
            $table->dropForeign('contacts_importid_foreign');
        });

        Schema::table('smsTransactions', function ($table) {
            $table->dropForeign('smstransactions_campaign_id_foreign');
            $table->dropForeign('smstransactions_phonenumber_id_foreign');
        });
        Schema::table('groups', function ($table) {
            $table->dropForeign('groups_user_id_foreign');

        });
        Schema::table('campaigns', function ($table) {
            $table->dropForeign('campaigns_user_id_foreign');

        });
        Schema::table('groupcontacts', function ($table) {
            $table->dropForeign('groupcontacts_group_id_foreign');
            $table->dropForeign('groupcontacts_contact_id_foreign');

        });
        Schema::drop('contacts');
        Schema::drop('smsTransactions');
        Schema::drop('groups');
        Schema::drop('groupContacts');
        Schema::drop('campaigns');

        Schema::drop('imports_phoneNumbers');
        Schema::drop('imports');
        Schema::drop('phoneNumbers');
        Schema::drop('role_user');
        Schema::drop('roles');
        Schema::drop('users');
        Schema::drop('userSettings');

    }

}