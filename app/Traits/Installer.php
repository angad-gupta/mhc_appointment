<?php


namespace App\Traits;


use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Request;

trait Installer
{
    /**
     * Update session cache for database
     *
     * @param Request $request
     */
    public function setConfigDB(Request $request)
    {
        config([
            'database.connections.mysql.host' => $request->db_host,
            'database.connections.mysql.port' => $request->db_port,
            'database.connections.mysql.database' => $request->db_name,
            'database.connections.mysql.username' => $request->db_user_name,
            'database.connections.mysql.password' => $request->db_password
        ]);
    }

    /**
     * Update session cache for database from env variable
     */
    public function setDBConfigFromEnv()
    {
        config([
            'database.connections.mysql.host' => env('DB_HOST'),
            'database.connections.mysql.port' => env('DB_PORT'),
            'database.connections.mysql.database' => env('DB_DATABASE'),
            'database.connections.mysql.username' => env('DB_USERNAME'),
            'database.connections.mysql.password' => env('DB_PASSWORD')
        ]);
    }

    /**
     * Update env variable for database
     *
     * @param Request $request
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function changeEnvValuesForDB(Request $request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'DB_HOST' => '"' . $request->db_host . '"',
            'DB_PORT' => '"' . $request->db_port . '"',
            'DB_DATABASE' => '"' . $request->db_name . '"',
            'DB_USERNAME' => '"' . $request->db_user_name . '"',
            'DB_PASSWORD' => '"' . $request->db_password . '"',
            'INSTALL_STEP_DATABASE' => 1,
        ]);
    }


    /**
     * Set mail in current cache
     * @param Request $request
     */
    public function setConfigMail(Request $request)
    {
        config([
            'mail.host' => $request->mail_host,
            'mail.port' => (int)$request->mail_port,
            'mail.username' => $request->mail_username,
            'mail.password' => $request->mail_password,
            'mail.encryption' => $request->mail_encryption == 'null' ? null : $request->mail_encryption,
            'mail.from.address' => $request->mail_from_address,
            'mail.from.name' => $request->mail_from_name,
        ]);
    }

    /**
     * Store mail env variable
     *
     * @param Request $request
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function changeEnvValueMail(Request $request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'MAIL_HOST' => '"' . $request->mail_host . '"',
            'MAIL_PORT' => '"' . $request->mail_port . '"',
            'MAIL_USERNAME' => '"' . $request->mail_username . '"',
            'MAIL_PASSWORD' => '"' . $request->mail_password . '"',
            'MAIL_ENCRYPTION' => $request->mail_encryption == 'null' ? null : $request->mail_encryption,
            'MAIL_FROM_ADDRESS' => '"' . $request->mail_from_address . '"',
            'MAIL_FROM_NAME' => '"' . $request->mail_from_name . '"',
            'INSTALL_STEP_MAIL' => 1,
        ]);
    }

    /**
     * Save personalization env variable
     *
     * @param Request $request
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function savePersonalization(Request $request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_URL' => '"' . $request->app_url . '"',
            'APP_NAME' => '"' . $request->app_name . '"',
            'APP_DEBUG' => '"' . $request->app_debug . '"',
            'APP_LOCAL' => '"' . $request->app_local . '"',
            'APP_TIMEZONE' => '"' . $request->timezone . '"',
        ]);
    }

    /**
     * Change status to installed
     *
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function setStatusToInstallDone()
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'INSTALL_STEP_FINISH' => 1,
        ]);
    }
}