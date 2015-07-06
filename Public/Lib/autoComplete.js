//******************************************************** 
//创建日期: 2009-03-10 
//作 者: oloen 
//內容说明:　自动完成JS类 
//用法： 
// var auto = new autoComplete(客户端ID); 
// auto.Init(document.all.客户端ID); 
//******************************************************** 
//自动完成 
function autoComplete(id)
{
    var me = this;
//自动完成绑定控件客户端ID 
    me.AutoCompleteControlID
    me.handle = null
    me.DivResult;
    me.currentIndex = -1;
    me.LastIndex = -1;
    me.requestObj;
    me.CurrentTD = '';
    if (id != null && typeof (id) != undefined)
	me.AutoCompleteControlID = id;
    if (me.DivResult == null || typeof (me.DivResult) == "undefined")
    {
	me.DivResult = document.createElement("div");
	var parent = document.getElementById(me.AutoCompleteControlID).parentElement;
	if (typeof (parent) != "undefined") {
	    parent.appendChild(me.DivResult);
	}
    }
    this.Init = function (obj)
    {
	me.handle = obj
	me.AutoCompleteControlID = obj.id
    }
    this.Auto = function ()
    {
	me.DivResult.style.position = "absolute";
	me.DivResult.style.top = me.handle.getBoundingClientRect().top + 17;
	me.DivResult.style.left = me.handle.getBoundingClientRect().left;
	me.DivResult.style.width = me.handle.width;
	me.DivResult.style.height = 20;
	me.DivResult.style.backgroundColor = "#ffffff";
//如果按下 向上, 向下 或 回车 
	if (event.keyCode == 38 || event.keyCode == 40 || event.keyCode == 13)
	{
	    me.SelectItem();
	}
	else
	{
//恢复下拉选择项为 -1 
	    currentIndex = -1;
	    if (window.XMLHttpRequest)
	    {
		me.requestObj = new XMLHttpRequest();
		if (me.requestObj.overrideMimeType)
		    me.requestObj.overrideMimeType("text/xml");
	    }
	    else if (window.ActiveXObject)
	    {
		try
		{
		    me.requestObj = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
		    me.requestObj = new ActiveXObject("Microsoft.XMLHTTP");
		}
	    }
	    if (me.requestObj == null)
		return;
	    me.requestObj.onreadystatechange = me.ShowResult;
	    me.requestObj.open("GET", "../Common/AutoComplete.aspx?InputValue=" + escape(me.handle.value), true);
	    me.requestObj.send();
	}
    }
    this.ShowResult = function ()
    {
	if (me.requestObj.readyState == 4)
	{
	    me.DivResult.innerHTML = me.requestObj.responseText;
	    me.DivResult.style.display = "";
	}
    }
    this.SelectItem = function ()
    {
//结果 
	var result = document.getElementById("Tmp_AutoComplete_tblResult");
	if (!result)
	    return;
	if (result.rows[me.LastIndex] != null)
	{
	    result.rows[me.LastIndex].style.backgroundColor = "#FFFFFF";
	    result.rows[me.LastIndex].style.color = "#000000";
	}
	var maxRow = result.rows.length;
//向上 
	if (event.keyCode == 38 && me.currentIndex > 0)
	    me.currentIndex--;
//向下 
	if (event.keyCode == 40 && me.currentIndex < maxRow - 1)
	    me.currentIndex++;
//回车 
	if (event.keyCode == 13)
	{
	    me.Select()
	    me.InitItem();
	    return;
	}
	if (result.rows[me.currentIndex] != undefined)
	{
//选中颜色 
	    result.rows[me.currentIndex].style.backgroundColor = "#3161CE";
	    result.rows[me.currentIndex].style.color = "#FFFFFF";
	}
	me.DivResult.style.height = maxRow * 15;
	me.LastIndex = me.currentIndex;
    }
    this.Select = function ()
    {
	var result = document.getElementById("Tmp_AutoComplete_tblResult");
	if (!result)
	    return;
	var ReturnValue = result.rows[me.currentIndex].ReturnValue;
	if (ReturnValue != undefined)
	{
	    me.DivResult.style.display = 'none';
//设置页面值 
	    ReturnAutoComplete(ReturnValue);
	}
    }
    this.Hide = function ()
    {
	me.DivResult.style.display = 'none';
	me.currentIndex = -1;
    }
    this.InitItem = function ()
    {
	me.DivResult.style.display = 'none';
	me.DivResult.innerHTML = "";
	me.currentIndex = -1;
    }
    me.DivResult.onclick = function ()
    {
	me.Auto();
    }
    document.getElementById(me.AutoCompleteControlID).onclick = function () {
	me.Auto();
    }
    document.getElementById(me.AutoCompleteControlID).onkeyup = function () {
	me.Auto();
    }
    document.getElementById(me.AutoCompleteControlID).onkeydown = function () {
	if (event.keyCode == 13)
	{
	    me.Select()
	    me.InitItem();
	    return;
	}
    }
    document.getElementById(me.AutoCompleteControlID).onblur = function () {
	me.Hide();
    }
} 