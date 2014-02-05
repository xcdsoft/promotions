@extends('layouts.default')
@section('breadcrumb')
<div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
    Home</a>
</div>
@stop
@section('titleBlock')
<h1>Create Campaign</h1>
@stop
@section('content')
<div class="row-fluid" ng-controller="Campaign_Create">
    <div class="span9">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="icon-align-justify"></i></span>
                <h5>Campaign Info</h5>
            </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal" method="post" action="#" name="basic_validate" id="basic_validate"
                      novalidate="novalidate">
                    <div class="control-group">
                        <label class="control-label">Title</label>

                        <div class="controls">
                            <input type="text" name="title" id="required" placeholder="Campaign Title" class="span6">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Message</label>

                        <div class="controls">
                            <textarea name="messageText" placeholder="Enter message text 160 characters long"
                                      class="ng-cloak span6" ng-model="message"></textarea>
                            <span ng-show="message.length>0" class="help-block">
                <i>
                    {{message.length}} character, {{getSingleMessageCredit()}} credit(s) required per person to
                    send this text.
                </i>
            </span>
            <span ng-show="message.length>320" class="text-error">
                <i>
                    maximum character limit exceeded {{320-message.length}}
                </i>
            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Start Date</label>

                        <div class="controls">
                            <input type="text" placeholder="Campaign Start Date" class="datepicker" name="startDate"
                                   data-date-format="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">End Date</label>

                        <div class="controls">
                            <input type="text" placeholder="Campaign End Date" class="datepicker" name="endDate"
                                   data-date-format="dd-mm-yyyy">
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">SMS Enabled</label>

                        <div class="controls">
                            <label>
                                <div class="radio" id="uniform-undefined"><span><input type="radio" name="smsEnabled"
                                                                                       value=1
                                                                                       style="opacity: 0;"></span></div>
                                Yes</label>
                            <label>
                                <div class="radio" id="uniform-undefined"><span><input type="radio" name="smsEnabled"
                                                                                       value=0
                                                                                       style="opacity: 0;"></span></div>
                                No</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Emails Enabled</label>

                        <div class="controls">
                            <label>
                                <div class="radio" id="uniform-undefined"><span><input type="radio" name="emailEnabled"
                                                                                       value=1
                                                                                       style="opacity: 0;"></span></div>
                                Yes</label>
                            <label>
                                <div class="radio" id="uniform-undefined"><span><input type="radio" name="emailEnabled"
                                                                                       value=0
                                                                                       style="opacity: 0;"></span></div>
                                No</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">SMS senders text</label>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Create" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="span3">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="icon-time"></i></span>
                <h5>Existing Campaigns</h5>

            </div>
            <div class="widget-content nopadding">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>SMS Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="taskDesc"><i class="icon-info-sign"></i> Marketing Bulk SMS</td>
                        <td class="taskStatus"><span class="in-progress">in progress</span></td>
                        <td class="taskOptions">120</td>
                    </tr>
                    <tr>
                        <td class="taskDesc"><i class="icon-info-sign"></i> Gurgaon Real Estate Messages</td>
                        <td class="taskStatus"><span class="in-progress">Completed</span></td>
                        <td class="taskOptions">120</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop