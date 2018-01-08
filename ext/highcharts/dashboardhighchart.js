    Highcharts.chart('sample-chart',{
        chart:{type:'pie',options3d:{
            enabled:true,alpha:55,beta:0
        }},
        title:{text:''},
        credits:{enabled:false},
        tooltip:{pointFormat:'{series.name}:<b>{point.percentage:.1f}%</b>'},
        plotOptions:{pie:{allowPointSelect:true,cursor:'pointer',depth:35,dataLabels:{enabled:true,format:'{point.name}'},}},
       exporting: {
         enabled: false
            },
        series:[{
            type:'pie', 
            name:'Status Percentage',
            data:[{
                name:'Active',
                y:81,
                color:'#fc79ea'
                
            },{name:'Closed',
            y:19,
            sliced:true,
                selected:true,
               color:'#333333' 
            }]
        }]
    });