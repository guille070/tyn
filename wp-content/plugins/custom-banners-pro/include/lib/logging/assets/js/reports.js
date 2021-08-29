var previousPoint = null, previousLabel = null;
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

$ = jQuery;

jQuery.fn.UseTooltip = function () {
    $(this).bind("plothover", function (event, pos, item) {
        if (item) {
            if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                previousPoint = item.dataIndex;
                previousLabel = item.series.label;
                $("#tooltip").remove();
                
                var x = item.datapoint[0];
                var y = item.datapoint[1];
                var date = new Date(x);
                var color = item.series.color;

                showTooltip(item.pageX, item.pageY, color,
                            "<strong>" + item.series.label + "</strong><br>"  +
                            (date.getMonth() + 1) + "/" + date.getDate() +
                            " : <strong>" + y + "</strong>");
            }
        } else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });
};

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 120,
        border: '2px solid ' + color,
        padding: '3px',
        'font-size': '9px',
        'border-radius': '5px',
        'background-color': '#fff',
        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}

var cbp_reports = function ($) {
	
	var setup_datepickers = function ()
	{
		$( "#period_start" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#period_end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#period_end" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#period_start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	};
	
	var gd = function (year, month, day) {
		return new Date(year, month - 1, day).getTime();
	}
	
	var setup_graphs = function () 
	{		
		graphs = jQuery('.custom_banners_graph');
		graphs.each(function ()
		{
			var graph = $(this);
			var data1 = graph.data('flot-data1');
			var data2 = graph.data('flot-data2');
			var data3 = graph.data('flot-data3');
			
			var r;		
			for (i in data1) {
				r = data1[i][0];
				data1[i][0] = eval(r);
			}
			for (i in data2) {
				r = data2[i][0];
				data2[i][0] = eval(r);
			}
			for (i in data3) {
				r = data3[i][0];
				data3[i][0] = eval(r);
			}
			
			var dataset = [
				{
					label: "Impressions",
					data: data1,
					color: "#FF0000",
					points: { fillColor: "#FF0000", show: true },
					lines: { show: true }
				},
				{
					label: "Clicks",
					data: data2,
					xaxis:2,
					color: "#0062E3",
					points: { fillColor: "#0062E3", show: true },
					lines: { show: true }
				},
				{
					label: "CTR",
					data: data3,
					xaxis:2,
					yaxis:2,
					color: "#00ff00",
					points: { fillColor: "#00ff00", show: true },
					lines: { show: true },
				}
			];
			
			var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];

			var options = {
				series: {
					shadowSize: 5
				},
				xaxes: [{
					mode: "time",                
					tickFormatter: function (val, axis) {
						return dayOfWeek[new Date(val).getDay()];
					},
					color: "lightgray",
					position: "top",
					axisLabel: "Day of week",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					axisLabelPadding: 5
				},
				{
					mode: "time",
					timeformat: "%m/%d",
					tickSize: [3, "day"],
					color: "lightgray",        
					axisLabel: "Date",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					axisLabelPadding: 10
				}],
				yaxes: [{        
					color: "lightgray",
					tickDecimals: 0,
					axisLabel: "# of Clicks or Impressions",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					axisLabelPadding: 5
				},
				{        
					position: 'right',
					color: "lightgray",
					tickDecimals: 2,
					tickFormatter: function (val, axis) {
						return val + "%";
					},
					axisLabel: "Click Through Rate (%)",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					axisLabelPadding: 5,
					max: 100
				}],
				legend: {
					noColumns: 0,
					labelFormatter: function (label, series) {
						return "<font color=\"white\">" + label + "</font>";
					},
					backgroundColor: "#000",
					backgroundOpacity: 0.9,
					labelBoxBorderColor: "#000000",
					position: "nw"
				},
				grid: {
					hoverable: true,
					borderWidth: 3,
					mouseActiveRadius: 50,
					backgroundColor: { colors: ["#ffffff", "#EDF5FF"] },
					axisMargin: 20,
					margin: {
						top: 10,
						left: 10,
						bottom: 10,
						right: 10
					}
				}
			};

			$.plot(graph, dataset, options);
			$(graph).UseTooltip();
		
		}); // end graphs.each
	
	}; // end setup_graphs()
	
	
	setup_datepickers();
	setup_graphs();
	
}(jQuery);


