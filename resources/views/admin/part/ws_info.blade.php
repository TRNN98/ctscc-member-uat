<div class="admin-pro-accordion-wrap mg-b-15 shadow-reset">
    <div class="alert-title">
        <h1><b>System Configuration Detail</b> </h1>
        <br>
    </div>
    <div class="panel-group adminpro-custon-design" id="accordion">
        <div class="panel panel-default panelbox">
            <div class="panel-heading accordion-head">
                <h4 class="panel-title">
                    <a style="color:cadetblue;" data-toggle="collapse" data-parent="#accordion" href="#collapse1"
                        aria-expanded="false" class="collapsed">
                        <i class="fa fa-caret-down" style="font-size:26px;"></i>&nbsp; [SERVER INFO]
                    </a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse panel-ic collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body admin-panel-content animated bounce">
                    <div class="col-md-9">
                        <div class="col-md-3">
                            <fieldset>Server Name :</fieldset>
                            <fieldset>Server IP Address :</fieldset>
                            <fieldset>Server Port :</fieldset>
                            <fieldset>Server Software :</fieldset>
                            <fieldset>Document Root :</fieldset>
                            <fieldset>Sesstion Save Path :</fieldset>
                            <fieldset>Sesstion ID :</fieldset>
                            <fieldset>Browser :</fieldset>
                        </div>
                        <div class="col-md-9">
                            <fieldset><?=$_SERVER['SERVER_NAME']?></fieldset>
                            <fieldset><?=$_SERVER['REMOTE_ADDR']?></fieldset>
                            <fieldset><?=$_SERVER['SERVER_PORT']?></fieldset>
                            <fieldset><?=$_SERVER['SERVER_SOFTWARE']?></fieldset>
                            <fieldset><?=$_SERVER['DOCUMENT_ROOT']?></fieldset>
                            <fieldset><?=SESSION_PATH?></fieldset>
                            <fieldset><?=session_id()?></fieldset>
                            <fieldset><?=$_SERVER["HTTP_USER_AGENT"]?></fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panelbox">
            <div class="panel-heading accordion-head">
                <h4 class="panel-title">
                    <a style="color:cadetblue;" data-toggle="collapse" data-parent="#accordion" href="#collapse2"
                        class="collapsed" aria-expanded="false">
                        <i class="fa fa-caret-down" style="font-size:26px;"></i>&nbsp; [DATABASE CONFIG]
                    </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse panel-ic collapse" aria-expanded="false">
                <div class="panel-body admin-panel-content animated bounce">
                    <div class="col-md-9">
                        <div class="col-md-3">
                            <fieldset>Database Server :</fieldset>
                            <fieldset>Database Type :</fieldset>
                            <fieldset>Database User :</fieldset>
                            <fieldset>Database Passwd :</fieldset>
                            <fieldset>Dddatabase Name:</fieldset>
                            <fieldset>Database Char Name:</fieldset>
                            <fieldset>Database Collation :</fieldset>
                            <fieldset>Database Charset :</fieldset>
                        </div>
                        <div class="col-md-9">
                            <fieldset><?=_DBSERVER?></fieldset>
                            <fieldset><?=_DBTYPE?></fieldset>
                            <fieldset><?=_DBUSER?></fieldset>
                            <fieldset><?=_DBPASSWD?></fieldset>
                            <fieldset><?=_DBNAME?></fieldset>
                            <fieldset>-</fieldset>
                            <fieldset><?=_DBCOLLATION?></fieldset>
                            <fieldset><?=_DBCHAR_SET?></fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panelbox">
            <div class="panel-heading accordion-head">
                <h4 class="panel-title">
                    <a style="color:cadetblue;" data-toggle="collapse" data-parent="#accordion" href="#collapse3"
                        class="collapsed" aria-expanded="false">
                        <i class="fa fa-caret-down" style="font-size:26px;"></i>&nbsp; [SITE ENVIRONMENT]
                    </a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse panel-ic collapse" aria-expanded="false">
                <div class="panel-body admin-panel-content animated bounce">
                    <div class="col-md-9">
                        <div class="col-md-2">
                            <fieldset>Install Path :</fieldset>
                            <fieldset>Photo Path :</fieldset>
                            <fieldset>File Path :</fieldset>
                            <fieldset>Board Photo Path :</fieldset>
                            <fieldset>Board File Path :</fieldset>
                            <fieldset>Quwey String:</fieldset>
                            <fieldset>DateTime :</fieldset>
                            <fieldset>Request Page :</fieldset>
                        </div>
                        <div class="col-md-10">
                            <fieldset><?=ROOT_PATH?></fieldset>
                            <fieldset><?=PHOTO_PATH?> </fieldset>
                            <fieldset><?=FILE_PATH?></fieldset>
                            <fieldset><?=BOARD_PHOTO_PATH?></fieldset>
                            <fieldset><?=BOARD_FILE_PATH?></fieldset>
                            <fieldset><?=QUERYSTR?></fieldset>
                            <fieldset><?=DATETIME?></fieldset>
                            <fieldset><?=REQUEST_PAGE?></fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    div.panel.panel-default.panelbox {
        margin-right: 30px;
    }

    div.admin-pro-accordion-wrap.shadow-reset {
        margin-right: 35px;
        padding: 40px;
    }

    fieldset {
        border: none;
        font-size: 15px;
        padding: 8px;
    }
</style>
