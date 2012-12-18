function gup(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
var status= new Array("*","1st","HT","2nd","Ex.","Pen","Susp","FT","AET","FT-Pens","Aban","Postp","s12","s13","s14","s15");
var nbm = new Array(0,0,0,0);
var today = gup("date")+"";
var anotherday=(today?false:true);
var momment="";
var firstNew;
var hldelay=1000;
var rp;
var getdelay=2000;
var sl=0;
var isAjax=false;
var isViewAll=true;
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
function getmatch(matchid) {
	$.ajax({
		url: 'getmatch.php',
		type:"GET",
		data:{id:matchid},
		//dataType: 'json',	
		success: function(json) {
			//$("#fortest").html(json);
			var obj = $.parseJSON(json);
			//alert(json);
			if (obj) {
				//if (obj.count) {
				var h=0,a=0,sha=0;
				var mrow="#m"+matchid;
				//if ((obj['st']==1)||(obj['st']==3)) {
				$(mrow).find(".status .mminutes").html(obj['mi']+"'");
				$(mrow).find(".status .mstatus").show();
				//}
				if (obj['st']>=6) {
					$(mrow).find(".status").attr("class","status status7");
					$(mrow).find(".status .mminutes").hide();
					$(mrow).find(".status .mstart").hide();
				}
				else if (obj['st']>=1) {
					$(mrow).find(".status").attr("class","status status1");
					if ((obj['st']!=1) && (obj['st']!=3)) {
						$(mrow).find(".status .mminutes").hide();
					}
					$(mrow).find(".status .mstart").hide();
				}
				else {
					$(mrow).find(".status .mstart").show();
					$(mrow).find(".status .mstatus").hide();
					$(mrow).find(".status").attr("class","status status0");
					return;
				}
				$(mrow).find(".status .mstatus").html(status[obj['st']]);
				
				$(mrow).find(".score .score0").html(obj['hg']);
				$(mrow).find(".score .score1").html(obj['ag']);
				$(mrow).find(".score1 .score10").html(obj['h1']);
				$(mrow).find(".score1 .score11").html(obj['a1']);
				$(mrow).find(".red .red0").html(obj['hr']);
				$(mrow).find(".red .red1").html(obj['ar']);
				$(mrow).find(".yellow .yellow0").html(obj['hy']);
				$(mrow).find(".yellow .yellow1").html(obj['ay']);
				$(mrow).find(".shots .shots0").html(obj['hs']);
				$(mrow).find(".shots .shots1").html(obj['as']);
				$(mrow).find(".gshots .gshots0").html(obj['hsg']);
				$(mrow).find(".gshots .gshots1").html(obj['asg']);
				$(mrow).find(".corner .corner0").html(obj['hc']);
				$(mrow).find(".corner .corner1").html(obj['ac']);
				$(mrow).find(".possession .possession0").html(obj['hp']);
				$(mrow).find(".possession .possession1").html(obj['ap']);
				//...bo sung them %
				if (obj['hs'] && obj['as']) {
					//$(mrow).find(".pshots .pshots0").html(div0(obj['hs']*100,obj['hs']+obj['as'],0,0));
					//$(mrow).find(".pshots .pshots1").html(div0(obj['as']*100,obj['hs']+obj['as'],0,0));
					h=parseInt(obj['hs']);
					a=parseInt(obj['as']);
					sha=h+a;
					$(mrow).find(".pshots").html(div0(h*100,sha,0,0)+" - "+div0(a*100,sha,0,0));
				}
				if (obj['hsg'] && obj['asg']) {
					//$(mrow).find(".pgshots .pgshots0").html(div0(obj['hsg']*100,obj['hsg']+obj['asg'],0,0));
					//$(mrow).find(".pgshots .pgshots1").html(div0(obj['asg']*100,obj['hsg']+obj['asg'],0,0));
					h=parseInt(obj['hsg']);
					a=parseInt(obj['asg']);
					sha=h+a;
					$(mrow).find(".pgshots").html(div0(h*100,sha,0,0)+" - "+div0(a*100,sha,0,0));
				}
				if (obj['hc'] && obj['ac']) {
					//$(mrow).find(".pcorner .pcorner0").html(div0(obj['hc']*100,obj['hc']+obj['ac'],0,0));
					//$(mrow).find(".pcorner .pcorner1").html(div0(obj['ac']*100,obj['hc']+obj['ac'],0,0));
					h=parseInt(obj['hc']);
					a=parseInt(obj['ac']);
					sha=h+a;
					$(mrow).find(".pcorner").html(div0(h*100,sha,0,0)+" - "+div0(a*100,sha,0,0));
				}
				//}
				
			}
			
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			//alert("Error get team");
		}
	});
}
function getnew() {
		
		$.ajax({
			url: 'gtimeline.php',
			type:"GET",
			//timeout:2000,
			data:{t:momment},
			//dataType: 'json',	
			success: function(json) {
				var obj = $.parseJSON(json);
				if (obj) {
					$("#fortest").html(json);
					for (var i=0; i<obj.length;i++) {
						var mrow="#m"+obj[i]['m'];
						if (obj[i]['e']==100) {
							loadmatches();
							//break;
						} else if ((obj[i]['e']==12) ) {
							$(mrow).find(".status .mstatus").show();
							$(mrow).find(".status .mstart").hide();
							$(mrow).find(".status .mstatus").html(status[(obj[i]['v']?obj[i]['v']:7)]).effect("highlight", {color:"#ff0000"}, hldelay);
							$(mrow).find(".status").attr('class','status status7');
							if (!isViewAll) $(mrow).hide();
						} else if ( (obj[i]['e']==9)) {
							$(mrow).find(".status .mstatus").html(status[(obj[i]['v']?obj[i]['v']:7)]).effect("highlight", {color:"#ff0000"}, hldelay);
							$(mrow).find(".status .mminutes").toggle((obj[i]['v']==1)||(obj[i]['v']==3));
							//$(mrow).find(".status").attr('class','status status'+obj[i]['v']);
							//if (!isViewAll) $(mrow).hide();
						} else if (obj[i]['e']==10) {
							$(mrow).find(".status").attr('class','status status1');
							$(mrow).find(".status .mstart").hide();
							$(mrow).find(".status .mstatus").show();
							getmatch(obj[i]['m']);
							if (!isViewAll) $(mrow).show();
						} else if (obj[i]['e']==8) {
							if (obj[i]['v']) {
								$(mrow).find(".status .mminutes").html(obj[i]['v']+"'").effect("highlight", {color:"#ff0000"}, hldelay);
								$(mrow).find(".status").attr('class','status status1');
							}
						} else if (obj[i]['e']==7) {
							$(mrow).find(".possession .possession"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==6) {
							$(mrow).find(".corner .corner"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==5) {
							$(mrow).find(".gshots .gshots"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==4) {
							$(mrow).find(".shots"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==3) {
							$(mrow).find(".yellow .yellow"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==2) {
							$(mrow).find(".red .red"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==1) {
							$(mrow).find(".score1 .score1"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==0) {
							$(mrow).find(".score .score"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						}
						momment=obj[i]['d'];
					}
				}
				getdelay=2000;
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get team");
				getdelay=10000;
			}
		});
		rp=setTimeout(getnew,getdelay);
	}
	function getnew1() {
		
		$.ajax({
			url: 'gtimeline.php',
			type:"GET",
			//timeout:2000,
			data:{t:momment},
			//dataType: 'json',	
			success: function(json) {
				var obj = $.parseJSON(json);
				if (obj) {
					//addOne=0;
					var h=0;
					var a=0;
					var sha=0;
					for (var i=0; i<obj.length;i++) {
						$("#debug4").append("\n"+obj[i]['d']+"\t"+obj[i]['m']+"\t"+obj[i]['e']+"\t"+obj[i]['h']+"\t"+obj[i]['a']);
						var mrow="#m"+obj[i]['m'];
						if (obj[i]['e']==100) {
							addOne=1;
							if (firstNew!=obj[i]['d']) {
								firstNew=obj[i]['d'];
								loadmatches();
							}
							//break;
						} else if ((obj[i]['e']==12) ) {
							$(mrow).find(".status .mminutes").hide();
							$(mrow).find(".status .mstatus").html(status[(obj[i]['h']?obj[i]['h']:7)]);
							$(mrow).find(".status").attr('class','status status7');
							//nbm[2]++;
							//nbm[1]--;
							//$("#nbm1").html(nbm[1]);
							//$("#nbm2").html(nbm[2]);
							if (!isViewAll) $(mrow).hide();
						} else if ( (obj[i]['e']==9)) {
							$(mrow).find(".status .mstatus").html(status[(obj[i]['h']?obj[i]['h']:7)]);
							$(mrow).find(".status .mminutes").toggle((obj[i]['h']==1)||(obj[i]['h']==3));
							$(mrow).find(".status").attr('class','status status'+obj[i]['h']);
							
						}else if (obj[i]['e']==10) {
							$(mrow).find(".status .mstart").hide();
							$(mrow).find(".status .mstatus").show();
							getmatch(obj[i]['m']);
							$(mrow).find(".status span:eq(0)").hide();
							$(mrow).find(".status span:gt(0)").show();
							$(mrow).find(".status").attr('class','status status1');
							//nbm[1]++;
							//nbm[0]--;
							//$("#nbm1").html(nbm[1]);
							//$("#nbm0").html(nbm[0]);
							if (!isViewAll) $(mrow).show();
						} else if (obj[i]['e']==8) {
							//if (obj[i]['v']) {
								$(mrow).find(".status .mminutes").html(obj[i]['a']+"'");
								//$(mrow).find(".status").attr('class','status status1');
							//}
							$(mrow).find(".status .mstatus").html(status[(obj[i]['h']?obj[i]['h']:7)]);
							$(mrow).find(".status .mminutes").toggle((obj[i]['h']==1)||(obj[i]['h']==3));
							$(mrow).find(".status").attr('class','status status'+obj[i]['h']);
						} else if (obj[i]['e']==7) {
							$(mrow).find(".possession .possession0").html(obj[i]['h']);
							$(mrow).find(".possession .possession1").html(obj[i]['a']);
						} else if (obj[i]['e']==6) {
							h = parseInt(obj[i]['h']);
							a = parseInt(obj[i]['a']);
							sha=h+a;
							$(mrow).find(".corner").html(h + " - " + a);
							$(mrow).find(".pcorner").html(div0(h*100,sha,0,0) + " - " + div0(a*100,sha,0,0));
						} else if (obj[i]['e']==5) {
							//$(mrow).find(".gshots .gshots0").html(obj[i]['h']);
							//$(mrow).find(".gshots .gshots1").html(obj[i]['a']);
							h = parseInt(obj[i]['h']);
							a = parseInt(obj[i]['a']);
							sha=h+a;
							$(mrow).find(".gshots").html(h + " - " + a);
							$(mrow).find(".pgshots").html(div0(h*100,sha,0,0) + " - " + div0(a*100,sha,0,0));
						} else if (obj[i]['e']==4) {
							//$(mrow).find(".shots .shots0").html(obj[i]['h']);
							//$(mrow).find(".shots .shots1").html(obj[i]['a']);
							h = parseInt(obj[i]['h']);
							a = parseInt(obj[i]['a']);
							sha=h+a;
							$(mrow).find(".shots").html(h + " - " + a);
							$(mrow).find(".pshots").html(div0(h*100,sha,0,0) + " - " + div0(a*100,sha,0,0));
						} else if (obj[i]['e']==3) {
							$(mrow).find(".yellow .yellow0").html(obj[i]['h']);
							$(mrow).find(".yellow .yellow1").html(obj[i]['a']);
						} else if (obj[i]['e']==2) {
							$(mrow).find(".red .red0").html(obj[i]['h']);
							$(mrow).find(".red .red1").html(obj[i]['a']);
						} else if (obj[i]['e']==1) {
							$(mrow).find(".score1 .score10").html(obj[i]['h']);
							$(mrow).find(".score1 .score11").html(obj[i]['a']);
						} else if (obj[i]['e']==0) {
							$(mrow).find(".score .score0").html(obj[i]['h']);
							$(mrow).find(".score .score1").html(obj[i]['a']);
						}
						momment=obj[i]['d'];
					}
				}
				getdelay=2000;
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get team");
				getdelay=10000;
			}
		});
		sl++;
		isAjax=false;
		if (anotherday) return;
		if (sl>30)
			rp=setTimeout(getnew1,getdelay);
		else
			rp=setTimeout(getnew1,getdelay);
		//rp=setTimeout(getnew1,getdelay);
	}
	function getteam(teamid,away) {
		$.ajax({
			url: 'getteam.php',
			type:"GET",
			data:{id:teamid,aw:away},
			//dataType: 'json',	
			success: function(json) {
				//$("#fortest").html(json);
				var obj = $.parseJSON(json);
				//alert(json);
				if (obj) {
					//if (obj.count) {
						$("#t"+teamid).html(obj.na+(obj.po.length?" ("+obj.po+")":""));
						var s1=0;
						if (obj.pl)	{
							if (obj.w) {
								s1+=parseInt(obj.w);
								$("#w"+teamid).html(div0(obj.w*100,obj.pl,0,0));
							}
							if (obj.d) {
								s1+=parseInt(obj.d);
								$("#d"+teamid).html(div0(obj.d*100,obj.pl,0,0));
							}
							if (obj.l) {
								s1+=parseInt(obj.l);
								$("#l"+teamid).html(div0(obj.l*100,obj.pl,0,0));
							}
							if (obj.f) {
								$("#f"+teamid).html(div0(obj.f,s1,1,0));
							}
							if (obj.a) {
								$("#a"+teamid).html(div0(obj.a,s1,1,0));
							}
							
						}
					//}
					
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get team");
			}
		});
	}
	function loadmatches() {
		$.ajax({
			url: 'getlist.php',
			type:"GET",
			data:{d:today},
			//dataType: 'json',	
			success: function(json) {
				//$("#fortest").html(json);
				var obj = $.parseJSON(json);
				var league="";
				var group="";
				var tr='';
				nbm[0]=nbm[1]=nbm[2]=0;
				//alert(obj.leagues['col.1']);
				$("#bigboard tr:gt(1)").remove();
				for (var i=0; i<obj.matches.length;i++) {
					if (obj.matches[i]['lg']!=league) {
						$("#bigboard").append('<tr class="league"><td align="left" colspan="24">'+obj.leagues[obj.matches[i]['lg']]+'</td></tr>');
						league=obj.matches[i]['lg']+"";
					}
					if (obj.matches[i]['gr']) {
						if (obj.matches[i]['gr']!=group) {
							$("#bigboard").append('<tr class="group"><td align="left" colspan="24">Group '+obj.matches[i]['gr']+'</td></tr>');
							group=obj.matches[i]['gr'];
						}
					}
					
					tr='<tr class="match" id="m'+obj.matches[i]['id']+'">';
					tr+='<td class="status status'+obj.matches[i]['st']+'">';
					if (obj.matches[i]['st']<1)  {
						tr+='<span class="mstart">'+obj.matches[i]['da'].substr(11,5)+'</span><span class="mstatus" style="display:none;">'+status[obj.matches[i]['st']]+'</span>';
						//nbm[0]++;
					} else { 
						tr+='<span class="mstart" style="display:none;">'+obj.matches[i]['da'].substr(11,5)+'</span><span class="mstatus">'+status[obj.matches[i]['st']]+'</span>';
						if (obj.matches[i]['st']<7)  {
							//nbm[1]++;
						} else {
							//nbm[2]++;
						}
					}
					if ((obj.matches[i]['st']==1)||(obj.matches[i]['st']==3)) {
						tr+='<span class="mminutes">';
					} else {
						tr+='<span class="mminutes" style="display:none;">';
					}
					
					tr+=obj.matches[i]['mi']+"'</span>";
					
					tr+="</td>";
					tr+='<td class="home" id="t'+obj.matches[i]['ht']+'">'+obj.matches[i]['ht']+'</td>';
					tr+='<td class="score"><span class="score0">'+(obj.matches[i]['st']>0?obj.matches[i]['hg']:"")+'</span> - <span class="score1">'+(obj.matches[i]['st']>0?obj.matches[i]['ag']:"")+'</span></td>';
					tr+='<td class="away" id="t'+obj.matches[i]['at']+'">'+obj.matches[i]['at']+'</td>';
					if (obj.matches[i]['st']==0) {
						tr+='<td class="score1"><span class="score10"></span> - <span class="score11"></span></td>';
						tr+='<td class="yellow"><span class="yellow0"></span> - <span class="yellow1"></span></td>';
						tr+='<td class="red"><span class="red0"></span> - <span class="red1"></span></td>';
						tr+='<td class="shots"><span class="shots0"></span> - <span class="shots1"></span></td>';
						tr+='<td class="gshots"><span class="gshots0"></span> - <span class="gshots1"></span></td>';
						tr+='<td class="corner"><span class="corner0"></span> - <span class="corner1"></span></td>';
						tr+='<td class="possession"><span class="possession0"></span> - <span class="possession1"></span></td>';
						tr+='<td class="pshots"><span class="pshots0"></span> - <span class="pshots1"></span></td>';
						tr+='<td class="pgshots"><span class="pgshots0"></span> - <span class="pgshots1"></span></td>';
						tr+='<td class="pcorner"><span class="pcorner0"></span> - <span class="pcorner1"></span></td>';
					} else {
						tr+='<td class="score1"><span class="score10">'+obj.matches[i]['hg1']+'</span> - <span class="score11">'+obj.matches[i]['ag1']+'</span></td>';
						tr+='<td class="yellow"><span class="yellow0">'+obj.matches[i]['hy']+'</span> - <span class="yellow1">'+obj.matches[i]['ay']+'</span></td>';
						tr+='<td class="red"><span class="red0">'+obj.matches[i]['hr']+'</span> - <span class="red1">'+obj.matches[i]['ar']+'</span></td>';
						tr+='<td class="shots"><span class="shots0">'+obj.matches[i]['hs']+'</span> - <span class="shots1">'+obj.matches[i]['as']+'</span></td>';
						tr+='<td class="gshots"><span class="gshots0">'+obj.matches[i]['hgs']+'</span> - <span class="gshots1">'+obj.matches[i]['ags']+'</span></td>';
						tr+='<td class="corner"><span class="corner0">'+obj.matches[i]['hc']+'</span> - <span class="corner1">'+obj.matches[i]['ac']+'</span></td>';
						tr+='<td class="possession"><span class="possession0">'+obj.matches[i]['hpo']+'</span> - <span class="possession1">'+obj.matches[i]['apo']+'</span></td>';
						tr+='<td class="pshots"><span class="pshots0"></span> - <span class="pshots1"></span></td>';
						tr+='<td class="pgshots"><span class="pgshots0"></span> - <span class="pgshots1"></span></td>';
						tr+='<td class="pcorner"><span class="pcorner0"></span> - <span class="pcorner1"></span></td>';
					}
					tr+='<td class="w0" id="w'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="d0" id="d'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="l0" id="l'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="f0" id="f'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="a0" id="a'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="w1" id="w'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="d1" id="d'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="l1" id="l'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="f1" id="f'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="a1" id="a'+obj.matches[i]['at']+'">-</td>';
					tr+='</tr>';
					$("#bigboard").append(tr);
					getteam(obj.matches[i]['ht'],0);
					getteam(obj.matches[i]['at'],1);
					if ((obj.matches[i]['st']==1)||(obj.matches[i]['st']==3)) getmatch(obj.matches[i]['id']);
					//break;//debug only
				}
				//$("#nbm0").html(nbm[0]);
				//$("#nbm1").html(nbm[1]);
				//$("#nbm2").html(nbm[2]);
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get matches");
			}
		});
	}

