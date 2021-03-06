/*---------- left aligned button ----------*/
<?
include("../../app/config/configs.php");
$basepath = $configs['base_url'];
?>
.btn { display: block; position: relative; background: #aaa; padding: 5px; margin: 0px; float: left; color: #fff; text-decoration: none; cursor: pointer; }
.btn * { font-style: normal; background-image: url('<?=$basepath;?>/core/images/btn2.png'); background-repeat: no-repeat; display: block; position: relative; }
.btn i { background-position: top left; position: absolute; margin-bottom: -5px;  top: 0; left: 0; width: 5px; height: 5px; }
.btn span { background-position: bottom left; left: -5px; padding: 0 0 5px 10px; margin-bottom: -5px; }
.btn span i { background-position: bottom right; margin-bottom: 0; position: absolute; left: 100%; width: 10px; height: 100%; top: 0; }
.btn span span { background-position: top right; position: absolute; right: -10px; margin-left: 10px; top: -5px; height: 0; }

* html .btn span,
* html .btn i { float: left; width: auto; background-image: none; cursor: pointer; }

.btn.blue { background: #2ae; }
.btn.green { background: #9d4; }
.btn.lime { background: #bbce00; }
.btn.pink { background: #e1a; }
.btn:hover { background-color: #a00; color: #fff; }
.btn:active { background-color: #444; color: #fff; }
.btn[class] {  background-image: url('<?=$basepath;?>/core/images/btn.png'); background-position: bottom; }

* html .btn { border: 3px double #aaa; }
* html .btn.blue { border-color: #2ae; }
* html .btn.green { border-color: #9d4; }
* html .btn.lime { border-color: #bbce00; }
* html .btn.pink { border-color: #e1a; }
* html .btn:hover { border-color: #a00; }

/*---------- centered button ----------*/
.btnC { display: block; position: relative; background: #aaa; padding: 5px; width: 120px; margin: 0px auto; color: #fff; text-decoration: none; cursor: pointer; text-align: center; }
.btnC * { font-style: normal; background-image: url('<?=$basepath;?>/core/images/btn2.png'); background-repeat: no-repeat; display: block; position: relative; }
.btnC i { background-position: top left; position: absolute; margin-bottom: -5px;  top: 0; left: 0; width: 5px; height: 5px; }
.btnC span { background-position: bottom left; left: -5px; padding: 0 0 5px 10px; margin-bottom: -5px; }
.btnC span i { background-position: bottom right; margin-bottom: 0; position: absolute; left: 100%; width: 10px; height: 100%; top: 0; }
.btnC span span { background-position: top right; position: absolute; right: -10px; margin-left: 10px; top: -5px; height: 0; }

* html .btnC span,
* html .btnC i { width: 120px; text-align: center; padding: 0px; display: block; margin: 0px auto; background-image: none; cursor: pointer; }

.btnC.blue { background: #2ae; }
.btnC.green { background: #9d4; }
.btnC.lime { background: #bbce00; }
.btnC.pink { background: #e1a; }
.btnC:hover { background-color: #a00; color: #fff; }
.btnC:active { background-color: #444; color: #fff; }
.btnC[class] {  background-image: url('<?=$basepath;?>/core/images/btn.png'); background-position: bottom; }

* html .btnC { border: 3px double #aaa; }
* html .btnC.blue { border-color: #2ae; }
* html .btnC.green { border-color: #9d4; }
* html .btnC.lime { border-color: #bbce00; }
* html .btnC.pink { border-color: #e1a; }
* html .btnC:hover { border-color: #a00; }

/*---------- centered button ----------*/
.btnC2 { display: block; position: relative; background: #aaa; padding: 5px; margin: 0px auto; min-width: 100px; max-width: 490px; color: #fff; text-decoration: none; cursor: pointer; text-align: center; }
.btnC2 * { font-style: normal; background-image: url('<?=$basepath;?>/core/images/btn2.png'); background-repeat: no-repeat; display: block; position: relative; text-align: center; }
.btnC2 i { background-position: top left; position: absolute; margin-bottom: -5px;  top: 0; left: 0; width: 5px; height: 5px; }
.btnC2 span { background-position: bottom left; left: -5px; padding: 0 0 5px 10px; margin-bottom: -5px; }
.btnC2 span i { background-position: bottom right; margin-bottom: 0; position: absolute; left: 100%; width: 10px; height: 100%; top: 0; }
.btnC2 span span { background-position: top right; position: absolute; right: -10px; margin-left: 10px; top: -5px; height: 0; }

* html .btnC2 span,
* html .btnC2 i { width: auto; text-align: center; padding: 0px; margin: 0px auto; background-image: none; cursor: pointer; }

.btnC2.blue { background: #2ae; }
.btnC2.green { background: #9d4; }
.btnC2.lime { background: #bbce00; }
.btnC2.pink { background: #e1a; }
.btnC2:hover { background-color: #a00; color: #fff; }
.btnC2:active { background-color: #444; color: #fff; }
.btnC2[class] {  background-image: url('<?=$basepath;?>/core/images/btn.png'); background-position: bottom; }

* html .btnC2 { border: 3px double #aaa; }
* html .btnC2.blue { border-color: #2ae; }
* html .btnC2.green { border-color: #9d4; }
* html .btnC2.lime { border-color: #bbce00; }
* html .btnC2.pink { border-color: #e1a; }
* html .btnC2:hover { border-color: #a00; }

/*---------- right aligned button ----------*/
.btnR { display: block; position: relative; background: #aaa; padding: 5px; float: right; color: #fff; text-decoration: none; cursor: pointer; }
.btnR * { font-style: normal; background-image: url('<?=$basepath;?>/core/images/btn2.png'); background-repeat: no-repeat; display: block; position: relative; }
.btnR i { background-position: top left; position: absolute; margin-bottom: -5px;  top: 0; left: 0; width: 5px; height: 5px; }
.btnR span { background-position: bottom left; left: -5px; padding: 0 0 5px 10px; margin-bottom: -5px; }
.btnR span i { background-position: bottom right; margin-bottom: 0; position: absolute; left: 100%; width: 10px; height: 100%; top: 0; }
.btnR span span { background-position: top right; position: absolute; right: -10px; margin-left: 10px; top: -5px; height: 0; }

* html .btnR span,
* html .btnR i { float: right; width: auto; background-image: none; cursor: pointer; }

.btnR.blue { background: #2ae; }
.btnR.green { background: #9d4; }
.btnR.lime { background: #bbce00; }
.btnR.pink { background: #e1a; }
.btnR:hover { background-color: #a00; color: #fff; }
.btnR:active { background-color: #444; color: #fff; }
.btnR[class] {  background-image: url('<?=$basepath;?>/core/images/btn.png'); background-position: bottom; }

* html .btnR { border: 3px double #aaa; }
* html .btnR.blue { border-color: #2ae; }
* html .btnR.green { border-color: #9d4; }
* html .btnR.lime { border-color: #bbce00; }
* html .btnR.pink { border-color: #e1a; }
* html .btnR:hover { border-color: #a00; }