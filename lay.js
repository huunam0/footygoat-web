function st(e,v) {
	if (e.text()!=v) {
		e.html(v);
		e.effect("highlight", {color:"#ff0000"}, 1500);
	}
}
function s2f(s,d) {
	d = d || 0;
	var f = parseFloat(s);
	if (isNaN(f))f=d;
	return f;
}
function s2i(s,d) {
	d = d || 0;
	var f = parseInt(s);
	if (isNaN(f))f=d;
	return f;
}
function div0(a,b,n,d) {
	n = n || 0;
	d = d || 0;
	if (b==0) return d;
	var f = a/b;
	if (isNaN(f)) return d;
	var p = Math.pow(10,n);
	if (isNaN(p)||p==0) return d;
	f = f * p;
	return Math.round(f)/p;
}
function nc(v1,v2,eq) {
	switch (eq) {
	case "=":
		return v1==v2;
		break;
	case ">=":
		return v1>=v2;
		break;
	case "<=":
		return v1<=v2;
		break;
	case "!=":
		return v1!=v2;
		break;
	case ">":
		return v1>v2;
		break;
	case "<":
		return v1<v2;
		break;
	case "=<":
		return v1<=v2;
		break;
	case "=>":
		return v1>=v2;
		break;
	case "<>":
		return v1!=v2;
		break;
	default:
		return false;
	}
}
function getTriggers() {
	$.get("gettrigger.php",function(data){
		$("#mytriggers").html(data);
	}
}