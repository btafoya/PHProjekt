//>>built
define("dojox/charting/plot2d/Stacked",["dojo/_base/declare","./Default","./commonStacked"],function(e,j,f){return e("dojox.charting.plot2d.Stacked",j,{getSeriesStats:function(){return f.collectStats(this.series)},buildSegments:function(g,b){for(var d=this.series[g],a=b?Math.max(0,Math.floor(this._hScaler.bounds.from-1)):0,e=b?Math.min(d.data.length-1,Math.ceil(this._hScaler.bounds.to)):d.data.length-1,c=null,i=[];a<=e;a++){var h=b?f.getIndexValue(this.series,g,a):f.getValue(this.series,g,d.data[a]?
d.data[a].x:null);if(null!=h&&(b||null!=h.y))c||(c=[],i.push({index:a,rseg:c})),c.push(h);else if(!this.opt.interpolate||b)c=null}return i}})});