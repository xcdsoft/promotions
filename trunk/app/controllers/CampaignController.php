<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hitanshu
 * Date: 2/2/14
 * Time: 7:20 PM
 * To change this template use File | Settings | File Templates.
 */
class CampaignController extends BaseController
{
    public function getCreate()
    {
        return View::make('campaign/create');
    }
}
