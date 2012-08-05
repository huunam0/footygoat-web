var time_update_match = 5; //1 second
var time_update_team  = 120; //2 minutes
var match_list;
var triggers;
var working =false;
var stoping = false;
//list of match: 0=match_id, 1=home team, 2=away team, 3=begin time, 4=status, 5=being update
var list_count=0;
var u_count=0;
var m_statu = ["0","1","HT","3","FT"];
if(typeof String.prototype.trim !== 'function') {
  String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, ''); 
  }
}

function stg() {
	if (triggers) delete triggers;
	triggers = new Array(15);
	var i=0;
	for (i=1; i<=14; i++) {
		triggers[i] = new Array(4); //0=name, 1 = operator, 2= homevalue, 3 = away value
		triggers[i][0] = i;
		triggers[i][1] = $("#trig_oper_"+myid+"_"+i).text();
		triggers[i][1] = triggers[i][1].replace("...","");
		triggers[i][2] = parseFloat($("#trig_home_"+myid+"_"+i).text());
		triggers[i][3] = parseFloat($("#trig_away_"+myid+"_"+i).text());
	}
	
}
function st(e,v) {
	if (e.text()!=v) {
		e.effect("highlight", {color:"#ff0000"}, 800);
		e.html(v);
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
	});
}



function utb(league_id) {
	$.get("getfile"+Math.floor(Math.random()*9)+".php?&script=0&u=soccernet.espn.go.com/tables%3Fcc=4716%26league="+league_id,function(datas){
		$(datas).find(".mod-content table").each(function(){
			var tgroup = $(this).attr("id");
			tgroup = tgroup.substr(tgroup.length-2,2);
			if (tgroup.charAt(0)=='_') tgroup = tgroup.charAt(1);
			$(this).find("tbody tr").each(function(){
				var tpos = $(this).find("td:eq(0)").text();
				/*F001*/
				if ($(this).find("td:eq(2) a").length>0){
					var tname = $(this).find("td:eq(2) a").text();
					var tid = $(this).find("td:eq(2) a").attr("href").split("/")[6];
					//$("#cuoitrang").text($(this).find("td:eq(2) a").attr("href"));
					var top = s2i($(this).find("td:eq(3)").text());
					var thw = s2i($(this).find("td:eq(10)").text());
					var thd = s2i($(this).find("td:eq(11)").text());
					var thl = s2i($(this).find("td:eq(12)").text());
					var thf = s2i($(this).find("td:eq(13)").text());
					var tha = s2i($(this).find("td:eq(14)").text());
					var taw = s2i($(this).find("td:eq(16)").text());
					var tad = s2i($(this).find("td:eq(17)").text());
					var tal = s2i($(this).find("td:eq(18)").text());
					var taf = s2i($(this).find("td:eq(19)").text());
					var taa = s2i($(this).find("td:eq(20)").text());
					var tgd = s2i($(this).find("td:eq(22)").text());
					var tpt = s2i($(this).find("td:eq(23)").text());
					var thwp = div0(thw*100,top,0,0);
					var thdp = div0(thd*100,top,0,0);
					var thlp = div0(thl*100,top,0,0);
					
					var thfp = div0(thf,thw+thd+thl,1,0);
					var thap = div0(tha,thw+thd+thl,1,0);
					
					var tawp = div0(taw*100,top,0,0);
					var tadp = div0(tad*100,top,0,0);
					var talp = div0(tal*100,top,0,0);
					
					var tafp = div0(taf,taw+tad+tal,1,0);
					var taap = div0(taa,taw+tad+tal,1,0);
					
					
					if ($("#t"+tid).length>0) {
						var ht=true,at=true,sht=false,sat=false;
						$("#t"+tid).html(tname+" ("+tpos+")");
						
						if ($("#t"+tid+"hw").length>0) {  //check first trigger 11 : wins
							$("#t"+tid+"hw").html(thwp);
							if (ht)
								if (triggers[11][1] && !isNaN(triggers[11][2])) {
									sht=true;
									ht= nc(thwp,triggers[11][2],triggers[11][1]);
								}
						}
						if ($("#t"+tid+"hd").length>0) { //trigger 12 draws
							$("#t"+tid+"hd").html(thdp);
							if (ht)
								if (triggers[12][1] && !isNaN(triggers[12][2])) {
									sht=true;
									ht= nc(thdp,triggers[12][2],triggers[12][1]);
								}
						}
						if ($("#t"+tid+"hl").length>0) $("#t"+tid+"hl").html(thlp); 
						if ($("#t"+tid+"hf").length>0) {//trigger 13 : F
							$("#t"+tid+"hf").html(thfp);
							if (ht)
								if (triggers[13][1] && !isNaN(triggers[13][2])) {
									sht=true;
									ht= nc(thfp,triggers[13][2],triggers[13][1]);
								}
						}
						if ($("#t"+tid+"ha").length>0) {//trigger 14 : A
							$("#t"+tid+"ha").html(thap);
							if (ht)
								if (triggers[14][1] && !isNaN(triggers[14][2])) {
									sht=true;
									ht= nc(thap,triggers[14][2],triggers[14][1]);
								}
						}
						if ($("#t"+tid+"aw").length>0) { //check trigger 11 : wins
							$("#t"+tid+"aw").html(tawp);
							if (at)
								if (triggers[11][1] && !isNaN(triggers[11][3])) {
									sat=true;
									at= nc(tawp,triggers[11][3],triggers[11][1]);
								}
						}
						if ($("#t"+tid+"ad").length>0) {
							$("#t"+tid+"ad").html(tadp);
							if (at)
								if (triggers[12][1] && !isNaN(triggers[12][3])) {
									sat=true;
									at= nc(tadp,triggers[12][3],triggers[12][1]);
								}
						}
						if ($("#t"+tid+"al").length>0) $("#t"+tid+"al").html(talp);
						if ($("#t"+tid+"af").length>0) {
							$("#t"+tid+"af").html(tafp);
							if (at)
								if (triggers[13][1] && !isNaN(triggers[13][3])) {
									sat=true;
									at= nc(tafp,triggers[13][3],triggers[13][1]);
								}
						}
						if ($("#t"+tid+"aa").length>0) {
							$("#t"+tid+"aa").html(taap);
							if (at)
								if (triggers[14][1] && !isNaN(triggers[14][3])) {
									sat=true;
									at= nc(taap,triggers[14][3],triggers[14][1]);
								}
						}
						var i=-1;
						var v4=0;
						if (sht) {
							if (ht) v4 = 2;
							else v4 = 1;
							for (i=0; i<match_list.length; i++) 
								if (match_list[i][1]==tid) {
									match_list[i][6]=v4*10 + match_list[i][6] % 10;
									break;
								}
						}
						if (sat) {
							if (at) v4=2;
							else v4=1;
							for (i=0; i<match_list.length; i++) 
								if (match_list[i][2]==tid) {
									match_list[i][6]= + div0(match_list[i][6] , 10,0,0)+v4*1;
									break;
								}
						}
						if ((i>=0)&&(i<match_list.length))
						if ((sht && ht) || (sat && at)) { //hightlight the team name
							$("#t"+tid).addClass("triggers");
						} else {
							$("#t"+tid).removeClass("triggers");
						}
						$.post("addteam.php", {
						id:tid, 
						name:tname,
						group:tgroup,
						league:league_id,
						
						pos:tpos,
						op:top,
						
						hw:thw,
						hd:thd,
						hl:thl,
						hf:thf,
						ha:tha,
						
						aw:taw,
						ad:tad,
						al:tal,
						af:taf,
						aa:taa,
						
						gd:tgd,
						pt:tpt
						});
					}
				}
			});
			
		});
	});
}
function uma(m_id) {//m_id:match
	var m = [[0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0]];
	//alert(m_id+"\n"+match_list[m_id]);
	//first dimension: home=0,away=1; 
	//second dimension: 0=goals,1=goals in first half, 2=shots,3=shots on goal,4=Corner,5=Red,6=Yellow,7=Possession, 
	// 8=%shots, 9=%goal shots, 10=%Corner //27 nov 2011 by thnam
	if (stoping) return;
	if (match_list[m_id][5]!=0) return; //dang update
	if (match_list[m_id][4]>=4) return; //ket thuc
	match_list[m_id][5]=1;
	
	$("#l"+match_list[m_id][0]).show();
	$.get("getfile"+Math.floor(Math.random()*9)+".php?script=0&u=soccernet.espn.go.com/match/_/id/"+match_list[m_id][0]+"?cc=4716",function(data2){
		var ms_text="",ms_minute="",ms=0;
		
		$(data2).find("p.game-state > span").each(function(){
			//alert($(this).attr("id"));
			var thisid = $(this).attr("id");
			if (thisid.indexOf("status")>=0) ms_text = $(this).text().trim();
			else 
			if (thisid.indexOf("clock")>=0) ms_minute = $(this).text().trim();
			//alert(ms_minute+"\n"+m);
			if (ms_minute) ms_minute = ms_minute.replace("-","");
		});
		//alert(ms_minute+"\n"+m);
		if (ms_text) {
			if (ms_text.indexOf("Match")>=0) ms=0;
			else if (ms_text.indexOf("Second Half")>=0) ms=3;
			else if (ms_text.indexOf("Full-time")>=0) ms=4;
			else if (ms_text.indexOf("First Half")>=0) ms=1;
			else if (ms_text.indexOf("Full-time")>=0) ms=4;
			ms_minute=ms_minute.replace(/[ -']/g,"");
			//alert(ms+ms_minute);
		}
		//alert(ms+"\n"+m);
		if (ms>0)
		$(data2).find("div.story-container").each(function(){
			
			var index = 0,index2=0,val,ival;
			//var m[2][8]; 
			
			$(this).find("div:contains('Scoring Summary')").each(function(){
				$(this).find("table tr").each(function(){
					$(this).find("td").each(function(){
						if ($(this).text().indexOf("miss")>=0) return true;
						index = ($(this).attr("align")=="right"?1:0) ;
						val = $(this).text().match(/[0-9]{1,2}'\)/i)+"";
						if (val) {
							val = val.replace(/[()']/g, "");
							if (val) {
								ival=parseInt(val);
								if (ival>0) {
									m[index][0]++;
									if (ival<=45) m[index][1]++;
								}
							}
						}
						//return false;
					});
					
				});
				return false;
			});
			
			if($(this).find("div:contains('Match Stats')").length>0) {
				$(this).find("div:contains('Match Stats')").each(function(){
					$(this).find("table tr").each(function(){
						var trid = $(this).attr("id")+"";
						if (trid.indexOf("Shots")>=0) {
							val = $(this).find("td:eq(0)").text();
							var xv = val.split("(");
							m[0][2]=parseInt(xv[0]);
							m[0][3]=parseInt(xv[1]);
							if(isNaN(m[0][2])) m[0][2]=0;
							if(isNaN(m[0][3])) m[0][3]=0;
							val = $(this).find("td:eq(2)").text();
							var xv = val.split("(");
							m[1][2]=parseInt(xv[0]);
							m[1][3]=parseInt(xv[1]);
							if(isNaN(m[1][2])) m[1][2]=0;
							if(isNaN(m[1][3])) m[1][3]=0;
						} else {
							if (trid.indexOf("Corners")>=0) index2=4;
							else if (trid.indexOf("Possession")>=0) index2=7;
							else if (trid.indexOf("Yellow")>=0) index2=6;
							else if (trid.indexOf("Red")>=0) index2=5;
							else  index2=-1;
							if (index2>0) {
								val = $(this).find("td:eq(0)").text().trim();
								if (val) m[0][index2]=parseInt(val.replace(/[% ]/g,""));
								if (isNaN(m[0][index2])) m[0][index2]=0;
								val = $(this).find("td:eq(2)").text().trim();
								if (val) m[1][index2]=parseInt(val.replace(/[% ]/g,""));
								if (isNaN(m[1][index2])) m[1][index2]=0;
							}
						}
					});
					return false;
				});
			} else {
				$(this).find(".matchBody").each(function(){
					index=($(this).css("float")=="left"?0:1);
					m[index][6]=$(this).find("table:contains('Yellow Cards') .soccer-icons-yellowcard").length;
					m[index][5]=$(this).find("table:contains('Red Cards') .soccer-icons-redcard").length;
				});
			}
			//tinh %
			m[0][8] = div0(m[0][2]*100,m[0][2]+m[1][2],0,0);
			m[1][8] = div0(m[1][2]*100,m[0][2]+m[1][2],0,0);
			m[0][9] = div0(m[0][3]*100,m[0][3]+m[1][3],0,0);
			m[1][9] = div0(m[1][3]*100,m[0][3]+m[1][3],0,0);
			m[0][10] = div0(m[0][4]*100,m[0][4]+m[1][4],0,0);
			m[1][10] = div0(m[1][4]*100,m[0][4]+m[1][4],0,0);
			
			//check triggers
			var ht = (match_list[m_id][6]>=20) || (match_list[m_id][6]<10);
			var at = (match_list[m_id][6]%10 != 1);
			var sht=false, sat = false;
			var i = 1;
			var id = [0,0,7,3,9,2,8,4,10,5,6];
			if (match_list[m_id][8]==0) {
				for (i=1; i<=10; i++) {
					if (triggers[i][1]) { //trigger 1
						if (ht) if (!isNaN(triggers[i][2])) {
							ht = nc(m[0][id[i]],triggers[i][2],triggers[i][1]);
							sht = true;
						}
						if (at) if (!isNaN(triggers[i][3])) {
							at = nc(m[1][id[i]],triggers[i][3],triggers[i][1]);
							sat = true;
						}
					}
				}
				$("#t"+match_list[m_id][1]).removeClass("triggers");
				if (ht)
				if ((match_list[m_id][6]>=20)||(sht)) {
					match_list[m_id][7] = 10 + (match_list[m_id][7]%10)
					$("#t"+match_list[m_id][1]).addClass("triggers");
				}
				$("#t"+match_list[m_id][2]).removeClass("triggers");
				if (at)
				if ((match_list[m_id][6]%10==2)||(sat)) {
					match_list[m_id][7] = 1 + div0(match_list[m_id][7],10,0,0);
					$("#t"+match_list[m_id][2]).addClass("triggers");
				}
				
				if (ht || at) $.post("mail.php",{id:match_list[m_id][0],home:match_list[m_id][1],away:match_list[m_id][2],status:ms,trigger:match_list[m_id][7]});
				match_list[m_id][8]=1;
			}
			//alert(m);
			//cap nhat man hinh //khi status = 1 hoac 3
			if (match_list[m_id][4]<0) { //cap nhat lan dau //bo qua status
				match_list[m_id][4] = ms;
				st($("#m"+match_list[m_id][0]).find("td:eq(4)"),m[0][1]+" - "+m[1][1]);
				
			} else { //cap nhat lan 2
				//status
				if (match_list[m_id][4]<ms) match_list[m_id][4] = ms;
				if (match_list[m_id][4]==4) $("#s"+match_list[m_id][0]).html("FT");//$("#m"+match_list[m_id][0]).find("td:eq(0)").html("FT");
				else if (match_list[m_id][4]==2) $("#s"+match_list[m_id][0]).html("HT"); //$("#m"+match_list[m_id][0]).find("td:eq(0)").html("HT");
				else if (match_list[m_id][4]==1||match_list[m_id][4]==3) $("#s"+match_list[m_id][0]).html(ms_minute+"'");//$("#m"+match_list[m_id][0]).find("td:eq(0)").html(ms_minute+"'");//bs: truong hop khong co minute
				$("#s"+match_list[m_id][0]).removeClass().addClass("status"+ms);
				if (match_list[m_id][4]==1) { //diem hiep 1
					st($("#m"+match_list[m_id][0]).find("td:eq(4)"),m[0][1]+" - "+m[1][1]);
				}
			}
			st($("#m"+match_list[m_id][0]).find("td:eq(2)"),m[0][0]+" - "+m[1][0]);
			st($("#m"+match_list[m_id][0]).find("td:eq(5)"),m[0][6]+" - "+m[1][6]);
			st($("#m"+match_list[m_id][0]).find("td:eq(6)"),m[0][5]+" - "+m[1][5]);
			st($("#m"+match_list[m_id][0]).find("td:eq(7)"),m[0][2]+" - "+m[1][2]);
			st($("#m"+match_list[m_id][0]).find("td:eq(8)"),m[0][3]+" - "+m[1][3]);
			st($("#m"+match_list[m_id][0]).find("td:eq(9)"),m[0][4]+" - "+m[1][4]);
			st($("#m"+match_list[m_id][0]).find("td:eq(10)"),m[0][7]+" - "+m[1][7]);
			st($("#m"+match_list[m_id][0]).find("td:eq(11)"),m[0][8]+" - "+m[1][8]);
			st($("#m"+match_list[m_id][0]).find("td:eq(12)"),m[0][9]+" - "+m[1][9]);
			st($("#m"+match_list[m_id][0]).find("td:eq(13)"),m[0][10]+" - "+m[1][10]);
			
			return false;
		});
		$("#l"+match_list[m_id][0]).hide();
		match_list[m_id][5]=0;
		if (match_list[m_id][4]>=4) {
			$("#l"+match_list[m_id][0]).html("#");
			$.post("addmatch.php",{
				id:		match_list[m_id][0],
				hg:		m[0][0],
				ag:		m[1][0],
				h1g:	m[0][1],
				a1g:	m[1][1],
				hs:		m[0][2],
				as:		m[1][2],
				hgs:	m[0][3],
				ags:	m[1][3],
				hc:		m[0][4],
				ac:		m[1][4],
				hr:		m[0][5],
				ar:		m[1][5],
				hy:		m[0][6],
				ay:		m[1][6],
				hp:		m[0][7],
				ap:		m[1][7]});
			return;
		} else {
			window.setTimeout(function(){uma(m_id)},time_update_match);
		}
	});
	//window.setTimeout(function(){uma(m_id)},time_update_match);
}

function getlast(xau,chia) {
	var rs = xau.split(chia);
	return rs[rs.length-1];
}
function getafter(xau,chia,chuan,buoc) {
	var rs = xau.split(chia);
	var x = buoc || 1;
	var i=0;
	var l = rs.length;
	for (i=0; i<l; i++) 
		if (rs[i]==chuan) {
			if (i+x<l) return rs[i+x];
			else return "";
		}
	return "";
}

function fd(){
	//alert("begin fd");
	if (working) return;
	working=true;
	//$("#firstload").show();
	var s="";
	match_list=new Array();
	
	var arow = ["odd","event"];
	//$("#loadpage").click(function() {
		//$.get("getfile.php?script=0&u=http://soccernet.espn.go.com/scores%3Fcc=4716%26date=20111113", function(data){
		$.get("getfile"+Math.floor(Math.random()*9)+".php?script=0&u=soccernet.espn.go.com/scores%3Fcc=4716", function(data){
			$("#bigboard tr:gt(1)").remove();
			$(data).find(".group-set").each(function(){
				var header = $(this).find(".mod-header").get(0);
				var league_name = $(header).find("h2 a").text();
				//var league_id = $(header).find("h2 a").attr("href").split("/")[4];
				var league_id = getafter($(header).find("h2 a").attr("href"),"/","league");
				//alert($(header).find("h2 a").attr("href"));
				if (league_id) {
					$.post("addleague.php", {id:league_id, name:league_name});
				}
				
				$("#bigboard").append('<tr class="league"><td align="left" colspan="24">'+league_name+'</td></tr>');
				var r=0; 
				$(this).find("tr").each(function() {
					if ($(this).find("td.status").length>0) {/*F002*/
						var mhteam = "0";
						if ($(this).find("td.home_team a").length>0) mhteam = getlast($(this).find("td.home_team a").attr("href"),"/");
						var mateam = "0";
						if ($(this).find("td.away_team a").length>0) mateam = getlast($(this).find("td.away_team a").attr("href"),"/");
						//var mid = $(this).find("td.scores a").attr("href").split("/")[4];
						var mid = getlast($(this).find("td.scores a").attr("href"),"/");
						match_list[list_count]=new Array(mid,mhteam,mateam,0,-1,0,0,0,0);
						//alert("mid "+mid+"/"+mhteam+"::"+mateam);
						//match_list.push(new Array(mid,mhteam,mateam,0,-1,0,0,0,0));
						//0 =match id, 1 = home team, 2 = away team, 3 = time, 4 = status, 5=be updating, 6=trigger1 ok 0/10/1/11, 7 trigger 2 ok 0/1/10/11, 8 = has sent mail?
						var status = $(this).find("td.status").text();
						var mdate,mstatus=0;
						var theday = new Date();
						if (status.indexOf(":")<0) {
							if (status=="HT") mstatus=2;
							else if (status=="FT") mstatus=4;
							else if (status=="1st") mstatus=2;
							else if (status.indexOf("'")>=0) {
								status = status.split("'")[0];
								ival=parseInt(status);
								if (ival>45) mstatus=3;
								else mstatus=1;
							}
							mdate = theday.getFullYear()+"-"+(theday.getMonth()+1)+"-"+theday.getDate()+" 00:00:00";
						} else {
							if (status.length>7) {
								theday.setDate((new Date()).getDate()+1);
							}
							mdate = theday.getFullYear()+"-"+(theday.getMonth()+1)+"-"+theday.getDate()+" "+status.match("..:..")+":00";
						}
						$.post("addmatch.php",{id:mid,league:league_id,hteam:mhteam,ateam:mateam,status:mstatus,date:mdate});
						//if (mstatus>=4) match_list[list_count]=0;
						//match_list[list_count][4]=mstatus;
						//if (mstatus==4) luu xuong database
						s="<tr class='"+arow[r]+"' id='m"+mid+"'>";r=1-r;
						s+="<td align='left'><span id='s"+mid+"'  class='status"+mstatus+"'>"+$(this).find("td.status").text()+"</span><span id='l"+mid+"' style='display:none;'>...</span></td>";//<img src='image/loading2.gif' height='10px'/>
						s+="<td id='t"+mhteam+"' class='home'>"+$(this).find("td.home_team").text()+"</td>";
						s+="<td>"+$(this).find("td.scores").text()+"</td>";
						s+="<td id='t"+mateam+"' class='away'>"+$(this).find("td.away_team").text()+"</td>";
						for (var i=5; i<15; i++) s+="<td>&nbsp;</td>";
						s+="<td><span id='t"+mhteam+"hw'> </span></td>";
						s+="<td><span id='t"+mhteam+"hd'> </span></td>";
						s+="<td><span id='t"+mhteam+"hl'> </span></td>";
						s+="<td><span id='t"+mhteam+"hf'> </span></td>";
						s+="<td><span id='t"+mhteam+"ha'> </span></td>";
						s+="<td><span id='t"+mateam+"aw'> </span></td>";
						s+="<td><span id='t"+mateam+"ad'> </span></td>";
						s+="<td><span id='t"+mateam+"al'> </span></td>";
						s+="<td><span id='t"+mateam+"af'> </span></td>";
						s+="<td><span id='t"+mateam+"aa'> </span></td>";
						s+= "</tr>";
						list_count++;
					} else {
						s="<tr class='group'><td colspan='24'>"+$(this).find("th a").text()+"</td></tr>";
					}
					$("#bigboard").append(s);
					
				});
				if ($(header).find("div a").length>0) {
					utb(league_id);
				}
			});
		},"html");
	//});
	
	working=false;
}
function ud(){
	if (stoping) return;
	working=true;
	//$("#matchload").show();
		//$("#cuoitrang").append(u_count+" #Update "+match_list.length +"; ");
		for (var i=0; i<match_list.length; i++) {
			uma(i);
		}
		for (var i=match_list.length-1; i>=0; i--) {
			if (match_list[i][4]==4) {
				//match_list.splice(i,1);
				list_count--;
			}
		}
		u_count++;
	//$("#matchload").hide();
	working=false;
	 
	//window.setTimeout(ud,(u_count<2?3:1)*time_update_match);
}