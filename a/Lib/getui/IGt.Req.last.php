<?php

namespace Lib\getui;

class CmdID extends PBEnum {

    const GTHEARDBT = 0;
    const GTAUTH = 1;
    const GTAUTH_RESULT = 2;
    const REQSERVHOST = 3;
    const REQSERVHOSTRESULT = 4;
    const PUSHRESULT = 5;
    const PUSHOSSINGLEMESSAGE = 6;
    const PUSHMMPSINGLEMESSAGE = 7;
    const STARTMMPBATCHTASK = 8;
    const STARTOSBATCHTASK = 9;
    const PUSHLISTMESSAGE = 10;
    const ENDBATCHTASK = 11;
    const PUSHMMPAPPMESSAGE = 12;
    const SERVERNOTIFY = 13;
    const PUSHLISTRESULT = 14;
    const SERVERNOTIFYRESULT = 15;

}

class GtAuth extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }

    function sign() {
        return $this->_get_value("1");
    }

    function set_sign($value) {
        return $this->_set_value("1", $value);
    }

    function appkey() {
        return $this->_get_value("2");
    }

    function set_appkey($value) {
        return $this->_set_value("2", $value);
    }

    function timestamp() {
        return $this->_get_value("3");
    }

    function set_timestamp($value) {
        return $this->_set_value("3", $value);
    }

    function seqId() {
        return $this->_get_value("4");
    }

    function set_seqId($value) {
        return $this->_set_value("4", $value);
    }

}

class GtAuthResult_GtAuthResultCode extends PBEnum {

    const successed = 0;
    const failed_noSign = 1;
    const failed_noAppkey = 2;
    const failed_noTimestamp = 3;
    const failed_AuthIllegal = 4;
    const redirect = 5;

}

class GtAuthResult extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }

    function code() {
        return $this->_get_value("1");
    }

    function set_code($value) {
        return $this->_set_value("1", $value);
    }

    function redirectAddress() {
        return $this->_get_value("2");
    }

    function set_redirectAddress($value) {
        return $this->_set_value("2", $value);
    }

    function seqId() {
        return $this->_get_value("3");
    }

    function set_seqId($value) {
        return $this->_set_value("3", $value);
    }

    function info() {
        return $this->_get_value("4");
    }

    function set_info($value) {
        return $this->_set_value("4", $value);
    }

}

class ReqServList extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function timestamp() {
        return $this->_get_value("3");
    }

    function set_timestamp($value) {
        return $this->_set_value("3", $value);
    }

}

class ReqServListResult_ReqServHostResultCode extends PBEnum {

    const successed = 0;
    const failed = 1;
    const busy = 2;

}

class ReqServListResult extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }

    function code() {
        return $this->_get_value("1");
    }

    function set_code($value) {
        return $this->_set_value("1", $value);
    }

    function host($offset) {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }

    function append_host($value) {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }

    function set_host($index, $value) {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }

    function remove_last_host() {
        $this->_remove_last_arr_value("2");
    }

    function host_size() {
        return $this->_get_arr_size("2");
    }

    function seqId() {
        return $this->_get_value("3");
    }

    function set_seqId($value) {
        return $this->_set_value("3", $value);
    }

}

class PushResult_EPushResult extends PBEnum {

    const successed_online = 0;
    const successed_offline = 1;
    const successed_ignore = 2;
    const failed = 3;
    const busy = 4;
    const success_startBatch = 5;
    const success_endBatch = 6;

}

class PushResult extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult_EPushResult";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
    }

    function result() {
        return $this->_get_value("1");
    }

    function set_result($value) {
        return $this->_set_value("1", $value);
    }

    function taskId() {
        return $this->_get_value("2");
    }

    function set_taskId($value) {
        return $this->_set_value("2", $value);
    }

    function messageId() {
        return $this->_get_value("3");
    }

    function set_messageId($value) {
        return $this->_set_value("3", $value);
    }

    function seqId() {
        return $this->_get_value("4");
    }

    function set_seqId($value) {
        return $this->_set_value("4", $value);
    }

    function target() {
        return $this->_get_value("5");
    }

    function set_target($value) {
        return $this->_set_value("5", $value);
    }

    function info() {
        return $this->_get_value("6");
    }

    function set_info($value) {
        return $this->_set_value("6", $value);
    }

    function traceId() {
        return $this->_get_value("7");
    }

    function set_traceId($value) {
        return $this->_set_value("7", $value);
    }

}

class PushListResult extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult";
        $this->values["1"] = array();
    }

    function results($offset) {
        return $this->_get_arr_value("1", $offset);
    }

    function add_results() {
        return $this->_add_arr_value("1");
    }

    function set_results($index, $value) {
        $this->_set_arr_value("1", $index, $value);
    }

    function remove_last_results() {
        $this->_remove_last_arr_value("1");
    }

    function results_size() {
        return $this->_get_arr_size("1");
    }

}

class Button extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
    }

    function text() {
        return $this->_get_value("1");
    }

    function set_text($value) {
        return $this->_set_value("1", $value);
    }

    function next() {
        return $this->_get_value("2");
    }

    function set_next($value) {
        return $this->_set_value("2", $value);
    }

}

class PushInfo extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
        $this->fields["8"] = "PBString";
        $this->values["8"] = "";
        $this->fields["9"] = "PBString";
        $this->values["9"] = "";
        $this->fields["10"] = "PBInt";
        $this->values["10"] = "";
    }

    function message() {
        return $this->_get_value("1");
    }

    function set_message($value) {
        return $this->_set_value("1", $value);
    }

    function actionKey() {
        return $this->_get_value("2");
    }

    function set_actionKey($value) {
        return $this->_set_value("2", $value);
    }

    function sound() {
        return $this->_get_value("3");
    }

    function set_sound($value) {
        return $this->_set_value("3", $value);
    }

    function badge() {
        return $this->_get_value("4");
    }

    function set_badge($value) {
        return $this->_set_value("4", $value);
    }

    function payload() {
        return $this->_get_value("5");
    }

    function set_payload($value) {
        return $this->_set_value("5", $value);
    }

    function locKey() {
        return $this->_get_value("6");
    }

    function set_locKey($value) {
        return $this->_set_value("6", $value);
    }

    function locArgs() {
        return $this->_get_value("7");
    }

    function set_locArgs($value) {
        return $this->_set_value("7", $value);
    }

    function actionLocKey() {
        return $this->_get_value("8");
    }

    function set_actionLocKey($value) {
        return $this->_set_value("8", $value);
    }

    function launchImage() {
        return $this->_get_value("9");
    }

    function set_launchImage($value) {
        return $this->_set_value("9", $value);
    }

    function contentAvailable() {
        return $this->_get_value("10");
    }

    function set_contentAvailable($value) {
        return $this->_set_value("10", $value);
    }

}

class OSMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["2"] = "PBBool";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "Transparent";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBInt";
        $this->values["6"] = "";
        $this->fields["7"] = "PBInt";
        $this->values["7"] = "";
        $this->fields["8"] = "PBInt";
        $this->values["8"] = "";
    }

    function isOffline() {
        return $this->_get_value("2");
    }

    function set_isOffline($value) {
        return $this->_set_value("2", $value);
    }

    function offlineExpireTime() {
        return $this->_get_value("3");
    }

    function set_offlineExpireTime($value) {
        return $this->_set_value("3", $value);
    }

    function transparent() {
        return $this->_get_value("4");
    }

    function set_transparent($value) {
        return $this->_set_value("4", $value);
    }

    function extraData() {
        return $this->_get_value("5");
    }

    function set_extraData($value) {
        return $this->_set_value("5", $value);
    }

    function msgType() {
        return $this->_get_value("6");
    }

    function set_msgType($value) {
        return $this->_set_value("6", $value);
    }

    function msgTraceFlag() {
        return $this->_get_value("7");
    }

    function set_msgTraceFlag($value) {
        return $this->_set_value("7", $value);
    }

    function priority() {
        return $this->_get_value("8");
    }

    function set_priority($value) {
        return $this->_set_value("8", $value);
    }

}

class Target extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }

    function appId() {
        return $this->_get_value("1");
    }

    function set_appId($value) {
        return $this->_set_value("1", $value);
    }

    function clientId() {
        return $this->_get_value("2");
    }

    function set_clientId($value) {
        return $this->_set_value("2", $value);
    }

}

class PushOSSingleMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "OSMessage";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = "";
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function message() {
        return $this->_get_value("2");
    }

    function set_message($value) {
        return $this->_set_value("2", $value);
    }

    function target() {
        return $this->_get_value("3");
    }

    function set_target($value) {
        return $this->_set_value("3", $value);
    }

}

class MMPMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["2"] = "Transparent";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBInt";
        $this->values["4"] = "";
        $this->fields["5"] = "PBInt";
        $this->values["5"] = "";
        $this->fields["6"] = "PBInt";
        $this->values["6"] = "";
        $this->fields["7"] = "PBBool";
        $this->values["7"] = "";
        $this->values["7"] = new PBBool();
        $this->values["7"]->value = true;
        $this->fields["8"] = "PBInt";
        $this->values["8"] = "";
    }

    function transparent() {
        return $this->_get_value("2");
    }

    function set_transparent($value) {
        return $this->_set_value("2", $value);
    }

    function extraData() {
        return $this->_get_value("3");
    }

    function set_extraData($value) {
        return $this->_set_value("3", $value);
    }

    function msgType() {
        return $this->_get_value("4");
    }

    function set_msgType($value) {
        return $this->_set_value("4", $value);
    }

    function msgTraceFlag() {
        return $this->_get_value("5");
    }

    function set_msgTraceFlag($value) {
        return $this->_set_value("5", $value);
    }

    function msgOfflineExpire() {
        return $this->_get_value("6");
    }

    function set_msgOfflineExpire($value) {
        return $this->_set_value("6", $value);
    }

    function isOffline() {
        return $this->_get_value("7");
    }

    function set_isOffline($value) {
        return $this->_set_value("7", $value);
    }

    function priority() {
        return $this->_get_value("8");
    }

    function set_priority($value) {
        return $this->_set_value("8", $value);
    }

}

class PushMMPSingleMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "MMPMessage";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = "";
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function message() {
        return $this->_get_value("2");
    }

    function set_message($value) {
        return $this->_set_value("2", $value);
    }

    function target() {
        return $this->_get_value("3");
    }

    function set_target($value) {
        return $this->_set_value("3", $value);
    }

}

class StartMMPBatchTask extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "MMPMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }

    function message() {
        return $this->_get_value("1");
    }

    function set_message($value) {
        return $this->_set_value("1", $value);
    }

    function expire() {
        return $this->_get_value("2");
    }

    function set_expire($value) {
        return $this->_set_value("2", $value);
    }

    function seqId() {
        return $this->_get_value("3");
    }

    function set_seqId($value) {
        return $this->_set_value("3", $value);
    }

}

class StartOSBatchTask extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "OSMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
    }

    function message() {
        return $this->_get_value("1");
    }

    function set_message($value) {
        return $this->_set_value("1", $value);
    }

    function expire() {
        return $this->_get_value("2");
    }

    function set_expire($value) {
        return $this->_set_value("2", $value);
    }

}

class PushListMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = array();
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function taskId() {
        return $this->_get_value("2");
    }

    function set_taskId($value) {
        return $this->_set_value("2", $value);
    }

    function targets($offset) {
        return $this->_get_arr_value("3", $offset);
    }

    function add_targets() {
        return $this->_add_arr_value("3");
    }

    function set_targets($index, $value) {
        $this->_set_arr_value("3", $index, $value);
    }

    function remove_last_targets() {
        $this->_remove_last_arr_value("3");
    }

    function targets_size() {
        return $this->_get_arr_size("3");
    }

}

class EndBatchTask extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }

    function taskId() {
        return $this->_get_value("1");
    }

    function set_taskId($value) {
        return $this->_set_value("1", $value);
    }

    function seqId() {
        return $this->_get_value("2");
    }

    function set_seqId($value) {
        return $this->_set_value("2", $value);
    }

}

class PushMMPAppMessage extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "MMPMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = array();
        $this->fields["4"] = "PBString";
        $this->values["4"] = array();
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
    }

    function message() {
        return $this->_get_value("1");
    }

    function set_message($value) {
        return $this->_set_value("1", $value);
    }

    function appIdList($offset) {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }

    function append_appIdList($value) {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }

    function set_appIdList($index, $value) {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }

    function remove_last_appIdList() {
        $this->_remove_last_arr_value("2");
    }

    function appIdList_size() {
        return $this->_get_arr_size("2");
    }

    function phoneTypeList($offset) {
        $v = $this->_get_arr_value("3", $offset);
        return $v->get_value();
    }

    function append_phoneTypeList($value) {
        $v = $this->_add_arr_value("3");
        $v->set_value($value);
    }

    function set_phoneTypeList($index, $value) {
        $v = new $this->fields["3"]();
        $v->set_value($value);
        $this->_set_arr_value("3", $index, $v);
    }

    function remove_last_phoneTypeList() {
        $this->_remove_last_arr_value("3");
    }

    function phoneTypeList_size() {
        return $this->_get_arr_size("3");
    }

    function provinceList($offset) {
        $v = $this->_get_arr_value("4", $offset);
        return $v->get_value();
    }

    function append_provinceList($value) {
        $v = $this->_add_arr_value("4");
        $v->set_value($value);
    }

    function set_provinceList($index, $value) {
        $v = new $this->fields["4"]();
        $v->set_value($value);
        $this->_set_arr_value("4", $index, $v);
    }

    function remove_last_provinceList() {
        $this->_remove_last_arr_value("4");
    }

    function provinceList_size() {
        return $this->_get_arr_size("4");
    }

    function seqId() {
        return $this->_get_value("5");
    }

    function set_seqId($value) {
        return $this->_set_value("5", $value);
    }

}

class ServerNotify_NotifyType extends PBEnum {

    const normal = 0;
    const serverListChanged = 1;
    const exception = 2;

}

class ServerNotify extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "ServerNotify_NotifyType";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }

    function type() {
        return $this->_get_value("1");
    }

    function set_type($value) {
        return $this->_set_value("1", $value);
    }

    function info() {
        return $this->_get_value("2");
    }

    function set_info($value) {
        return $this->_set_value("2", $value);
    }

    function extradata() {
        return $this->_get_value("3");
    }

    function set_extradata($value) {
        return $this->_set_value("3", $value);
    }

    function seqId() {
        return $this->_get_value("4");
    }

    function set_seqId($value) {
        return $this->_set_value("4", $value);
    }

}

class ServerNotifyResult extends PBMessage {

    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function info() {
        return $this->_get_value("2");
    }

    function set_info($value) {
        return $this->_set_value("2", $value);
    }

}

?>